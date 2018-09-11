<?php
/**
 * Created by PhpStorm.
 * User: ������
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
        self::$text_log.='����: '.date('d.m.Y').'  --  �����'.date('H:i:s').'\n';
        if (!self::$WRITE_LOG) {
            self::$text_log .= '����������� � ���� ���������� (��� ��������� \lib\Setting::$WRITE_LOG=true) composer.php' . '\n';
        }
        if (self::$WRITE_LOG){
            self::$text_log .= '����������� � ���� ��������� (��� ���������� \lib\Setting::$WRITE_LOG=false) composer.php' . '\n';
            self::$text_log.='���� �� log ����� '.self::$LOG_PATH.'\n';
        }
        if (!self::$SHOW_TABLE){
            self::$text_log .= '��������� ������� ��������� ���������� (��� ��������� \lib\Setting::$SHOW_TABLE=false) composer.php' . '\n';
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
            echo '����������� ������: '.$this->fatal_erorr."!!!";
            echo '<br>';
            echo '<a href="/parser">���������</a>';
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
                $stat='|������|';
                break;
            case '2':
                $stat='|����������� ������!|';
                break;
            default:
                $stat='|����������� ������|';
                break;
        }

        self::$text_log.=$stat." -- ".$text."\n";
        if ($status==2){
            $this->fatal_erorr=$text;
            exit();
        }
    }
}