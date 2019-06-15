<?php

function config_Mail()
{
    $CI = &get_instance();
    $CI->load->module('admin');
    $CI->load->model("M_ConfigEmail");
    $db_info = $CI->M_ConfigEmail->GetOne('1');
    if ($db_info["email"] == "") {
        return false;
    }

    $config = array(
        'charset'   => $db_info["charset"],
        'mailtype'  => $db_info["mailtype"],
        'wordwrap'  => 'true',
        'protocol'  => $db_info["protocol"],          // Gửi bằng Gmail
        //'protocol'  => 'sendmail',    // Gửi bằng Mail khác
        'smtp_host' => $db_info["smtp_server"],
        'smtp_port' =>  $db_info["smtp_port"],
        'smtp_user' =>  $db_info["email"],
        'smtp_pass' => $db_info["password"],
        'smtp_timeout' => $db_info["smtp_timeout"],
        'validate'  => true
    );

    $CI->load->library('email', $config);
    $CI->email->initialize($config);
    $CI->email->set_newline("\r\n");
    return $CI->email;
}

/**
 * Hàm dùng để gửi mail.
 * @param $to $to : Mảng Email của người nhận
 * @param $subject $subject : Tiêu đề email
 * @param $data $data : mảng các dữ liệu cần truyền vào template giống như khi truyền vào view
 * @param $template $template: view template của email nằm trong application/views/email_template
 */

function sendMail($to = array(), $subject = "", $data = array(), $template = "default")
{
    $CI = &get_instance();

    $CI->load->library('PHPMailer_Library');
    $mailer_lib = new PHPMailer_Library();
    $mail = $mailer_lib->getInstanceGmail();
    $mail->setFrom('support@bittrextool.com', 'Tính hiệu tradecoin');
    $mail->isHTML(true);

    $mail->Subject = $subject;
    $body = $CI->load->view('email_template/' . $template, $data, TRUE);
    $mail->Body    = $body;
    $mail->AltBody = $mail->Body;
    foreach ($to as $i) {
        $mail->addAddress($i);
    }

    try {
        if ($mail->send()) {
            return true;
        } else {
            throw new Exception("Can't send email.", 1);
        }
    } catch (Exception $e) {
        return $e->getMessage();
    }

    // $CI->load->library('email'); // Note: no $config param needed
    // $CI->email->from('commondevteam2012@gmail.com');
    // $CI->email->to($to);
    // $CI->email->subject($subject);
    // if(!isset($data["title"]))
    //     $data["title"]=$subject;
    // $body = $CI->load->view('email_template/'.$template,$data,TRUE);
    // $CI->email->message($body);
    // return $CI->email->send();
}
function template_parser($html, $parser, $_openingTag = "{{", $_closingTag = "}}")
{
    foreach ($parser as $key => $value) {
        $html = str_replace($_openingTag . $key . $_closingTag, $value, $html);
    }
    return $html;
}

function sendMailAWS($to = array(), $subject = "", $data = array(), $template = "default")
{
    $CI = &get_instance();
    $CI->load->library('aws');
    //get credentials at http://aws.amazon.com My Account / Console > Security Credentials
    $aws = new aws('AKIAJ57FTZFDOYZLGRKA', '/tWm/hqbvVBoWwhUt3zPo1KWGPFx2eOdHyRPmoUz', "email.eu-west-1.amazonaws.com");
    $m = new SimpleEmailServiceMessage();
    foreach ($to as $i) {
        $m->addTo($i);
    }
    $m->setFrom('hotro.tinhieutradecoin@gmail.com');
    $m->setSubject($subject);

    $body = $CI->load->view('email_template/' . $template, $data, TRUE);
    $m->setMessageFromString(null, $body);;

    try {
        if ($aws->sendEmail($m)) {
            return true;
        } else {
            throw new Exception("Can't send email.", 1);
        }
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

function sendMailZoho($to = array(), $subject = "", $data = array(), $template = "default")
{
    $CI = &get_instance();

    //     $filename = '/img/photo1.jpg';
    // $this->email->attach($filename);


    $CI->load->library('PHPMailer_Library');
    $mailer_lib = new PHPMailer_Library();
    $mail = $mailer_lib->getInstanceZoho();
    $mail->setFrom('sale@bittrextool.com', 'Thả Tim Dạo');
    $mail->isHTML(true);

    $mail->Subject = $subject;
    $body = $CI->load->view('email_template/' . $template, $data, TRUE);
    $mail->Body    = $body;
    //$mail->AltBody = $mail->Body;
    foreach ($to as $i) {
        $mail->addAddress($i);
    }

    try {
        if ($mail->send()) {
            return true;
        } else {
            throw new Exception("Can't send email.", 1);
        }
    } catch (Exception $e) {
        return $e->getMessage();
    }

    // $CI->load->library('email'); // Note: no $config param needed
    // $CI->email->from('commondevteam2012@gmail.com');
    // $CI->email->to($to);
    // $CI->email->subject($subject);
    // if(!isset($data["title"]))
    //     $data["title"]=$subject;
    // $body = $CI->load->view('email_template/'.$template,$data,TRUE);
    // $CI->email->message($body);
    // return $CI->email->send();
}

function send_mail_default($to = array(), $subject = "", $content = "default")
{
    $CI = &get_instance();

    //     $filename = '/img/photo1.jpg';
    // $this->email->attach($filename);


    $CI->load->library('PHPMailer_Library');
    $mailer_lib = new PHPMailer_Library();
    $mail = $mailer_lib->getInstanceGmail();
    $mail->setFrom('commondevteam2012@gmail.com', 'Thả Tim Dạo');
    $mail->isHTML(true);

    $mail->Subject = $subject;
    $mail->Body    = $content;;
    $mail->AltBody = $mail->Body;

    foreach ($to as $i) {
        $mail->addAddress($i);
    }

    try {
        if ($mail->send()) {
            return true;
        } else {
            throw new Exception("Can't send email.", 1);
        }
    } catch (Exception $e) {
        return $e->getMessage();
    }
}