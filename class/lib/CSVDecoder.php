<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 04.09.2018
 * Time: 16:53
 */
namespace lib;

use lib\Load\LoadFiles;

class CSVDecoder extends Setting
{
    private $file;
    private $csv;
    private static $prev_element;
    function __construct(LoadFiles $file,$csv)
    {
        $this->file=$file;
        $this->csv=$csv;
        $this->read_csv();
    }
    function create_prop($name_prop)
    {
        if ($name_prop && $name_prop!=' ') {
            $code = Translit::Transliterate( $name_prop);
             $arFields = Array(
              "NAME" => iconv('utf-8', 'windows-1251', $name_prop),
              "ACTIVE" => "Y",
              "SORT" => "500",
              "CODE" => $code,
              "PROPERTY_TYPE" => "S",
              "IBLOCK_ID" => self::$IBLOCK_ID,
              "WITH_DESCRIPTION" => "Y",
              "MULTIPLE" => "Y",
              "DESCRIPTION"=>""
              );
         \IblockProps::prop($arFields);
        }
    }
    function element($element)
    {

//        echo self::$prev_element;
        $Element=new \Element($element);
        global $log;
        if (self::$prev_element!=$element['NAME']){

            $Element->add();

        }else{
            $Element->update();
//            $log->write_log('Обновление элемента '.$element['NAME']);
        }
        //        костыль для проверки был ли такой элемент
        if (self::$prev_element!=$element['NAME']){
            self::$prev_element=$element['NAME'];
        }
    }
    function read_csv()
    {
        $csv=$this->csv;
        array_walk($csv, function(&$a) use ($csv) {
            $a = array_combine($this->csv[0], $a);
        });
        array_shift($csv);
        if (Setting::$SHOW_TABLE) {
           echo '<table><tr>';
        }
        foreach ($csv[0] as $key=>$value){
           $this->create_prop($key);
            if (Setting::$SHOW_TABLE) {
                ?>
                <td><?
                    echo $key; ?></td>
                <?
            }
        }
        if (Setting::$SHOW_TABLE) {
            echo '</tr>';
        }
                foreach ($csv as $number=>$val) {
                     //отсекаю полностью пустой массив
                    if ((bool)array_filter($val)) {
                        if (Setting::$SHOW_TABLE) {
                           echo '<tr>';
                        }
                        foreach ($val as $key => $value) {
                            if (Setting::$SHOW_TABLE) {
                                echo '<td>';
                            }
                                $code = Translit::Transliterate($key);
                                //подложка для пропущенной строки
                                if (!$val['Обозначение изделия'] && !$value) {
                                    $value = $csv[$number - 1][$key];
                                    $code=Translit::Transliterate($csv[$number - 1][$key]);
                                    $val['Обозначение изделия']=$csv[$number - 1]['Обозначение изделия'];
                                    if (Setting::$SHOW_TABLE) {
                                        echo 'Пропущенно ';
                                    }
                                }
                                //сбор свойства элемента
                                if ($value && $value != '-') {

                                    $element = array(
                                        "CODE" => $code,
                                        "VALUE" => $value,
                                        "NAME" => $val['Обозначение изделия'],
                                    );
                                    // создание свойств
                                    $this->element($element);
                                }
                                if (Setting::$SHOW_TABLE) {
                                    echo $value;
                                }
                            if (Setting::$SHOW_TABLE) {
                                echo '</td>';
                            }
                        }
                    }
                    if (Setting::$SHOW_TABLE) {
                        echo '</tr>';
                    }
                }
        if (Setting::$SHOW_TABLE) {
            echo '</table>';
        }
    }
}