<div id="header-bar">
        <table>
            <tr>
               <td width="100px">
                </td>
                <td width="50px" align="right" style="white-space: nowrap"><img src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/clipboard-peplanning.png" alt="logo" border="0"/>
                </td>
               <td width="150px" valign="top">
                   <a href="http://<?echo $_SERVER['SERVER_NAME']?>/tplan/index.php"><img src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/pep_white_logo.jpg" alt="logo" border="0"/></a>
                </td>
                <?php if (($_SESSION['username']!='Guest')&&($_SESSION['username']!='')){?><td width="100"></td>
                <td width="900px"align="left" nowrap="true" style="min-width:900px;white-space: nowrap"><?php } else {?>
                <td width="900px"align="center" nowrap="true" style="min-width:900px;white-space: nowrap">
                <?php }
                                if ($_SERVER['PHP_SELF']!='/tplan/activate-confirm.php'){
                                if (($_SESSION['username']!='Guest')&&($_SESSION['username']!='')) include("header_logged_in.php");
                                else include("header_logged_out.php");
                                }
                    ?>
                 </td>
                 <td width="100px">
                     
                </td>
          </tr>
        </table>
        </div>
<div id="helpDialog" style="display:none;"></div>