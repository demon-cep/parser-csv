<?php
/**
 * Created by PhpStorm.
 * User: ������
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
                $log->write_log('������ �������� �������� ' . $ELEMENT_ID, 1);
            }
        }
        $log->write_log('�������� ��� �������� ������� ' . $file->section_id);
    }
}