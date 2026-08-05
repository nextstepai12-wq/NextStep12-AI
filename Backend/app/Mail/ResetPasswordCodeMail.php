<?php
// app/Mail/ResetPasswordCodeMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function build()
    {
        return $this->subject('رمز إعادة تعيين كلمة المرور — NextStep AI')
            ->view('emails.reset-password-code')
            ->with(['code' => $this->code]);
    }
}
