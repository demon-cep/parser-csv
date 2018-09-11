<?php
/**
 * Created by PhpStorm.
 * User: ������
 * Date: 10.09.2018
 * Time: 18:28
 */



class IblockProps extends \lib\Setting
{
    function type($type){
        switch ($type) {
            case 'text':
                $str='S';
                break;

            default:
                $str='N';
                break;
        }
        return $str;
    }
    function prop($arFields){
        global $log;
        // $arFields = Array(
        //  "NAME" => $name,
        //  "ACTIVE" => "Y",
        //  "SORT" => "500",
        //  "CODE" => $names,
        //  "PROPERTY_TYPE" => "S",
        //  "IBLOCK_ID" => (int)$IBLOCK_ID,
        //  "WITH_DESCRIPTION" => "Y",
        //  "MULTIPLE" => "N",
        //  "DESCRIPTION"=>"test"
        //  );


        $res = CIBlock::GetProperties(self::$IBLOCK_ID, Array());
        $bool=false;
        while ($res_arr = $res->Fetch()) {
            if ($res_arr['CODE']==$arFields['CODE']) {
                $bool=true;
                $arss=$res_arr;

            }
        }
        // �������� ����� !bool
        if (!$bool) {

            // ������� ��������
            if ($arFields['NAME']) {
                $iblockproperty = new CIBlockProperty;
                $PropertyID = $iblockproperty->Add($arFields);
                if ($PropertyID) {
                    $log->write_log('�������� �������� ' . $PropertyID . " " . $arFields['NAME']);
                    return '�������� �������� ' . $PropertyID;
                }else{
                    $log->write_log('�� ������� ������� �������� name:'. $arFields['NAME'],1);
                }
            }
        }else{
            $ar_all_values= $arFields;
            $iblockproperty = new CIBlockProperty;
            if ($iblockproperty->Update($arss['ID'], $ar_all_values)) {
                $log->write_log('�������� ���������� '.$ar_all_values['NAME']);
                return '�������� ���������� '.$ar_all_values['NAME'];
            }
        }
    }
}