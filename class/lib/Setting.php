<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 10.09.2018
 * Time: 18:33
 */

namespace lib;


class Setting
{
    static $LOG_PATH='/parser/class/log.txt';
    static $WRITE_LOG=true;

    static $IBLOCK_ID=1;
    static $DIR_LOAD='/parser/upload/';

    static $SHOW_TABLE=true;

    static $SECTION_ID; //будет переопределена в LoadFile
    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }

    }
}
