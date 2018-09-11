<?
require_once ('class/composer.php');
?>
<div style="padding: 20px;">
    <?
if (isset($_POST['rar'])) {
    $no_show=true;
    $file->load();
    DeliteElement::delite_element($file);
    $csv = new \lib\CSV($file);
    $csv=new \lib\CSVDecoder($file, $csv->getCSV());

}
//тестеровка
//$no_show=true;
//$file->auto_set();
//удаление всех элементов выбранного раздела
//DeliteElement::delite_element($file);
//Разборка csv
//    $csv = new \lib\CSV($file); //Открываем наш csv
//$csv=new \lib\CSVDecoder($file, $csv->getCSV());
//вывести лог для текущих изменений
//$log->show_log_html();
//end

    //    костыль (по какойто причине перестал отрабатывать __destructor в log)
    unset($log);

$dbRes = CIBlockSection::GetList(array(), array("IBLOCK_ID" => \lib\Setting::$IBLOCK_ID), array('ID','NAME'));
?>
<?if(!$no_show){?>
    <form enctype="multipart/form-data" method="post">
        <label> Файл</label>
        <input name="userfile" accept=".csv" type="file" />
        <br>
        <br>
        <label> Раздел</label>
        <select name="section">
            <option selected value="">Не выбранно</option>
            <?
            while ($prop_fields = $dbRes->GetNext()){
            ?>
            <option value="<?=$prop_fields['ID']?>"><?=$prop_fields['NAME']?></option>
            <?
            }
            ?>
        </select>
        <br>
        <br>
        <hr>
        <input type="submit" name="rar" value="Запустить" />
    </form>
<?}?>
</div>
<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');?>