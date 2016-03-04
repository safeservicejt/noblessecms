<?php

class Mail
{

    private static $listAccounts = array();

    public static function verify($toemail, $fromemail, $getdetails = false){
        // print_r(Mail::verify('tctinhoc@gmail.com','safeservicejt@gmail.com')); | valid|invalid
        $details='';        
        $email_arr = explode("@", $toemail);
        $domain = array_slice($email_arr, -1);
        $domain = $domain[0];
        // Trim [ and ] from beginning and end of domain string, respectively
        $domain = ltrim($domain, "[");
        $domain = rtrim($domain, "]");
        if( "IPv6:" == substr($domain, 0, strlen("IPv6:")) ) {
            $domain = substr($domain, strlen("IPv6") + 1);
        }
        $mxhosts = array();
        if( filter_var($domain, FILTER_VALIDATE_IP) )
            $mx_ip = $domain;
        else
            getmxrr($domain, $mxhosts, $mxweight);
        if(!empty($mxhosts) )
            $mx_ip = $mxhosts[array_search(min($mxweight), $mxhosts)];
        else {
            if( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ) {
                $record_a = dns_get_record($domain, DNS_A);
            }
            elseif( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ) {
                $record_a = dns_get_record($domain, DNS_AAAA);
            }
            if( !empty($record_a) )
                $mx_ip = $record_a[0]['ip'];
            else {
                $result   = "invalid";
                $details .= "No suitable MX records found.";
                return ( (true == $getdetails) ? array($result, $details) : $result );
            }
        }



        $connect = @fsockopen($mx_ip, 25); 
        if($connect){ 
            if(preg_match("/^220/i", $out = fgets($connect, 1024))){
                fputs ($connect , "HELO $mx_ip\r\n"); 
                $out = fgets ($connect, 1024);
                $details .= $out."\n";
     
                fputs ($connect , "MAIL FROM: <$fromemail>\r\n"); 
                $from = fgets ($connect, 1024); 
                $details .= $from."\n";
                fputs ($connect , "RCPT TO: <$toemail>\r\n"); 
                $to = fgets ($connect, 1024);
                $details .= $to."\n";
                fputs ($connect , "QUIT"); 
                fclose($connect);
                if(!preg_match("/^250/i", $from) || !preg_match("/^250/i", $to)){
                    $result = "invalid"; 
                }
                else{
                    $result = "valid";
                }
            } 
        }
        else{
            $result = "invalid";
            $details .= "Could not connect to server";
        }
        if($getdetails){
            return array($result, $details);
        }
        else{
            return $result;
        }
    }

    public static function addAccount($config = array())
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

    public function test()
    {
         
    }

    public static function send($inputData=array())
    {

         $mailData=System::getMailSetting();
         
         // local|account|smtp
         $mailData['send_method']=isset($inputData['send_method'])?$inputData['send_method']:$mailData['send_method'];

         $mailData['smtpUser']=isset($inputData['smtpUser'])?$inputData['smtpUser']:$mailData['smtpUser'];

         $mailData['smtpPass']=isset($inputData['smtpPass'])?$inputData['smtpPass']:$mailData['smtpPass'];

         $mailData['smtpPort']=isset($inputData['smtpPort'])?$inputData['smtpPort']:$mailData['smtpPort'];

         $mailData['smtpSecure']=isset($mailData['smtpSecure'])?$mailData['smtpSecure']:'ssl';

         $mailData['smtpSecure']=isset($inputData['smtpSecure'])?$inputData['smtpSecure']:$mailData['smtpSecure'];

         $mailData['smtpAddress']=isset($inputData['smtpAddress'])?$inputData['smtpAddress']:$mailData['smtpAddress'];

         $mailData['fromEmail']=isset($inputData['fromEmail'])?$inputData['fromEmail']:$mailData['fromEmail'];

         $mailData['fromName']=isset($inputData['fromName'])?$inputData['fromName']:$mailData['fromName'];

         $mailData['toEmail']=isset($inputData['toEmail'])?$inputData['toEmail']:$mailData['toEmail'];

         $mailData['subject']=isset($inputData['subject'])?$inputData['subject']:$mailData['subject'];

         $mailData['body']=isset($inputData['body'])?$inputData['body']:$mailData['body'];

         $mailData['replyTo']=isset($mailData['replyTo'])?$mailData['replyTo']:$mailData['fromEmail'];
         
         $mailData['replyTo']=isset($inputData['replyTo'])?$inputData['replyTo']:$mailData['replyTo'];

         $mailData['replyName']=isset($mailData['replyName'])?$mailData['replyName']:$mailData['fromName'];

         $mailData['replyName']=isset($inputData['replyName'])?$inputData['replyName']:$mailData['replyName'];

         $mailData['bccTo']=isset($mailData['bccTo'])?$mailData['bccTo']:'';

         $mailData['bccTo']=isset($inputData['bccTo'])?$inputData['bccTo']:$mailData['bccTo'];

         $mailData['ccTo']=isset($mailData['ccTo'])?$mailData['ccTo']:'';

         $mailData['ccTo']=isset($inputData['ccTo'])?$inputData['ccTo']:$mailData['ccTo'];

         if(is_array($mailData['ccTo']))
         {
            $total=count($mailData['ccTo']);

            for ($i=0; $i < $total; $i++) { 
                $row=$mailData['ccTo'][$i];

                if(isset($row[4]))
                $mail->addCC($row);
            }
         }

         if(is_array($mailData['bccTo']))
         {
            $total=count($mailData['bccTo']);

            for ($i=0; $i < $total; $i++) { 
                $row=$mailData['bccTo'][$i];

                if(isset($row[4]))
                $mail->addBCC($row);
            }
         }

        if(!class_exists('PHPMailer'))
        {
            require INCLUDES_PATH . 'extentions/PHPMailer/PHPMailerAutoload.php';
        }


        $mail = new PHPMailer;

        $mail->CharSet = 'UTF-8';

        $mailData['send_method']=trim($mailData['send_method']);

        if($mailData['send_method']!='local')
        {
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->SMTPAuth = true; // Enable SMTP authentication 
            $mail->Host = $mailData['smtpAddress']; // Specify main and backup SMTP servers
            $mail->Username = $mailData['smtpUser']; // SMTP username
            $mail->Password = $mailData['smtpPass']; // SMTP password
            $mail->SMTPSecure = $mailData['smtpSecure'];  // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $mailData['smtpPort']; // TCP port to connect to
        }

       
        $mail->From =  $mailData['fromEmail'];
        $mail->FromName = $mailData['fromName'];

        if(is_array($mailData['toEmail']))
        {
            $total=count($mailData['toEmail']);

            for ($i=0; $i < $total; $i++) { 
                $mail->addAddress($mailData['toEmail'][$i]);               // Name is optional
            }
        }
        else
        {
            $mail->addAddress($mailData['toEmail']); 
        }

        // $mail->addAddress($mailData['toEmail']);               // Name is optional

        $mail->addReplyTo($mailData['smtpUser'],  $mailData['fromName']);

        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $mailData['subject'];
        $mail->Body    = $mailData['body'];


        if(isset($mailData['files']))
        {
            if(!is_array($mailData['files']) && preg_match('/.*?\.\w+/i', $mailData['files']))
            {
                $mail->addAttachment($mailData['files']);
            }
            else
            {
                $totalfiles=count($mailData['files']);

                for ($i=0; $i < $totalfiles; $i++) { 
                    $mail->addAttachment($mailData['files'][$i]);
                }
            }
        }

        if(!$mail->send()) {
            throw new Exception("Message could not be sent: ".$mail->ErrorInfo);
        }        
    }


}