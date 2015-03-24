<?php

class Mail
{

    private static $listAccounts = array();

    public function hasSend()
    {
        if(Session::has('forgotPassword'))
        {
            return true;
        }

        return false;
    }

    public function addAccount($config = array())
    {

        $total = count($config);

        self::$listAccounts[] = $config;

        /*
        $post=array(
            'Host'=>'smtp1.example.com;smtp2.example.com',
            'Username'=>'username',
            'Password'=>'password',
            'SMTPSecure'=>'tls',
            'Port'=>587
        );

        Mail::addAccount($post);


        $post=array(
            'Host'=>'smtp1.example.com;smtp2.example.com',
            'Username'=>'username',
            'Password'=>'password',
            'SMTPSecure'=>'tls',
            'Port'=>587
        );

        Mail::addAccount($post);

        */


    }

    public function sendMailFromLocal($post=array())
    {

        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        $headers .= 'To: '.$post['toName'].' <'.$post['toEmail'].'>' . "\r\n";
        $headers .= 'From: '.$post['fromName'].' <'.$post['fromEmail'].'>' . "\r\n";

        // Mail it
        if(mail($post['toEmail'], $post['subject'], $post['message'], $headers))
        {
            // Session::make('forgotPassword','1');

            return true;
        }        


        return false;
    }


    public function sendMail($mailConfig = array())
    {
        // $mailConfig = $this->listAccounts[$accountPosition];

        require INCLUDES_PATH . 'extentions/PHPMailer/PHPMailerAutoload.php';

        $mail = new PHPMailer;


//$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = $mailConfig['smtpAddress']; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = $mailConfig['smtpUser']; // SMTP username
        $mail->Password = $mailConfig['smtpPass']; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $mailConfig['smtpPort']; // TCP port to connect to


        
        $mail->From = $mailConfig['fromEmail'];
        $mail->FromName = $mailConfig['fromName'];
        $mail->addAddress($mailConfig['toEmail'], $mailConfig['toName']);     // Add a recipient
        // $mail->addAddress('ellen@example.com');               // Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $mailConfig['subject'];
        $mail->Body    = $mailConfig['message'];
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()) {
            return false;
            // echo 'Message could not be sent.';
            // echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
           return true;
        }

        return $mail;


    }


}

?>