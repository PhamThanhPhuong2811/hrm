<?php

namespace App\Http\Controllers\NhanVien;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Http\Controllers\Controller;


class Guimail extends Controller
{
    public function index(Request $request)
    {
        $title = "Gửi mail";
        
        return view('NhanVien.sendmail',compact('title'));
    }
    public function store(Request $request)
{
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = env('MAIL_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
        $mail->SMTPSecure = env('MAIL_ENCRYPTION');
        $mail->Port = env('MAIL_PORT');
        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $mail->addAddress($request->email);

        // Đặt mã hóa nội bộ của PHPMailer thành UTF-8
        $mail->CharSet = 'UTF-8';

        $mail->isHTML(true);
        $mail->Subject = $request->subject;
        $mail->Body = $request->body;

        if ($mail->send()) {
            $notification = notify('Email đã được gửi.');
            return back()->with($notification);
        } else {
            $notification = notify('Email không được gửi.')->withErrors($mail->ErrorInfo);
            return back()->with($notification);
        }
    } catch (Exception $e) {
        return back()->with('Không thể gửi tin nhắn.')->withErrors($mail->ErrorInfo);
    }
}    
}
