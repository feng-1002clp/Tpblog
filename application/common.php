<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

//    注册自动发送邮件
function mailto($to, $title, $content)
{

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->CharSet = 'utf-8';
        $mail->Host = 'smtp.163.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'fzl18970254621@163.com';                     // SMTP username
        $mail->Password = 'CSSOHLITCGUPYBUE';                               // SMTP password
        $mail->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        // ssl 配合 465   tls 配合25
        //Recipients
        $mail->setFrom('fzl18970254621@163.com', '冯自力');
        $mail->addAddress($to);     // Add a recipient

        // Attachments
        //  $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $title;
        $mail->Body = $content;

        return $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        exception($mail->ErrorInfo, 1001);
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

//随机六位验证码
function random()
{
    $chars = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
    $charsLen = count($chars) - 1;
    shuffle($chars);
    $output = "";
    for ($i = 0; $i < 6; $i++) {
        $output .= $chars[mt_rand(0, $charsLen)];
    }
    return $output;
}

//把span标签转换为a标签
function labelchanged($data)
{
    return str_replace('span', 'a', $data);
}

//文章详情页将文章标签字符串转换为数组
function strToArray($data)
{
    return explode('|',$data);
}









