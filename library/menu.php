<?php $mysession = new Zend_Session_Namespace('mysession'); 
 
 ?>     
<!-- fixed items -->
<div id="menu">
    <table align="center">
        <tr>
            <td id="logo"><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/"><span>PE Planning logo</span></a></td>
            <td class="divider"></td>
            <td class="menu_item"><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/aboutus"><span>About us</span></a></td>
            <td class="divider"></td>
            <td class="menu_item"><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/createaplan"><span>Plan a lesson</span></a></td>            
            <td class="divider"></td>
            <td class="menu_item"><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/staffroom"><span>Staffroom</span></a></td>
            <td class="divider"></td>
            <td class="menu_item"><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/contactus"><span>Contact Us</span></a></td>            
            <td class="divider"></td>
            <?php 
            if($mysession->userlevel==0)
            {?>
            <td align="right" id="register"><a href="https://<?php echo $_SERVER['HTTP_HOST']?>/auth/subscribe" style="visibility:hidden;"><span>register</span></a></td>
            <!--<td align="right" id="signin"><a href="javascript:void(0)" onclick="javascript:showOverlay('Login');"><span>sign in</span></a></td>-->
            <td align="right" id="signin"><a href=<?php $this->getHelper('ServerUrl')->setScheme('https');echo $this->serverUrl($this->url(array(
    'controller'=>'auth','action'=>'login'), null, FALSE, TRUE)) ?>><span>sign in</span></a></td>
            <?php }
            if($mysession->userlevel==1)
            {?>
            <td align="right" id="subscribe"><a href="https://<?php echo $_SERVER['HTTP_HOST']?>/auth/subscribe" style="visibility:hidden;"><span>register</span></a></td>
            <td align="right" id="signout"><a href="javascript:void(0)" onclick="javascript:doProcess('Logout');" class="modalInput" rel="#prompt"><span>sign out</span></a></td>
            <?php }
            if($mysession->userlevel==4)
            {?>
            <td align="right" id="subscribe"><a href="https://<?php echo $_SERVER['HTTP_HOST']?>/auth/subscribe" style="visibility:hidden;"><span>register</span></a></td>
            <td align="right" id="signout"><a href="javascript:void(0)" onclick="javascript:doProcess('Logout');" class="modalInput" rel="#prompt"><span>sign out</span></a></td>
            <?php }
            if($mysession->userlevel==5)
            {?>
            <td align="right" id="subscribe"><a href="https://<?php echo $_SERVER['HTTP_HOST']?>/auth/subscribe" style="visibility:hidden;"><span>register</span></a></td>
            <td align="right" id="signout"><a href="javascript:void(0)" onclick="javascript:doProcess('Logout');" class="modalInput" rel="#prompt"><span>sign out</span></a></td>
            <?php }
            if($mysession->userlevel==9)
            {?>
            <td align="right" id="subscribe"><a href="https://<?php echo $_SERVER['HTTP_HOST']?>/auth/subscribe" style="visibility:hidden;"><span>register</span></a></td>
            <td align="right" id="signout"><a href="javascript:void(0)" onclick="javascript:doProcess('Logout');" class="modalInput" rel="#prompt"><span>sign out</span></a></td>
            <?php }
            ?>
        </tr>
    </table>
</div>
<!-----SP Edit --- Added dividers to the menu table to remove this need for this below-->
<!-- fixed items 
<table id="page_dividers" border="0">
    <tr>
        <td>
            <table id="divider_shell" align="center">
                <tr>
                    <td>
                        <table class="site_width" align="center" border="0">
                            <tr>
                                <td>
                                    <div id="div1" class="divider"></div>
                                    <div id="div2" class="divider"></div>
                                    <div id="div3" class="divider"></div>
                                    <div id="div4" class="divider"></div>
                                    <div id="div5" class="divider"></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>            
        </td>
    </tr>
</table>-->