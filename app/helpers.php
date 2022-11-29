<?php

use M\Exception\RuntimeErrorException;

/**
 * @param $message
 */
function dd($message)
{
    !d($message);
    die;
}