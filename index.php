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
//����������
//$no_show=true;
//$file->auto_set();
//�������� ���� ��������� ���������� �������
//DeliteElement::delite_element($file);
//�������� csv
//    $csv = new \lib\CSV($file); //��������� ��� csv
//$csv=new \lib\CSVDecoder($file, $csv->getCSV());
//������� ��� ��� ������� ���������
//$log->show_log_html();
//end

    //    ������� (�� ������� ������� �������� ������������ __destructor � log)
    unset($log);

$dbRes = CIBlockSection::GetList(array(), array("IBLOCK_ID" => \lib\Setting::$IBLOCK_ID), array('ID','NAME'));
?>
<?if(!$no_show){?>
    <form enctype="multipart/form-data" method="post">
        <label> ����</label>
        <input name="userfile" accept=".csv" type="file" />
        <br>
        <br>
        <label> ������</label>
        <select name="section">
            <option selected value="">�� ��������</option>
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
        <input type="submit" name="rar" value="���������" />
    </form>
<?}?>
</div>
<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');?>