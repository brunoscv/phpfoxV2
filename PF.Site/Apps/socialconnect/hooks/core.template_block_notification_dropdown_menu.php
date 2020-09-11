<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */
if(Phpfox::getUserParam('socialconnect.socialconnect_view')){
    $url = url('/socialconnect');
    $label = _p('Manage Social Connections');
    echo '<li role="presentation">
       <a href="'. $url .'">
           <i class="fa fa-plug"></i>
           ' . $label . '
       </a>
   </li>';
}