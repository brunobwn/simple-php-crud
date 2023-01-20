<?php

function setSession($key, $data)
{
    $_SESSION[$key] = json_encode($data);
}

function getSession($key)
{
    return json_decode($_SESSION[$key]);
}