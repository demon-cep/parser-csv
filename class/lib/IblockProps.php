<?php
/**
 * Created by PhpStorm.
 * User: Сергей
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
        // свойство новое !bool
        if (!$bool) {

            // создать свойство
            if ($arFields['NAME']) {
                $iblockproperty = new CIBlockProperty;
                $PropertyID = $iblockproperty->Add($arFields);
                if ($PropertyID) {
                    $log->write_log('Свойство созданно ' . $PropertyID . " " . $arFields['NAME']);
                    return 'Свойство созданно ' . $PropertyID;
                }else{
                    $log->write_log('Не удалось создать свойство name:'. $arFields['NAME'],1);
                }
            }
        }else{
            $ar_all_values= $arFields;
            $iblockproperty = new CIBlockProperty;
            if ($iblockproperty->Update($arss['ID'], $ar_all_values)) {
                $log->write_log('Свойство обновленно '.$ar_all_values['NAME']);
                return 'Свойство обновленно '.$ar_all_values['NAME'];
            }
        }
    }
}