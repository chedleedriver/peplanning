<?
defined('FPDF_FONTPATH')
    || define('FPDF_FONTPATH',realpath(dirname(__FILE__) . '/../public/tplan/font/'));
defined('IMAGE_PATH')
    || define ('IMAGE_PATH',realpath(dirname(__FILE__) . '/../public/tplan/images/'));
defined('DIAGRAM_PATH')
    || define ('DIAGRAM_PATH','diagrams/');
defined('RESOURCE_PATH')
    || define ('RESOURCE_PATH','resources/');
defined('DOC_ROOT')
    || define ('DOC_ROOT','/tplan/');
defined('FILE_ROOT')
    || define ('FILE_ROOT',realpath(dirname(__FILE__) . '/../public/tplan/'));
defined('HOME_URL')
    || define ('HOME_URL',$_SERVER['SERVER_NAME']);
$tp = mysql_pconnect("peplanning-db.my.phpcloud.com", "peplanning", "ferd1nand") or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db("peplanning", $tp);
?>
