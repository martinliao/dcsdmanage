<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function sendMail($mail_data = array())
{
    if (isset($mail_data['email']) && !empty($mail_data['email'])) {
        include_once('resource/mailer/class.phpmailer.php');
        include_once('resource/mailer/class.smtp.php');

        $mail = new PHPMailer();
        // 使用 SMTP
        $mail->IsSMTP();
        $body  = $mail_data['body'];
        $body .= "<br><br><br><br><font color='red'>此封信件為系統發出的信件，請勿直接回覆，謝謝！</font>";
        $mail->SMTPAuth = true;
        $mail->setFrom('from@elearning.taipei', '臺北e大');
        if ((strcmp(ENVIRONMENT, 'production') != 0)) {
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;
            $mail->Username = "martin@click-ap.com";
            $mail->Password = "ydkyfthymoocycvp";
        } else {
            $mail->Host = "210.69.61.208"; // SMTP server
            $mail->Port = 25;
            $mail->Username = "pstc_apdd";
            $mail->Password = "pstc#2347";
        }
        $mail->Subject  = $mail_data['title'];
        $mail->CharSet = "UTF-8"; //設定郵件編碼 
        $mail->Encoding = "base64";
        $mail->Body = $body;
        $mail->IsHTML(true);
        $mail->ClearAddresses();
        $mail->AddAddress($mail_data['email']);
        $mail->Send();
    }
}
