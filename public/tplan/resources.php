<?php
include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
$unit_id=$_GET['unit_id'];
$lesson_num=$_GET['lesson_num'];
$content_resources=mysql_query("select content_resources.content_id,content_resources.description,content_resources.name,location,type,content.name from content_resources left join content on content.content_id=content_resources.content_id where content_resources.content_id in (select activity_id from lesson_activities where lesson_id=(select id from lesson where uow_id=$unit_id and lesson_num=$lesson_num))");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>PE Planning | Lesson Resources</title>
        <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/indexcss.css?<?=time()?>" media="screen"/>
    </head>
    <body id="products">
    <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.5.1.js?<?=time()?>"></script>
    <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/indexScripts.js?<?=time()?>"></script>
   <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-ui-1.8.1.custom.min.js?<?=time()?>"></script>
<script type="text/javascript">
        /* google analytics */
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-16957975-1']);
        _gaq.push(['_trackPageview']);

        (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

        </script>
<?php include("header.php")?>
    <div id="doc"  class="products">
        <table width="100%">
        <tr>
        <td align="center" valign="middle">
        <table width="950px">
            <tr>
                <td colspan="2">
                    <h1>
                        Resources for <?php echo $content_resources['content.name']; ?>
                    </h1>
                </td>
            </tr>
            <? while (list($content_id,$description,$name,$location,$type)=mysql_fetch_array($content_resources)){?>
            <tr>
                <td width="20%" align="middle">
                    <?php if ($type!='url'){?>
                    <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/resources/<?php echo $content_id."/".substr($location,-8)?>"><img src='images/icon_resources_30.jpg' border='0'></img></a>
                    <?php } else {?>
                    <a href="<?php echo $location?>"><img src='images/icon_resources_30.jpg' border='0'></img></a>
                    <?php }?>
                </td>
                <td width="80%">
                    <? echo $description?>
                    </td>
            </tr>
            <?php }?>
        </table>
        </td>
        </tr>
       <tr>
        <td align="center" valign="middle">
        <table width="950px">
           <tr>
                <td>

                    
                </td>
            </tr>
         </table>
        </td>
        </tr>
       <tr>
        <td align="center" valign="middle">
        <table width="950px">
           <tr>
                <td>
                    
                    </td>
            </tr>
         </table>
        </td>
        </tr>
       <tr>
        <td align="center" valign="middle">
        <table width="950px">
           <tr>
             </tr>
           <tr>
                <td width="80%">
                    <table>
                        <tr>
                        </tr>
                    </table>
                </td>
               <td></td>
            </tr>
        </table>
        </td>
        </tr>
      </table>
 </div>
     <?php include("footer.php")?>
    </body>
</html>