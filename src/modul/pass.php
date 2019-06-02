<?php

function hash_password($password)
{
    $salt = mcrypt_create_iv(32, MCRYPT_DEV_URANDOM);
    return hash('sha256', $password . $salt) . ':' . base64_encode($salt);
}

function check_password($password, $hash)
{
    list($hash, $salt) = explode(':', $hash, 2);
    return hash('sha256', $password . base64_decode($salt)) === $hash;
}

function generate_recovery_key_password()
{
    return base64_encode(mcrypt_create_iv(64, MCRYPT_DEV_URANDOM));
}