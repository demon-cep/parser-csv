<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 10.09.2018
 * Time: 18:25
 */

namespace lib;


class Translit extends Setting
{
    function Transliterate($string)
    {
        $cyr=array(
            "Щ",  "Ш", "Ч", "Ц","Ю", "Я", "Ж", "А","Б","В","Г","Д","Е","Ё","З","И","Й","К","Л","М","Н","О","П","Р","С","Т","У","Ф","Х", "Ь","Ы","Ъ","Э","Є","Ї",
            "щ",  "ш", "ч", "ц","ю", "я", "ж", "а","б","в","г","д","е","ё","з","и","й","к","л","м","н","о","п","р","с","т","у","ф","х", "ь","ы","ъ","э","є","ї",
            "'",'.','(',')','-','/',
        );
        $lat=array(
            "Shh","Sh","Ch","C","Ju","Ja","Zh","A","B","V","G","D","Je","Jo","Z","I","J","K","L","M","N","O","P","R","S","T","U","F","Kh","","Y","","E","Je","Ji",
            "shh","sh","ch","c","ju","ja","zh","a","b","v","g","d","je","jo","z","i","j","k","l","m","n","o","p","r","s","t","u","f","kh","","y","","e","je","ji",
            "","","","","","",
        );
        for($i=0; $i<count($cyr); $i++)
        {
            $c_cyr = $cyr[$i];
            $c_lat = $lat[$i];
            $string = str_replace($c_cyr, $c_lat, $string);
        }
        $string = preg_replace("/([qwrtpsdfghklzxcvbnmQWRTPSDFGHKLZXCVBNM]+)[jJ]e/", "\${1}e", $string);
        $string = preg_replace("/([qwrtpsdfghklzxcvbnmQWRTPSDFGHKLZXCVBNM]+)[jJ]/", "\${1}'", $string);
        $string = preg_replace("/([eyuioaEYUIOA]+)[Kk]h/", "\${1}h", $string);
        $string = preg_replace("/^kh/", "h", $string);
        $string = preg_replace("/^Kh/", "H", $string);
        $string=str_replace("'", '', $string);
        $string=str_replace(" ", '_', $string);
        $string=str_replace(",", '', $string);
        $string=str_replace("·", '_', $string);
        $string=str_replace("°", '', $string);
        $string= mb_strimwidth($string, 0, 49, "");
        $string= mb_strtolower($string);
        return $string;
    }

    function UrlTranslit($string)
    {
        $string = preg_replace("/[_\s\.,?!\[\](){}]+/", "_", $string);
        $string = preg_replace("/-{2,}/", "--", $string);
        $string = preg_replace("/_-+_/", "--", $string);
        $string = preg_replace("/[_\-]+$/", "", $string);
        $string = Translit::Transliterate($string);
        $string = ToLower($string);
        $string = preg_replace("/j{2,}/", "j", $string);
        $string = preg_replace("/[^0-9a-z_\-]+/", "", $string);
        $string=str_replace("'", '', $string);
        $string=str_replace(" ", '_', $string);
        $string=str_replace(",", '', $string);
        $string=str_replace("·", '_', $string);
        $string=str_replace("°", '', $string);
        $string= mb_strimwidth($string, 0, 49, "");
        $string= mb_strtolower($string);
        return $string;
    }
}