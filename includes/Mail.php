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
        require INCLUDES_PATH . 'extentions/PHPMailer/PHPMailerAutoload.php';

    }

    public static function send($mailConfig=array(),$is_smtp=1)
    {
        // $mailConfig = $this->listAccounts[$accountPosition];

        $mailData=System::getMailSetting();

        if($mailData['send_method']=='local' || !isset($mailConfig['send_method']))
        {
            $is_smtp=0;
        }

        if(isset($mailConfig['send_method']))
        {
            if($mailConfig['send_method']=='local')
            {
                $is_smtp=0;
            }
            else
            {
                $is_smtp=1;
            }
            
        }

        if((int)$is_smtp==1 && !isset($mailConfig['smtpAddress']))
        {
            $mailConfig['smtpAddress']=$mailData['smtpAddress'];

            $mailConfig['smtpUser']=$mailData['smtpUser'];

            $mailConfig['smtpPass']=$mailData['smtpPass'];

            $mailConfig['smtpPort']=$mailData['smtpPort'];
        }

        if(!class_exists('PHPMailer'))
        {
            require INCLUDES_PATH . 'extentions/PHPMailer/PHPMailerAutoload.php';
        }


        $mail = new PHPMailer;

        // $mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mailConfig['smtpSecure']=isset($mailConfig['smtpSecure'])?$mailConfig['smtpSecure']:'ssl';

        $mailConfig['smtpPort']=isset($mailConfig['smtpPort'])?$mailConfig['smtpPort']:465;

        $mailConfig['fromEmail']=isset($mailConfig['fromEmail'])?$mailConfig['fromEmail']:$mailConfig['smtpUser'];

        $mailConfig['fromName']=isset($mailConfig['fromName'])?$mailConfig['fromName']:$mailConfig['smtpUser'];



        if(is_array($mailConfig['toEmail']))
        {
            $mailConfig['toEmail']="'".implode("','", $mailConfig['toEmail'])."'";
        }

        $mail->CharSet = 'UTF-8';

        if((int)$is_smtp==1)
        {
            $mail->isSMTP(); // Set mailer to use SMTP
        }
        
        $mail->Host = $mailConfig['smtpAddress']; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = $mailConfig['smtpUser']; // SMTP username
        $mail->Password = $mailConfig['smtpPass']; // SMTP password
        $mail->SMTPSecure = $mailConfig['smtpSecure'];  // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $mailConfig['smtpPort']; // TCP port to connect to

        $mail->From =  $mailConfig['fromEmail'];
        $mail->FromName = $mailConfig['fromName'];
        $mail->addAddress($mailConfig['toEmail']);               // Name is optional
        $mail->addReplyTo($mailConfig['smtpUser'],  $mailConfig['fromName']);

        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $mailConfig['subject'];
        $mail->Body    = $mailConfig['body'];


        if(isset($mailConfig['files']))
        {
            if(!is_array($mailConfig['files']) && preg_match('/.*?\.\w+/i', $mailConfig['files']))
            {
                $mail->addAttachment($mailConfig['files']);
            }
            else
            {
                $totalfiles=count($mailConfig['files']);

                for ($i=0; $i < $totalfiles; $i++) { 
                    $mail->addAttachment($mailConfig['files'][$i]);
                }
            }
        }

        if(!$mail->send()) {
            throw new Exception("Message could not be sent: ".$mail->ErrorInfo);
        } 

    }


}

?>