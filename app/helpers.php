<?php

function responseAPI($code, $message, $data) {
    return response([
        'code' => $code,
        'message' => $message,
        'data' => $data
    ], $code);
}

function getUser() {
    $user = auth()->user();
    if($user->role == 'kelurahan') { $user = $user->load('kelurahan'); }
    else if($user->role == 'posyandu') { $user = $user->load('posyandu'); }
    else if($user->role == 'puskesmas') { $user = $user->load('puskesmas'); }
    return $user;
}

function getUmur($birthDate) {
    $tglLahir = new DateTime($birthDate);
    $tglHariIni = new DateTime();
    $umur = $tglLahir->diff($tglHariIni);
    return $umur->format('%y tahun, %m bulan, %d hari');
}