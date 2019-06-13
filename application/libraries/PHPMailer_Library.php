<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__.'/../third_party/PHPMailer/src/Exception.php';
require __DIR__.'/../third_party/PHPMailer/src/PHPMailer.php';
require __DIR__.'/../third_party/PHPMailer/src/SMTP.php';

class PHPMailer_Library extends PHPMailer
{
    public static $mailer_instance;
    
    public function __construct()
    {
        parent::__construct();
        // log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function getInstance()
    {
        if (self::$mailer_instance == null) {
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'email-smtp.us-west-2.amazonaws.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'AKIAIEQ4GOEVVQNOXICA';                 // SMTP username
            $mail->Password = 'At91FKwBud2C6aPaAvoUEyRxjqjAW0RqNWZ0rJg7ecUE';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;

            // $mail = new PHPMailer(true);
            // $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            // $mail->isSMTP();                                      // Set mailer to use SMTP
            // $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            // $mail->SMTPAuth = true;                               // Enable SMTP authentication
            // $mail->Username = 'commondevteam2012@gmail.com';                 // SMTP username
            // $mail->Password = 'D987654321';                           // SMTP password
            // $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            // $mail->Port = 587;

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );;
            self::$mailer_instance = $mail;
        }

        return self::$mailer_instance;
    }

    public function getInstanceGmail()
    {
        if (self::$mailer_instance == null) {
            //$mail = new PHPMailer(true);
            // $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            // $mail->isSMTP();                                      // Set mailer to use SMTP
            // $mail->Host = 'email-smtp.us-west-2.amazonaws.com';  // Specify main and backup SMTP servers
            // $mail->SMTPAuth = true;                               // Enable SMTP authentication
            // $mail->Username = 'AKIAIEQ4GOEVVQNOXICA';                 // SMTP username
            // $mail->Password = 'At91FKwBud2C6aPaAvoUEyRxjqjAW0RqNWZ0rJg7ecUE';                           // SMTP password
            // $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            // $mail->Port = 587;
            
            $mail = new PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'commondevteam2012@gmail.com';                 // SMTP username
            $mail->Password = 'D987654321';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );;
            self::$mailer_instance = $mail;
        }

        return self::$mailer_instance;
    }

    public function getInstanceZoho()
    {
        if (self::$mailer_instance == null) {
            //$mail = new PHPMailer(true);
            // $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            // $mail->isSMTP();                                      // Set mailer to use SMTP
            // $mail->Host = 'email-smtp.us-west-2.amazonaws.com';  // Specify main and backup SMTP servers
            // $mail->SMTPAuth = true;                               // Enable SMTP authentication
            // $mail->Username = 'AKIAIEQ4GOEVVQNOXICA';                 // SMTP username
            // $mail->Password = 'At91FKwBud2C6aPaAvoUEyRxjqjAW0RqNWZ0rJg7ecUE';                           // SMTP password
            // $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            // $mail->Port = 587;

            $mail = new PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.zoho.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'sale@bittrextool.com';                 // SMTP username
            $mail->Password = '123456789';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );;
            self::$mailer_instance = $mail;
        }

        return self::$mailer_instance;
    }
}