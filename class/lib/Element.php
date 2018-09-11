<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 11.09.2018
 * Time: 12:19
 */

class Element extends \lib\Setting
{
    private static $prev_element;
    private $NAME;
    private $arFilds;
    private $element;

    function __construct(array $element)
    {
        global $USER;
        if ($this->NAME!=$element['NAME']){
            self::$prev_element=$this->NAME;
        }
        $this->NAME=$element['NAME'];

        $this->element=$element;
        $this->arFilds=array(
            "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
            "IBLOCK_SECTION_ID" => self::$SECTION_ID,
            "IBLOCK_ID"      => self::$IBLOCK_ID,
            "NAME"           => $this->NAME,
            "ACTIVE"         => "Y",            // активен
        );

    }
    function update()
    {
        $PRODUCT_ID=$this->get_NAME();
        if ($PRODUCT_ID>0) {
           $arr=$this->get_prop($PRODUCT_ID);
                if (is_array($arr)){
                    CIBlockElement::SetPropertyValuesEx($PRODUCT_ID, self::$IBLOCK_ID, array($this->element['CODE'] => $arr));
                }else {
                    CIBlockElement::SetPropertyValuesEx($PRODUCT_ID, false, array($this->element['CODE'] => $this->element['VALUE']));
                }
            return 'Обнавлен элемент: '.$PRODUCT_ID;
        }
    }
    function add()
    {
        global $log;
        $PRODUCT_ID=$this->get_NAME();
        if ($PRODUCT_ID==0) {
            $el = new CIBlockElement;
            $res = $el->Add($this->arFilds);
            $log->write_log('Создание элемента '.$element['NAME']);
        }

    }
    function get_NAME(){
        // echo $id;
        $rsSections = CIBlockElement::GetList(array(), array('IBLOCK_ID'=>self::$IBLOCK_ID,'NAME'=>$this->NAME,'SECTION_ID'=>self::$SECTION_ID),array('ID'), Array("nPageSize"=>1));
        if($obs = $rsSections->GetNext()){
            return $obs['ID'];
        }else{
            return 0;
        }
    }
    function get_prop($id)
    {
        global $log;
        $code=$this->element['CODE'];
        $dbRes = CIBlockElement::GetList(array(), array("IBLOCK_ID" => self::$IBLOCK_ID, 'ID'=>$id, "!PROPERTY_".$code => $this->element['VALUE']), array("PROPERTY_".$code));
        if ($prop_fields = $dbRes->GetNext()){
            $path="PROPERTY_".mb_strtoupper($code).'_VALUE';
            if ($prop_fields[$path]) {
                if(is_array($prop_fields[$path])) {
                    $val = $prop_fields[$path];
                }else{
                    $val[] = $prop_fields[$path];
                }
                $val[]=$this->element['VALUE'];
                $log->write_log('Множественное свойство '.$this->element['CODE']." добавлен");
                return $val;

            }
        }
    }
}