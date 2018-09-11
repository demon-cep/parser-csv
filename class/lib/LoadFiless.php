<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 04.09.2018
 * Time: 12:10
 */

namespace lib\Load;

use lib\Setting;

class LoadFiles extends Setting
{
    public $path_file;
    public $section_id;
public function auto_set(){
    $_POST['section']=130;
    $this->section_id=130;
    Setting::$SECTION_ID=$this->section_id;
    $this->path_file='/home/pugach/e11.e1media.ru/docs/parser/upload/3.csv';
}

 public function load()
 {
     global $log;
     //    проверка раздела
     $this->section_id=(int)$_POST['section'];
     Setting::$SECTION_ID=$this->section_id;
     if ($this->section_id==0)
         $log->write_log('Не выбранн раздел', 2);
     // загрузка файла
     $uploaddir = $_SERVER['DOCUMENT_ROOT'].self::$DIR_LOAD;
     $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

     if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
         $this->path_file= $uploadfile;
         $log->write_log('Файл: '.$_FILES['userfile']['name'].' корректен и был успешно загружен.');
     } else {
         $log->write_log('Файл не загружен', 2);

     }
 }
}