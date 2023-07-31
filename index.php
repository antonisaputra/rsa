<?php

function encRSA($M)
{
    $data[0] = 1;
    for ($i = 0; $i < 35; $i++) {
        $rest[$i] = pow($M, 1) % 119;
        if ($data[$i] > 199) {
            $data[$i + 1] = $data[$i] * $rest[$i] % 119;
        } else {
            $data[$i + 1] = $data[$i] * $rest[$i];
        }
    }
    $get = $data[35] % 199;
    return $get;
}

function decRSA($E)
{
    $data[0] = 1;
    for ($i = 0; $i < 11; $i++) {
        $rest[$i] = pow($E, 1) % 119;
        if ($data[$i] > 199) {
            $data[$i + 1] = $data[$i] * $rest[$i] % 119;
        } else {
            $data[$i + 1] = $data[$i] * $rest[$i];
        }
    }
    $get = $data[11] % 199;
    return $get;
}

// $b = encRSA(12);
// $c = decRSA($b);

$kalimat = 'Salma Farijal Rizky';

// encrypt
for ($i = 0; $i < strlen($kalimat); $i++) {
    $m = ord($kalimat[$i]);
    if ($m <= 199) {
        $enc = $enc . chr(encRSA($m));
    } else {
        $enc = $enc . $kalimat[$i];
    }
}
for ($i = 0; $i < strlen($kalimat); $i++) {
    $m = ord($enc[$i]);
    if ($m <= 199) {
        $dec = $dec . chr(decRSA($m));
    } else {
        $dec = $dec . $enc[$i];
    }
}


echo $enc . '</br>' . $dec;
