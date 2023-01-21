<?php

// Criptografar os dados de login no token
function encryptLogin($email, $password)
{
    $cipher = "AES-128-CBC";
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($email . ':' . $password, $cipher, TOKEN_SECRET, $options = OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext_raw, TOKEN_SECRET, $as_binary = true);
    return base64_encode($iv . $hmac . $ciphertext_raw);
}

function decryptLogin()
{
    $cipher = "AES-128-CBC";
    // Recuperar o cookie
    $ciphertext = $_COOKIE['login_data'];

    //Decodifica os dados criptografados
    $c = base64_decode($ciphertext);

    // Recupera o tamanho do vetor de inicialização (IV)
    $ivlen = openssl_cipher_iv_length($cipher);

    // Recupera o vetor de inicialização (IV)
    $iv = substr($c, 0, $ivlen);

    // Recupera o hash HMAC
    $hmac = substr($c, $ivlen, $sha2len = 32);

    // Recupera o texto cifrado
    $ciphertext_raw = substr($c, $ivlen + $sha2len);

    // Verifica se o hash HMAC é válido
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, TOKEN_SECRET, $options = OPENSSL_RAW_DATA, $iv);
    $calcmac = hash_hmac('sha256', $ciphertext_raw, TOKEN_SECRET, $as_binary = true);
    if (hash_equals($hmac, $calcmac)) {
        // Decodifica os dados 
        list($email, $password) = explode(':', $original_plaintext);
        return ['email' => $email, 'password' => $password];
    } else {
        // Dados inválidos
        return null;
    }
}
