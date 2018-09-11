<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 11.09.2018
 * Time: 11:31
 */

class DeliteElement extends \lib\Setting
{
    function delite_element(\lib\Load\LoadFiles $file)
    {
        global $log;
        $dbRes = CIBlockElement::GetList(array(), array("IBLOCK_ID" => self::$IBLOCK_ID, 'SECTION_ID'=>$file->section_id), array("ID"));
        while ($prop_fields = $dbRes->GetNext()) {
            $ELEMENT_ID=$prop_fields['ID'];
            if (!CIBlockElement::Delete($ELEMENT_ID)) {
                $strWarning .= 'Error!';
                $DB->Rollback();
                $log->write_log('Ошибка удаления элемента ' . $ELEMENT_ID, 1);
            }
        }
        $log->write_log('Удаленны все элементы раздела ' . $file->section_id);
    }
}