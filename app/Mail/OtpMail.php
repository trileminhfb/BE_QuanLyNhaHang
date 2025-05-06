<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $name;

    public function __construct($otp, $name = 'Khách hàng')
    {
        $this->otp = $otp;
        $this->name = $name;
    }

    public function build()
    {
        return $this->subject('Mã OTP của bạn')
                    ->view('emails.otp')
                    ->with([
                        'otp' => $this->otp,
                        'name' => $this->name
                    ]);
    }
}
