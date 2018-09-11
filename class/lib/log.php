<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 04.09.2018
 * Time: 15:46
 */

namespace lib;


class log extends Setting
{

    public static $text_log;
    public $log;
    public $fatal_erorr;

    function __construct()
    {
        if (self::$WRITE_LOG){
            $this->log=file_get_contents( $_SERVER['DOCUMENT_ROOT'].self::$LOG_PATH);
        }
        self::$text_log='-------start_log---------\n';
        self::$text_log.='Дата: '.date('d.m.Y').'  --  Время'.date('H:i:s').'\n';
        if (!self::$WRITE_LOG) {
            self::$text_log .= 'Логирование в файл отключенно (для включение \lib\Setting::$WRITE_LOG=true) composer.php' . '\n';
        }
        if (self::$WRITE_LOG){
            self::$text_log .= 'Логирование в файл включенно (для выключение \lib\Setting::$WRITE_LOG=false) composer.php' . '\n';
            self::$text_log.='Путь до log файла '.self::$LOG_PATH.'\n';
        }
        if (!self::$SHOW_TABLE){
            self::$text_log .= 'Отрисовка таблицы элементов отключенно (для включение \lib\Setting::$SHOW_TABLE=false) composer.php' . '\n';
        }
    }
    function __destruct()
    {

        self::$text_log.='-------end_log----------\n\n';

        if (self::$WRITE_LOG) {
            $this->log .= self::$text_log;
            file_put_contents( $_SERVER['DOCUMENT_ROOT'].self::$LOG_PATH, $this->log);
        }
        $this->show_log_html();
        if (isset($this->fatal_erorr)){
            echo 'Критическая ошибка: '.$this->fatal_erorr."!!!";
            echo '<br>';
            echo '<a href="/parser">Вернуться</a>';
            echo '</div>';
            require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
        }
    }

    public function show_log_html()
    {

        echo '<pre>'.str_replace('\n','<br>',self::$text_log).'</pre> ';
    }
    public function write_log($text, $status=0)
    {
        switch ($status){
            case '0':
                $stat='|Ok|';
                break;
            case '1':
                $stat='|Ошибка|';
                break;
            case '2':
                $stat='|Критическая ошибка!|';
                break;
            default:
                $stat='|Неизвестная ошибка|';
                break;
        }

        self::$text_log.=$stat." -- ".$text."\n";
        if ($status==2){
            $this->fatal_erorr=$text;
            exit();
        }
    }
}