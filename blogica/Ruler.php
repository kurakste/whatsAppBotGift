<?php

namespace Blogica\Roler;

define('EARTH_RADIUS', 6372795);

class Ruler {

    /*
    * Расстояние между двумя точками
    * $φA, $λA - широта, долгота 1-й точки,
    * $φB, $λB - широта, долгота 2-й точки
    * Написано по мотивам http://gis-lab.info/qa/great-circles.html
    * Михаил Кобзарев &amp;lt;mikhail@kobzarev.com&amp;gt;
    *
    */
    function calculateTheDistance ($φA, $λA, $φB, $λB) {
 
        // перевести координаты в радианы
        $lat1 = $φA * M_PI / 180;
        $lat2 = $φB * M_PI / 180;
        $long1 = $λA * M_PI / 180;
        $long2 = $λB * M_PI / 180;
         
        // косинусы и синусы широт и разницы долгот
        $cl1 = cos($lat1);
        $cl2 = cos($lat2);
        $sl1 = sin($lat1);
        $sl2 = sin($lat2);
        $delta = $long2 - $long1;
        $cdelta = cos($delta);
        $sdelta = sin($delta);
         
        // вычисления длины большого круга
        $y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
        $x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;
         
        //
        $ad = atan2($y, $x);
        $dist = $ad * EARTH_RADIUS;
         
        return $dist;
        }
}