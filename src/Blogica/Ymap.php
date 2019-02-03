<?php

namespace Viber\Blogica;

/**
 * It use Yandex Map API to get address by position.
 * 
 * @author Stepan Kurakin kurakste@gmail.com
 * 
 */

class Ymap 
{
    public static function getAddresByPos($lat, $lon ) {
        $http = new \GuzzleHttp\Client();

        // $res =$http->request('GET', 'https://geocode-maps.yandex.ru/1.x/', 
        //     [
        //         'query' =>'apikey=b7694597-95c8-40e9-ba59-f57ac4a1f3af&'.
        //         'geocode='.$lat.','.$lon.'&'.
        //         'format=json'
        //     ]
        // );
        // $res = $http->request('GET', 'www.rbc.ru');

        $adr = 'https://geocode-maps.yandex.ru/1.x/'.
                '?apikey=b7694597-95c8-40e9-ba59-f57ac4a1f3af&'.
                '&geocode='.$lat.','.$lon.'&'.
                'format=json';
        $res = json_decode(file_get_contents($adr), $assoc = true);

        vd($res['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['GeocoderMetaData']);


    }
    
}
