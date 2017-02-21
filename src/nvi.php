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
    public function tcknDogrula($TCKimlikNo, $Ad, $Soyad, $DogumYili )
    {
        $soap = new SoapClient("https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL");

        $data = [
            "TCKimlikNo" => intval( $TCKimlikNo ),
            "Ad" => $Ad,
            "Soyad" => $Soyad,
            "DogumYili" => intval( $DogumYili )
        ];

        $r = $soap->TCKimlikNoDogrula($data);

        return $r->TCKimlikNoDogrulaResult === true ;
    }


}