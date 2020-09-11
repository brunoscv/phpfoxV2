<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[MYPHPFOXMODS_COPYRIGHT]
 * @author  		cespiritual
 * @website 		www.myphpfoxmods.com
  */
 
defined('PHPFOX') or exit('NO DICE!'); 

?>

{php}

$aUser = request()->segment(1);

$aRow = Phpfox::getLib('phpfox.database')
          ->select('*')
 	    ->from(Phpfox::getT('user'), 'a')
		->join(Phpfox::getT('user_field'), 'b', 'a.user_id = b.user_id')
		->leftjoin(Phpfox::getT('photo'), 'c', 'b.cover_photo = c.photo_id')
		->limit(1)
           ->where('a.user_name = "'.$aUser.'"')
            ->order('a.user_id DESC')
            ->execute('getRow');  

	$aPhoto_path = Phpfox::getParam('core.path');
     $aPhoto_path .= "file/pic/photo/";
     $aPhoto_path .= $aRow['destination'];
     $aPhoto_path = str_replace("%s","_240",$aPhoto_path);

$aGroup_url = Phpfox::getLib('url')->makeUrl($aRow['user_name']); 

$aFixe = str_replace("{file/pic/user/","_240",$aRow['user_image']);
      $aFixe = str_replace("}","",$aFixe);


if ($aRow['user_image']){        
     $avatarpath = Phpfox::getParam('core.url_user');
     $avatarpath .= $aFixe;
     $avatarpath = str_replace("%s","_200_square",$avatarpath);
     
     if ($aRow['user_image'] == "defaultfemale.jpg") 
     {
     $avatarpath = Phpfox::getParam('core.path').'theme/frontend/default/style/default/image/noimage/female_profile_50.png';
     }
     
     if ($aRow['user_image'] == "defaultmale.jpg") 
     {
     $avatarpath = Phpfox::getParam('core.path').'theme/frontend/default/style/default/image/noimage/profile_50.png';
     }
     
     }else{
     if ($aRow['gender'] == 1) 
     {
     $avatarpath = Phpfox::getParam('core.path').'theme/frontend/default/style/default/image/noimage/profile_50.png';
     }else{
     $avatarpath = Phpfox::getParam('core.path').'theme/frontend/default/style/default/image/noimage/female_profile_50.png';
     }
  }

	echo '<div style="max-width:250px;width:95%;background-color:#ffffff;border: 1px black solid;padding:3px;bottom:80%; right: 0px;z-index:9999999;-moz-box-shadow: 0px 0px 4px #aaaaaa;-webkit-box-shadow: 0px 0px 4px #aaaaaa;box-shadow: 0px 0px 4px #aaaaaa;"><div style="max-width:250px;width:100%;height:150px;background-size: 80% 100%;background-color:'.Phpfox::getParam('profilebadge.backcolor2').';';


if (Phpfox::getParam('profilebadge.gradient')){
echo 'background-image: linear-gradient(to right, rgba(0,0,0,0), rgba(0,0,0,0) 50%, rgba(0,0,0,1)), url(\''.$aPhoto_path .'\');';
}else{
echo 'background-image: url(\''.$aPhoto_path .'\');';
}


echo 'background-repeat: no-repeat;"><div style="position:relative;max-width:250px;width:98%;top:30px;left:64%;width:75px;height:75px;"><a href="'.$aGroup_url .'" target=_new><img src="'.$avatarpath.'" width=100% style="padding:5px;
;-moz-box-shadow: 0px 0px 4px #cccccc; -webkit-box-shadow: 0px 0px 4px #cccccc; box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;-moz-border-radius: 50px; -webkit-border-radius: 50px; -khtml-border-radius: 50px; border-radius: 50px;"></a></div><div style="position:relative;top:-82px;right:54px;text-align:right;max-width:250px;width:98%;height:30%;text-shadow: black 0.1em 0.1em 0.2em;max-height:30px;overflow:hidden;line-height: 1cm;"><font size=4 color='.Phpfox::getParam('profilebadge.fontcolorname').' face=arial>'.$aRow['full_name'].'</font></div>';

if (Phpfox::getParam('profilebadge.sitename')){
echo '<div style="position:relative;text-align:right;max-width:250px;width:100%;top:3px;right:60px;"><font size=2 color='.Phpfox::getParam('profilebadge.fontcolorname').' face=arial>' . Phpfox::getPhrase('profilebadge.visit') . '<br></font><b><a href="'.Phpfox::getParam('core.path').'" target=_new><font size=2 color='.Phpfox::getParam('profilebadge.fontcolorname').' face=arial>'.Phpfox::getParam('core.site_title').'</font></a></b></div>';
}

echo '</div></div>';


echo '<h3>' . Phpfox::getPhrase('profilebadge.embedcode') . '</h3>';

if(Phpfox::getUserParam('profilebadge.usebadge')){

echo '<textarea onclick="this.focus();this.select()" readonly="readonly" NAME="txt" ROWS=2 COLS=1 style="width:100%;" WRAP=VIRTUAL>';
	
	echo '<div style="max-width:250px;width:95%;background-color:#ffffff;border: 1px black solid;padding:3px;bottom:80%; right: 0px;z-index:9999999;-moz-box-shadow: 0px 0px 4px #aaaaaa;-webkit-box-shadow: 0px 0px 4px #aaaaaa;box-shadow: 0px 0px 4px #aaaaaa;"><div style="max-width:250px;width:100%;height:150px;background-size: 80% 100%;background-color:'.Phpfox::getParam('profilebadge.backcolor2').';';


if (Phpfox::getParam('profilebadge.gradient')){
echo 'background-image: linear-gradient(to right, rgba(0,0,0,0), rgba(0,0,0,0) 50%, rgba(0,0,0,1)), url(\''.$aPhoto_path .'\');';
}else{
echo 'background-image: url(\''.$aPhoto_path .'\');';
}


echo 'background-repeat: no-repeat;"><div style="position:relative;max-width:250px;width:98%;top:30px;left:64%;width:75px;height:75px;"><a href="'.$aGroup_url .'" target=_new><img src="'.$avatarpath.'" width=100% style="padding:5px;
;-moz-box-shadow: 0px 0px 4px #cccccc; -webkit-box-shadow: 0px 0px 4px #cccccc; box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;-moz-border-radius: 50px; -webkit-border-radius: 50px; -khtml-border-radius: 50px; border-radius: 50px;"></a></div><div style="position:relative;top:-82px;right:54px;text-align:right;max-width:250px;width:98%;height:30%;text-shadow: black 0.1em 0.1em 0.2em;max-height:30px;overflow:hidden;line-height: 1cm;"><font size=4 color='.Phpfox::getParam('profilebadge.fontcolorname').' face=arial>'.$aRow['full_name'].'</font></div>';

if (Phpfox::getParam('profilebadge.sitename')){
echo '<div style="position:relative;text-align:right;max-width:250px;width:100%;top:3px;right:60px;"><font size=2 color='.Phpfox::getParam('profilebadge.fontcolorname').' face=arial>' . Phpfox::getPhrase('profilebadge.visit') . '<br></font><b><a href="'.Phpfox::getParam('core.path').'" target=_new><font size=2 color='.Phpfox::getParam('profilebadge.fontcolorname').' face=arial>'.Phpfox::getParam('core.site_title').'</font></a></b></div>';
}

echo '</div></div>';






echo '</textarea>';
}else{
echo Phpfox::getPhrase('profilebadge.upgrade');
}

{/php}

