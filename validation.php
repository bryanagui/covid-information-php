<?php

function isPasswordValid($pw, $hpw)
{
    return !($pw != password_verify($pw, $hpw));
}

function isLoginEmpty($usr, $pw)
{
    return empty($usr) || empty($pw);
}

function isRegistrationEmpty($email, $file_input)
{
    return empty($email) || empty($file_input);
}

function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function isPasswordConfirmed($password, $confirm_password)
{
    return $password === $confirm_password;
}
