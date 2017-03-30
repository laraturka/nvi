<?php

namespace Laraturka\nvi;

use SoapClient;

class nvi
{

    /**
     * @param $TCKimlikNo TAM SAYI OLMALI
     * @param $Ad BUYUK HARF OLMALI
     * @param $Soyad BUYUK HARF OLMALI
     * @param $DogumYili TAM SAYI OLMALI
     * @return bool
     */
    public function tcknDogrula($TCKimlikNo, $Ad, $Soyad, $DogumYili)
    {

        if(!$this->tcknKontrol($TCKimlikNo)) return false;

        $soap = new SoapClient("https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL");

        $data = [
            "TCKimlikNo" => intval($TCKimlikNo),
            "Ad" => $Ad,
            "Soyad" => $Soyad,
            "DogumYili" => intval($DogumYili)
        ];

        $r = $soap->TCKimlikNoDogrula($data);

        return $r->TCKimlikNoDogrulaResult === true;
    }

    public function tcknKontrol($TCKimlikNo)
    {
        if (strlen($TCKimlikNo) != 11) return false;
        if ($TCKimlikNo[10] % 2 != 0) return false;
        $kont1 = ($TCKimlikNo[0] + $TCKimlikNo[2] + $TCKimlikNo[4] + $TCKimlikNo[6] + $TCKimlikNo[8]) * 7;
        $kont2 = ($TCKimlikNo[1] + $TCKimlikNo[3] + $TCKimlikNo[5] + $TCKimlikNo[7]);
        $kontrol2 = ($TCKimlikNo[0] + $TCKimlikNo[2] + $TCKimlikNo[4] + $TCKimlikNo[6] + $TCKimlikNo[8] + $TCKimlikNo[9] + $kont2) % 10;
        $kontrol1 = ($kont1 - $kont2) % 10;
        if ($kontrol1 < 0) $kontrol1 = 10 + $kontrol1;
        if ($TCKimlikNo[9] != $kontrol1) return false;
        if ($TCKimlikNo[10] != $kontrol2) return false;
        return true;
    }


}