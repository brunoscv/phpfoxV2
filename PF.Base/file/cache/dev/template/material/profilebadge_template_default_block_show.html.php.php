<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 25, 2020, 7:50 pm */ ?>
<?php

?>

<?php if (! isset ( $this->_aVars['sHidden'] )):  $this->assign('sHidden', '');  endif; ?>

<?php if (( isset ( $this->_aVars['sHeader'] ) && ( ! PHPFOX_IS_AJAX || isset ( $this->_aVars['bPassOverAjaxCall'] ) || isset ( $this->_aVars['bIsAjaxLoader'] ) ) ) || ( defined ( "PHPFOX_IN_DESIGN_MODE" ) && PHPFOX_IN_DESIGN_MODE )): ?>

<div class="<?php echo $this->_aVars['sHidden']; ?> block<?php if (( defined ( 'PHPFOX_IN_DESIGN_MODE' ) ) && ( ! isset ( $this->_aVars['bCanMove'] ) || ( isset ( $this->_aVars['bCanMove'] ) && $this->_aVars['bCanMove'] == true ) )): ?> js_sortable<?php endif;  if (isset ( $this->_aVars['sCustomClassName'] )): ?> <?php echo $this->_aVars['sCustomClassName'];  endif; ?>"<?php if (isset ( $this->_aVars['sBlockBorderJsId'] )): ?> id="js_block_border_<?php echo $this->_aVars['sBlockBorderJsId']; ?>"<?php endif;  if (defined ( 'PHPFOX_IN_DESIGN_MODE' ) && Phpfox_Module ::instance()->blockIsHidden('js_block_border_' . $this->_aVars['sBlockBorderJsId'] . '' )): ?> style="display:none;"<?php endif; ?> data-toggle="<?php echo $this->_aVars['sToggleWidth']; ?>">
<?php if (! empty ( $this->_aVars['sHeader'] ) || ( defined ( "PHPFOX_IN_DESIGN_MODE" ) && PHPFOX_IN_DESIGN_MODE )): ?>
		<div class="title <?php if (defined ( 'PHPFOX_IN_DESIGN_MODE' )): ?>js_sortable_header<?php endif; ?>">
<?php if (isset ( $this->_aVars['sBlockTitleBar'] )): ?>
<?php echo $this->_aVars['sBlockTitleBar']; ?>
<?php endif; ?>
<?php if (( isset ( $this->_aVars['aEditBar'] ) && Phpfox ::isUser())): ?>
			<div class="js_edit_header_bar">
				<a href="#" title="<?php echo _p('edit_this_block'); ?>" onclick="$.ajaxCall('<?php echo $this->_aVars['aEditBar']['ajax_call']; ?>', 'block_id=<?php echo $this->_aVars['sBlockBorderJsId'];  if (isset ( $this->_aVars['aEditBar']['params'] )):  echo $this->_aVars['aEditBar']['params'];  endif; ?>'); return false;">
					<span class="ico ico-pencilline-o"></span>
				</a>
			</div>
<?php endif; ?>
<?php if (empty ( $this->_aVars['sHeader'] )): ?>
<?php echo $this->_aVars['sBlockShowName']; ?>
<?php else: ?>
<?php echo $this->_aVars['sHeader']; ?>
<?php endif; ?>
		</div>
<?php endif; ?>
<?php if (isset ( $this->_aVars['aEditBar'] )): ?>
	<div id="js_edit_block_<?php echo $this->_aVars['sBlockBorderJsId']; ?>" class="edit_bar hidden"></div>
<?php endif; ?>
<?php if (isset ( $this->_aVars['aMenu'] ) && count ( $this->_aVars['aMenu'] )): ?>
<?php unset($this->_aVars['aMenu']); ?>
<?php endif; ?>
	<div class="content"<?php if (isset ( $this->_aVars['sBlockJsId'] )): ?> id="js_block_content_<?php echo $this->_aVars['sBlockJsId']; ?>"<?php endif; ?>>
<?php endif; ?>
		<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[MYPHPFOXMODS_COPYRIGHT]
 * @author  		cespiritual
 * @website 		www.myphpfoxmods.com
  */
 
 

?>
<?php 

		 
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
 ?>


<?php 

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
 ?>





<?php if (( isset ( $this->_aVars['sHeader'] ) && ( ! PHPFOX_IS_AJAX || isset ( $this->_aVars['bPassOverAjaxCall'] ) || isset ( $this->_aVars['bIsAjaxLoader'] ) ) ) || ( defined ( "PHPFOX_IN_DESIGN_MODE" ) && PHPFOX_IN_DESIGN_MODE )): ?>
	</div>
<?php if (isset ( $this->_aVars['aFooter'] ) && count ( $this->_aVars['aFooter'] )): ?>
	<div class="bottom">
<?php if (count ( $this->_aVars['aFooter'] ) == 1): ?>
<?php if (count((array)$this->_aVars['aFooter'])):  $this->_aPhpfoxVars['iteration']['block'] = 0;  foreach ((array) $this->_aVars['aFooter'] as $this->_aVars['sPhrase'] => $this->_aVars['sLink']):  $this->_aPhpfoxVars['iteration']['block']++; ?>

<?php if ($this->_aVars['sLink'] == '#'): ?>
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('theme' => 'ajax/add.gif','class' => 'ajax_image')); ?>
<?php endif; ?>
<?php if (is_array ( $this->_aVars['sLink'] )): ?>
            <a class="btn btn-block <?php if (! empty ( $this->_aVars['sLink']['class'] )): ?> <?php echo $this->_aVars['sLink']['class'];  endif; ?>" href="<?php if (! empty ( $this->_aVars['sLink']['link'] )):  echo $this->_aVars['sLink']['link'];  else: ?>#<?php endif; ?>" <?php if (! empty ( $this->_aVars['sLink']['attr'] )):  echo $this->_aVars['sLink']['attr'];  endif; ?> id="js_block_bottom_link_<?php echo $this->_aPhpfoxVars['iteration']['block']; ?>"><?php echo $this->_aVars['sPhrase']; ?></a>
<?php else: ?>
            <a class="btn btn-block" href="<?php echo $this->_aVars['sLink']; ?>" id="js_block_bottom_link_<?php echo $this->_aPhpfoxVars['iteration']['block']; ?>"><?php echo $this->_aVars['sPhrase']; ?></a>
<?php endif; ?>
<?php endforeach; endif; ?>
<?php else: ?>
		<ul>
<?php if (count((array)$this->_aVars['aFooter'])):  $this->_aPhpfoxVars['iteration']['block'] = 0;  foreach ((array) $this->_aVars['aFooter'] as $this->_aVars['sPhrase'] => $this->_aVars['sLink']):  $this->_aPhpfoxVars['iteration']['block']++; ?>

				<li id="js_block_bottom_<?php echo $this->_aPhpfoxVars['iteration']['block']; ?>"<?php if ($this->_aPhpfoxVars['iteration']['block'] == 1): ?> class="first"<?php endif; ?>>
<?php if ($this->_aVars['sLink'] == '#'): ?>
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('theme' => 'ajax/add.gif','class' => 'ajax_image')); ?>
<?php endif; ?>
					<a href="<?php echo $this->_aVars['sLink']; ?>" id="js_block_bottom_link_<?php echo $this->_aPhpfoxVars['iteration']['block']; ?>"><?php echo $this->_aVars['sPhrase']; ?></a>
				</li>
<?php endforeach; endif; ?>
		</ul>
<?php endif; ?>
	</div>
<?php endif; ?>
</div>
<?php endif; ?>
<?php unset($this->_aVars['sHeader'], $this->_aVars['sComponent'], $this->_aVars['aFooter'], $this->_aVars['sBlockBorderJsId'], $this->_aVars['bBlockDisableSort'], $this->_aVars['bBlockCanMove'], $this->_aVars['aEditBar'], $this->_aVars['sDeleteBlock'], $this->_aVars['sBlockTitleBar'], $this->_aVars['sBlockJsId'], $this->_aVars['sCustomClassName'], $this->_aVars['aMenu']); ?>
