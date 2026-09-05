<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\StudentSurveyResponse;
use App\Models\SurveyQuestion;
use App\Models\Major;
use App\Models\RecommendationResult;

class RecommendationController extends Controller
{
    /**
     * احتساب نتائج التوصيات بناءً على إجابات الاستبيان وتخزين أعلى 3 تخصصات
     */
    public function generate(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'غير مصرح'], 401);
        }

        $userId = $user->id;

        // جلب إجابات الطالب الحالية
        $responses = StudentSurveyResponse::where('user_id', $userId)
            ->with(['question', 'selectedOption'])
            ->get();

        if ($responses->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'لم يتم العثور على أي إجابات استبيان للمستخدم.'
            ], 400);
        }

        // 1) حساب النقاط التي حصل عليها الطالب لكل رمز عائلي (البسط)
        $studentFamilyScores = [];
        foreach ($responses as $resp) {
            if (!$resp->selectedOption || !$resp->selectedOption->option_value) {
                continue;
            }

            $weights = json_decode($resp->selectedOption->option_value, true);
            if (is_array($weights)) {
                foreach ($weights as $familyCode => $score) {
                    $studentFamilyScores[$familyCode] = ($studentFamilyScores[$familyCode] ?? 0) + (float) $score;
                }
            }
        }

        // 2) حساب أقصى نقاط ممكنة لكل عائلة من الأسئلة النشطة لمجال الطالب (المقام)
        $interestIds = $responses->pluck('question.interest_id')->unique()->filter()->toArray();
        $questions = SurveyQuestion::whereIn('interest_id', $interestIds)
            ->where('is_active', true)
            ->with('options')
            ->get();

        $maxFamilyScores = [];
        foreach ($questions as $q) {
            $questionFamilyWeights = [];
            foreach ($q->options as $opt) {
                if (!$opt->option_value) continue;
                $weights = json_decode($opt->option_value, true);
                if (is_array($weights)) {
                    foreach ($weights as $fCode => $w) {
                        $questionFamilyWeights[$fCode][] = (float) $w;
                    }
                }
            }

            // بما إن الطالب يملك حق اختيار إجابتين كحد أقصى، فإن أقصى نقاط ممكنة هي مجموع أعلى وزنين
            foreach ($questionFamilyWeights as $fCode => $wList) {
                rsort($wList);
                $top2Sum = array_sum(array_slice($wList, 0, 2));
                $maxFamilyScores[$fCode] = ($maxFamilyScores[$fCode] ?? 0) + $top2Sum;
            }
        }

        // 3) حساب نسبة التوافق لكل عائلة
        $familyPercentages = [];
        foreach ($studentFamilyScores as $fCode => $score) {
            $maxScore = $maxFamilyScores[$fCode] ?? 0;
            if ($maxScore > 0) {
                $pct = min(100.00, ($score / $maxScore) * 100);
                $familyPercentages[$fCode] = round($pct, 2);
            }
        }

        if (empty($familyPercentages)) {
            return response()->json([
                'status' => 'error',
                'message' => 'تعذر احتساب النسبة المئوية للميول الأكاديمية.'
            ], 422);
        }

        // 4) مطابقة النسب مع التخصصات واختيار أفضل 3 توصيات
        $majors = Major::whereIn('family_code', array_keys($familyPercentages))
            ->with(['deanship', 'faculty'])
            ->get();

        $scoredMajors = $majors->map(function ($major) use ($familyPercentages) {
            $major->match_pct = $familyPercentages[$major->family_code] ?? 0;
            return $major;
        })->sortByDesc('match_pct')->values();

        $top3Majors = $scoredMajors->take(3);

        // 5) حفظ أفضل 3 توصيات بجدول recommendation_results مع مسح النتائج القديمة
        DB::transaction(function () use ($userId, $top3Majors) {
            RecommendationResult::where('user_id', $userId)->delete();

            foreach ($top3Majors as $major) {
                $aiFeedback = "بناءً على إجاباتك في الاستبيان، أظهرت نسبة توافق {$major->match_pct}% مع مجال {$major->title}، نظراً لمهاراتك واهتماماتك المميزة.";
                RecommendationResult::create([
                    'user_id' => $userId,
                    'major_id' => $major->id,
                    'match_percentage' => $major->match_pct,
                    'ai_feedback' => $aiFeedback,
                ]);
            }
        });

        return response()->json([
            'status' => 'success',
            'message' => 'تم احتساب التوصيات بنجاح 🚀',
            'total_recommendations' => $top3Majors->count(),
        ]);
    }

    /**
     * إرجاع أفضل 3 توصيات حالية للطالب الموثّق لعرضها في صفحة النتائج
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'غير مصرح'], 401);
        }

        $results = RecommendationResult::where('user_id', $user->id)
            ->with(['major.deanship', 'major.faculty'])
            ->orderBy('match_percentage', 'desc')
            ->get();

        if ($results->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'has_results' => false,
                'message' => 'لم تقم بإجراء الاستبيان بعد للحصول على التوصيات.',
                'recommendations' => [],
            ]);
        }

        $formatted = $results->map(function ($res) {
            $major = $res->major;
            $deanshipName = $major->deanship ? $major->deanship->name : ($major->faculty ? $major->faculty->name : 'جامعي');

            return [
                'id' => $res->id,
                'major_id' => $major->id,
                'title' => $major->title,
                'match_percentage' => (float) $res->match_percentage,
                'ai_feedback' => $res->ai_feedback,
                'description' => $major->description,
                'cover_image' => $major->cover_image,
                'deanship_name' => $deanshipName,
                'min_high_school_score' => (float) $major->min_high_school_score,
                'total_credit_hours' => $major->total_credit_hours,
                'credit_hour_fee' => (float) $major->credit_hour_fee,
                'career_opportunities' => $major->career_opportunities,
            ];
        });

        return response()->json([
            'status' => 'success',
            'has_results' => true,
            'top_match' => $formatted->first(),
            'recommendations' => $formatted,
        ]);
    }
}
