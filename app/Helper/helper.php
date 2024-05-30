<?php

use Illuminate\Support\Facades\Mail;

function send_mail($to, $subject, $string): bool
{
    $from = 'no-reply@christian-business-finder.com';
    $from = 'mak.muhammadadil@gmail.com';

    // To send HTML mail, the Content-type header must be set
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    // Create email headers
    $headers .= 'From: ' . $from . "\r\n" .
        'Reply-To: ' . $from . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $html = $string;

    // Sending email
//    Mail::send([], [], function ($message) use ($to, $subject, $html) {
//        $message
//            ->to($to)
//            ->subject($subject)
//            ->setBody($html, 'text/html');
//    });

    Mail::send([], [], function ($message) use ($to, $subject, $html, $from) {
        $message
            ->to($to)
            ->subject($subject)
            ->replyTo($from)
            ->setBody($html, 'text/html');
    });

    if (Mail::failures()) {
        return false;
    }

    return true;
}
