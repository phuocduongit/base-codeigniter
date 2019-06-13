<?php

function get_token_csrf()
{
    $CI = &get_instance();
    $token = $CI->session->userdata("token_csrf");
    if ($token == null) {
        $token = md5(uniqid(rand(), true));
        $CI->session->set_userdata("token_csrf", $token);
    }
    return $token;
}

function remove_token_csrf()
{
    $CI = &get_instance();
    $CI->session->unset_userdata('token_csrf');
}

function check_token_csrf()
{
    $CI = &get_instance();
    $token = $CI->session->userdata("token_csrf");

    if (isset($_POST["csrf_name"]) &&  $token == $_POST["csrf_name"]) {
        remove_token_csrf();
        return TRUE;
    }
    remove_token_csrf();
    return TRUE;
}

function get_secrect_rand()
{
    return md5(uniqid(rand(), true));
}

function encrypted($value = "", $secret = "")
{
    $methods = openssl_get_cipher_methods();
    $textToEncrypt = $value;
    $secretKey = "coin" . $secret;
    // $iv = openssl_random_pseudo_bytes(16);
    $iv = "5rwWHvDrLoeATVg4";

    $method  = "AES-256-CFB";

    $encrypted = openssl_encrypt($textToEncrypt, $method, $secretKey, 0, $iv);
    return $encrypted;
}

function decrypted($value_encrypted = "", $secret = "")
{

    $methods = openssl_get_cipher_methods();
    $textToEncrypt = $value_encrypted;
    $secretKey = "coin" . $secret;
    // $iv = openssl_random_pseudo_bytes(16);
    $iv = "5rwWHvDrLoeATVg4";
    $method  = "AES-256-CFB";
    $decrypted = openssl_decrypt($value_encrypted, $method, $secretKey, 0, $iv);

    return $decrypted;
}

function getPasswordHash($str)
{
    return password_hash($str, PASSWORD_BCRYPT);
}