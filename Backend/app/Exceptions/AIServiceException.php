<?php

namespace App\Exceptions;

use Exception;

/**
 * استثناء مخصص لأي فشل بالتواصل مع AI Service:
 * انقطاع اتصال، Timeout، استجابة غير ناجحة، أو JSON غير صالح.
 * نستخدمه لتمييز أخطاء AI Service عن أي استثناء آخر بالنظام،
 * ولإعطاء رسالة عربية واضحة لمستخدم الجامعة بدون كشف تفاصيل تقنية حساسة.
 */
class AIServiceException extends Exception
{
    //
}