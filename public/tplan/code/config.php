<?
define('FPDF_FONTPATH','/var/www/html/tplan/font/');
define ('IMAGE_PATH','/var/www/html/tplan/images/');
define ('DIAGRAM_PATH','diagrams/');
define ('RESOURCE_PATH','resources/');
define ('DOC_ROOT','/tplan/');
define ('FILE_ROOT','/var/www/html/tplan/');
define ('HOME_URL','http://www.peplanning.org.uk/');
$tp = mysql_pconnect("localhost", "tp", "enquiry") or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db("tplan", $tp);
?>
