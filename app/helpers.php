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

function filterChildrenBelow5Years($children) {
    $arrayChildren = array();
    foreach($children as $child) {
        $umur = getUmur($child['tgl_lahir']);
        $year = explode(',', $umur);
        $year = explode(' ', $year[0]);
        $year = (int) $year[0];
        // $child['umur'] = $umur;
        // $child['year'] = explode(' ', explode(',', $umur)[0]);
        if($year >= 5) {
            continue;
        } else {
            array_push($arrayChildren, $child);
        }
    }
    // dd($arrayChildren);
    return collect($arrayChildren);
}

function getKategori($jenisKelamin, $bb, $tgl_lahir) {
    $path = './../public/data_table_who_child_growth_curve/zscore.json';
    $jsonString = file_get_contents($path);
    $jsonData = json_decode($jsonString, true);

    $d1=new DateTime(); // now
    $d2=new DateTime($tgl_lahir);                                  
    $months = $d2->diff($d1); 
    $usiaDalamBulan = (($months->y) * 12) + ($months->m);
    if($usiaDalamBulan > 60) {
        return "anak sudah lebih dari 5 tahun";
    }
    $usiaDalamBulan = (string)$usiaDalamBulan;
    $status = null;

    if($jsonData[$jenisKelamin][$usiaDalamBulan]['SD3neg'] >= $bb) {
        if($usiaDalamBulan < 24) {
            $status = 'stunting';
        } else {
            $status = 'gizi buruk';
        }
    } else if ($jsonData[$jenisKelamin][$usiaDalamBulan]['SD2neg'] >= $bb) {
        if($usiaDalamBulan < 24) {
            $status = 'stunting';
        } else {
            $status = 'kurang gizi';
        }
    } else if ($jsonData[$jenisKelamin][$usiaDalamBulan]['SD1neg'] >= $bb) {
        $status = 'normal';
    } else if ($jsonData[$jenisKelamin][$usiaDalamBulan]['SD0'] >= $bb) {
        $status = 'normal';
    } else if ($jsonData[$jenisKelamin][$usiaDalamBulan]['SD1'] >= $bb) {
        $status = 'normal';
    } else if ($jsonData[$jenisKelamin][$usiaDalamBulan]['SD2'] >= $bb) {
        $status = 'normal';
    } else {
        $status = 'obesitas';
    }
    return $status;
}