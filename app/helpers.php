<?php

function responseAPI($code, $message, $data) {
    return [
        'code' => $code,
        'message' => $message,
        'data' => $data
    ];
}