<?php

function setSession($key, $data)
{
    $_SESSION[$key] = serialize($data);
}

function getSession($key)
{
    return unserialize($_SESSION[$key]);
}