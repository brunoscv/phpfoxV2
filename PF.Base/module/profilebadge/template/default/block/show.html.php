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

$aMe = Phpfox::getUserBy('user_name');

$aRow = Phpfox::getLib('phpfox.database')
          ->select('*')
 	    ->from(Phpfox::getT('user'), 'a')
		->join(Phpfox::getT('user_field'), 'b', 'a.user_id = b.user_id')
		->join(Phpfox::getT('photo'), 'c', 'b.cover_photo = c.photo_id')
		->limit(1)
           ->where('a.user_name = "'.$aUser.'" and a.user_image')
            ->order('a.user_id DESC')
            ->execute('getRow');  


if ($aUser == $aMe) {

if ($aRow){

echo "<script>

function show1() {";

if (Phpfox::getParam('profilebadge.showstyle1')){
echo "document.getElementById('pagesshow').style.display = 'block';";
}

if (Phpfox::getParam('profilebadge.showstyle2')){
echo "document.getElementById('pagesshow1').style.display = 'none';";
}


echo "document.getElementById('pagesshow2').style.display = 'none';
}

function show2() {";

if (Phpfox::getParam('profilebadge.showstyle1')){
echo "document.getElementById('pagesshow').style.display = 'none';";
}

if (Phpfox::getParam('profilebadge.showstyle2')){
echo "document.getElementById('pagesshow1').style.display = 'block';";
}



echo "document.getElementById('pagesshow2').style.display = 'none';
}

function show3() {";

if (Phpfox::getParam('profilebadge.showstyle1')){
echo "document.getElementById('pagesshow').style.display = 'none';";
}

if (Phpfox::getParam('profilebadge.showstyle2')){
echo "document.getElementById('pagesshow1').style.display = 'none';";
}

echo "document.getElementById('pagesshow2').style.display = 'block';
}

</script>";


if (Phpfox::getParam('profilebadge.showstyle1')){
echo '<div id="pagesshow" style="width:100%;display:block;">';
Phpfox::getBlock('profilebadge.style1');
echo '</div>';
}

if (Phpfox::getParam('profilebadge.showstyle2')){

if (Phpfox::getParam('profilebadge.showstyle1')){
echo '<div id="pagesshow1" style="width:100%;display:none;">';
Phpfox::getBlock('profilebadge.style2');
echo '</div>';
}else{
echo '<div id="pagesshow1" style="width:100%;display:block;">';
Phpfox::getBlock('profilebadge.style2');
echo '</div>';

}
}

if (Phpfox::getParam('profilebadge.showstyle3')){

if (Phpfox::getParam('profilebadge.showstyle1') || Phpfox::getParam('profilebadge.showstyle2')){
echo '<div id="pagesshow2" style="width:100%;display:none;">';
Phpfox::getBlock('profilebadge.style3');
echo '</div>';
}else{
echo '<div id="pagesshow2" style="width:100%;display:block;">';
Phpfox::getBlock('profilebadge.style3');
echo '</div>';

}

}
{/php}


{php}

if (Phpfox::getParam('profilebadge.showstyle1')){

if (Phpfox::getParam('profilebadge.showstyle2') || Phpfox::getParam('profilebadge.showstyle3')){
echo '<input type="button"   value="' . Phpfox::getPhrase('profilebadge.style1') . '" id="new" onclick="show1();">';
}else{

}
}

if (Phpfox::getParam('profilebadge.showstyle2')){

if (Phpfox::getParam('profilebadge.showstyle1') || Phpfox::getParam('profilebadge.showstyle3')){
echo '<input type="button"   value="' . Phpfox::getPhrase('profilebadge.style2') . '" id="top" onclick="show2();">';
}else{

}
}

if (Phpfox::getParam('profilebadge.showstyle3')){
if (Phpfox::getParam('profilebadge.showstyle1') || Phpfox::getParam('profilebadge.showstyle2')){
echo '<input type="button"   value="' . Phpfox::getPhrase('profilebadge.style3') . '" id="top" onclick="show3();">';
}else{

}
}

}else{
echo Phpfox::getPhrase('profilebadge.coverphoto');
}
}
{/php}

