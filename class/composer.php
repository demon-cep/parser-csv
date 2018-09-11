<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
//кривой композер
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
use lib\log;
use lib\load\LoadFiles;
require_once ('lib/Setting.php');
//    изменение setting
//
\lib\Setting::$WRITE_LOG=false;
\lib\Setting::$SHOW_TABLE=false;
//
//    end
require_once ('lib/log.php');
$log=new log();
require_once ('lib/LoadFiless.php');
require_once ('lib/DeliteElement.php');

$file=new LoadFiles();
require_once ('lib/Translit.php');
require_once ('lib/CSV.php');
require_once ('lib/IblockProps.php');
require_once ('lib/Element.php');
require_once ('lib/CSVDecoder.php');



