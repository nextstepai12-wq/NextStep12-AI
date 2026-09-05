<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionOption;
use App\Models\StudentSurveyResponse;

class SurveyController extends Controller
{
    /**
     * جلب أسئلة الاستبيان الخاصة بميل الطالب الأكاديمي
     */
    public function getQuestions(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'غير مصرح'], 401);
        }

        // جلب ميول الطالب الموثّق
        $userInterests = $user->academicInterests;

        if ($userInterests->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'لم تقم بتحديد أي ميول أكاديمية بعد في حسابك.'
            ], 400);
        }

        $interestId = $request->query('interest_id');

        if ($interestId) {
            $interestId = (int) $interestId;
            $userInterestIds = $userInterests->pluck('id')->toArray();
            if (!in_array($interestId, $userInterestIds)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'الميل الأكاديمي المطلوب غير مصرح به لهذا الطالب.'
                ], 403);
            }
        } else {
            // اختيار أول ميل مسجل للطالب تلقائياً
            $interestId = $userInterests->first()->id;
        }

        $totalActive = SurveyQuestion::where('interest_id', $interestId)
            ->where('is_active', true)
            ->count();

        // نستخدم ceil حتى تمثل المحاولة نصف الأسئلة المتاحة، مقربة إلى الأعلى.
        $questionsLimit = (int) ceil($totalActive * 0.5);

        // الاختيار عشوائي هنا فقط؛ تبقى المجموعة ثابتة في الواجهة حتى الإرسال.
        $questions = SurveyQuestion::where('interest_id', $interestId)
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit($questionsLimit)
            ->with(['options' => function ($query) {
                $query->select('id', 'question_id', 'option_text');
            }])
            ->get(['id', 'question_text', 'type', 'order_index'])
            ->sortBy([['order_index', 'asc'], ['id', 'asc']])
            ->values();

        // صياغة الاستجابة وتصفية الحقول الحساسة (عدم إرسال weight_score أو option_value)
        $formattedQuestions = $questions->map(function ($q) {
            return [
                'id' => $q->id,
                'text' => $q->question_text,
                'type' => $q->type,
                'options' => $q->options->map(function ($opt) {
                    return [
                        'id' => $opt->id,
                        'text' => $opt->option_text,
                    ];
                })->values()->toArray(),
            ];
        });

        $attemptToken = Crypt::encryptString(json_encode([
            'user_id' => $user->id,
            'interest_id' => $interestId,
            'question_ids' => $questions->pluck('id')->values()->all(),
        ], JSON_THROW_ON_ERROR));

        return response()->json([
            'status' => 'success',
            'interest_id' => $interestId,
            'total' => $questionsLimit,
            'attempt_token' => $attemptToken,
            'questions' => $formattedQuestions,
        ]);
    }

    /**
     * حفظ إجابات الطالب في قاعدة البيانات (تدعم اختيار إجابة واحدة أو إجابتين كحد أقصى لكل سؤال)
     */
    public function submitResponses(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'غير مصرح'], 401);
        }

        $validator = Validator::make($request->all(), [
            'interest_id' => 'required|integer',
            'attempt_token' => 'required|string',
            'answers' => 'required|array|min:1',
            'answers.*.question_id' => 'required|integer|exists:survey_questions,id',
            'answers.*.selected_option_ids' => 'required|array|min:1|max:2',
            'answers.*.selected_option_ids.*' => 'required|integer|exists:survey_question_options,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'بيانات الإدخال غير صالحة.',
                'errors' => $validator->errors()
            ], 422);
        }

        $interestId = (int) $request->interest_id;

        try {
            $attempt = json_decode(Crypt::decryptString($request->attempt_token), true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'محاولة الاستبيان غير صالحة أو منتهية.',
            ], 422);
        }

        $attemptQuestionIds = array_values(array_unique(array_map('intval', $attempt['question_ids'] ?? [])));
        if ((int) ($attempt['user_id'] ?? 0) !== (int) $user->id
            || (int) ($attempt['interest_id'] ?? 0) !== $interestId
            || empty($attemptQuestionIds)) {
            return response()->json([
                'status' => 'error',
                'message' => 'محاولة الاستبيان غير صالحة.',
            ], 422);
        }

        // التحقق من أن المجال المطلوب يخص هذا الطالب
        $userInterestIds = $user->academicInterests()->pluck('academic_interests.id')->toArray();
        if (!in_array($interestId, $userInterestIds)) {
            return response()->json([
                'status' => 'error',
                'message' => 'الميل الأكاديمي المحدد غير مصرح به لهذا الطالب.'
            ], 403);
        }

        // لا نقبل إلا الأسئلة التي كانت ضمن المجموعة الموقعة لهذه المحاولة.
        $validQuestionIds = SurveyQuestion::whereIn('id', $attemptQuestionIds)
            ->where('interest_id', $interestId)
            ->where('is_active', true)
            ->pluck('id')
            ->toArray();

        $submittedQuestionIds = array_column($request->answers, 'question_id');

        if (count($submittedQuestionIds) !== count(array_unique($submittedQuestionIds))
            || count($submittedQuestionIds) !== count($attemptQuestionIds)
            || count($validQuestionIds) !== count($attemptQuestionIds)
            || !empty(array_diff($attemptQuestionIds, $submittedQuestionIds))
            || !empty(array_diff($submittedQuestionIds, $attemptQuestionIds))) {
            return response()->json([
                'status' => 'error',
                'message' => 'يرجى الإجابة على جميع أسئلة هذه المحاولة قبل الإنهاء.',
            ], 422);
        }

        // التحقق من أن كل الأسئلة تنتمي لنفس المجال
        foreach ($submittedQuestionIds as $qId) {
            if (!in_array($qId, $validQuestionIds)) {
                return response()->json([
                    'status' => 'error',
                    'message' => "السؤال رقم {$qId} لا ينتمي إلى هذا المجال الأكاديمي."
                ], 422);
            }
        }

        $optionQuestionIds = SurveyQuestionOption::whereIn(
            'id',
            collect($request->answers)->pluck('selected_option_ids')->flatten()->unique()->values()
        )->pluck('question_id', 'id');

        foreach ($request->answers as $answer) {
            foreach (array_unique($answer['selected_option_ids']) as $optionId) {
                if ((int) $optionQuestionIds->get($optionId, 0) !== (int) $answer['question_id']) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'أحد الخيارات لا ينتمي إلى السؤال المحدد.',
                    ], 422);
                }
            }
        }

        // تخزين الإجابات بقاعدة البيانات بأمان (حذف القديم لنفس الأسئلة أولاً ثم إنشاء صفوف جديدة لكل خيار)
        $userId = $user->id;
        DB::transaction(function () use ($userId, $attemptQuestionIds, $request) {
            // حذف أي إجابات سابقة لنفس الأسئلة لمنع التراكم عند إعادة الاستبيان
            StudentSurveyResponse::where('user_id', $userId)
            ->whereIn('question_id', $attemptQuestionIds)
                ->delete();

            foreach ($request->answers as $ans) {
                foreach ($ans['selected_option_ids'] as $optionId) {
                    StudentSurveyResponse::create([
                        'user_id' => $userId,
                        'question_id' => $ans['question_id'],
                        'selected_option_id' => $optionId,
                    ]);
                }
            }
        });

        return response()->json([
            'status' => 'success',
            'message' => 'تم حفظ إجاباتك بنجاح 🎉',
        ]);
    }
}
