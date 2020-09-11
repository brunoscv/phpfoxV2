<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 2:43 pm */ ?>
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
$aMe = Phpfox::getUserBy('user_id');
$id = 50000;
$id1 = 500000; 
$count= 0;
$cop = array();
$contar = 0;
$acesso = 0;

$sToken = Phpfox::getService('log.session')->getToken(); 


 ?>



<div style="position:relative;float: right;right:10px;top:0px">
<form method="post" name="go1" action="">

<select name="num1" onChange="go1.submit();" style="font-size: 8pt;font-style: normal;">
	<option value="">- <?php echo _p('forumsystem.select'); ?> -
	<option value="2" selected><?php echo _p('forumsystem.subscribed_groups'); ?></option>

	<option value="1" <?php if (Phpfox::getLib('phpfox.request')->get('num1') == 1){
echo 'selected';} ?>><?php echo _p('forumsystem.my_groups'); ?></option>


<?php 
	

echo '</select>
<input name="phpfox[security_token]" value="'.$sToken.'" type="hidden" value="Select" />
</form>
</div><br>';

$aForum_id = '';
$aMe = Phpfox::getUserBy('user_id');


if (Phpfox::getLib('phpfox.request')->get('num1') ){

if (Phpfox::getLib('phpfox.request')->get('num1') == 1){

$aForum_id = 'e.user_id = "'.$aMe.'"';

$aRows = Phpfox::getLib('phpfox.database')
          ->select('*, b.title as titulo, b.time_stamp as created, b.image_path AS avatar, b.title AS titulo')
            ->from(Phpfox::getT('pages'), 'b')
	     ->join(Phpfox::getT('pages_text'), 'a', 'a.page_id = b.page_id')
		->join(Phpfox::getT('forum_thread'), 'c', 'b.page_id = c.group_id')
		  ->join(Phpfox::getT('user'), 'e', 'b.user_id = e.user_id')

            ->limit(Phpfox::getParam('forumsystem.group_number'))
	    ->where($aForum_id)
            ->order('c.time_update DESC')
            ->execute('getRows');  
}

if (Phpfox::getLib('phpfox.request')->get('num1') == 2){

$aRows = Phpfox::getLib('phpfox.database')
          ->select('*, b.title as titulo, b.time_stamp as created, b.image_path AS avatar, b.title AS titulo')
            ->from(Phpfox::getT('pages'), 'b')
	     ->join(Phpfox::getT('pages_text'), 'a', 'a.page_id = b.page_id')
		->join(Phpfox::getT('forum_thread'), 'c', 'b.page_id = c.group_id')
		  ->join(Phpfox::getT('user'), 'e', 'b.user_id = e.user_id')
		->join(Phpfox::getT('like'), 'f', 'f.item_id = b.page_id')


            ->limit(Phpfox::getParam('forumsystem.group_number'))
	    ->where('f.type_id = "pages" and f.user_id = "'.$aMe.'"')

            ->order('c.time_update DESC')
            ->execute('getRows');  

}

}else{

$aRows = Phpfox::getLib('phpfox.database')
          ->select('*, b.title as titulo, b.time_stamp as created, b.image_path AS avatar, b.title AS titulo')
            ->from(Phpfox::getT('pages'), 'b')
	     ->join(Phpfox::getT('pages_text'), 'a', 'a.page_id = b.page_id')
		->join(Phpfox::getT('forum_thread'), 'c', 'b.page_id = c.group_id')
		  ->join(Phpfox::getT('user'), 'e', 'b.user_id = e.user_id')
		->join(Phpfox::getT('like'), 'f', 'f.item_id = b.page_id')


            ->limit(Phpfox::getParam('forumsystem.group_number'))
	    ->where('f.type_id = "pages" and f.user_id = "'.$aMe.'"')

            ->order('c.time_update DESC')
            ->execute('getRows');  
}



$count = 0;


foreach ($aRows as $aRow)
{            

$group_name = $aRow['titulo'];

$ok = 0;
$count = count($cop);

for ($i = 0; $i < $count; $i++) {
$c=$i;

if ($aRow['page_id'] == $cop[$c]){

$ok = 1;
}
}

if ($ok == 0){

echo "
<script>
function forum".$id."() {
if (document.getElementById('".$id."').style.display == 'none'){
	
	document.getElementById('".$id."').style.display = 'block';
}else{
	document.getElementById('".$id."').style.display = 'none';
}
}

</script>
";

$aGroup_url = Phpfox::getLib('url')->makeUrl('pages', array($aRow['page_id'])); 

    
if ($aRow['avatar']){
     $aPhoto_path = Phpfox::getParam('core.path');
     $aPhoto_path .= "file/pic/pages/";
     $aPhoto_path .= $aRow['avatar'];
     $aPhoto_path = str_replace("%s","_200",$aPhoto_path);


}


$name_var = $aRow['titulo'];

if (strpos($name_var,' ') !== false) {
$words = explode(" ", $aRow['titulo']);
$aName = "";
$i=0;

foreach ($words as $w) {
  $aName .= $w[0];
$i++;
if ($i==2){break;}	
}
}else{
$aName = substr($name_var,0,2); 
}


$aName = strtolower($aName);

$sAvatar = '<a class="no_image_user _size__50 _gender_ _first_'.$aName.'" href="'.$aGroup_url.'" ><img src="'.$aPhoto_path.'" width="70" title="'.$aRow['titulo'].'" style="	margin-right:5px;"></a>';

 if (!$aRow['avatar']){ 

$sAvatar  = '<a class="no_image_user _size__50 _gender_ _first_'.$aName.'" style="width:50px;padding:5px;" href="'.$aGroup_url .'" ><span style="top:11px;">'.$aName.'</span></a>';
}


          $aChars = 300;
     $aText = $aRow['text_parsed']." ";
	if (strlen($aText) >= $aChars){
     $aText = substr($aText,0,$aChars);
     $aText = substr($aText,0,strrpos($aText,' '));
     $aText = $aText."...";
     }
     
      $aTime_Group = Phpfox::getTime(Phpfox::getParam('forum.forum_time_stamp'), $aRow['created']);

    	$aNewThread_url = Phpfox::getLib('url')->makeUrl('forum.post.thread.module_pages', 'item_'. $aRow['page_id']); 
	$aMarks_read = Phpfox::getLib('url')->makeUrl('forum.read', 'forum_' . $aRow['group_id']);
	
	
echo '<div class="row_title" style="padding:10px"><div class="row_title_image" style="margin-left:0px;">'.$sAvatar.'</div>';
	

     echo '<div class="row_title_info" style="margin-left:70px;min-height:90px;height:auto !important;height:90px;"><a href="'.$aGroup_url.'"><b>'.$group_name.'</b></a> ' . Phpfox::getPhrase('forumsystem.by') . ' <i><a href="'.Phpfox::getLib('url')->makeUrl($aRow['user_name']).'">'.$aRow['full_name'].'</a></i>';
  
    echo '<br>'.strip_tags("$aText").'<br><font size=1>' . Phpfox::getPhrase('forumsystem.like') . ': '.$aRow['total_like'].'</font>';


     echo ' - <font size=1 color=gray><a href="'.$aNewThread_url.'">' . Phpfox::getPhrase('forumsystem.new_thread') . '</a> '; if (Phpfox::getParam('forumsystem.showthreads') && $acesso = 1){echo ' - <a href="javascript:void(0)" onclick="forum'.$id.'();">' . Phpfox::getPhrase('forumsystem.show_hide_thread') . '</a>'; } echo'</div></div></font>';


echo '<div id='.$id.' class='.$id.' style="margin: 2px;padding: 10px;border-radius:10px;background-image: url('.Phpfox::getParam('core.path').'module/forumsystem/images/background.png);position:relative;display:none;left:60px;width:80%;top:-10px;;-moz-box-shadow: 0px 0px 4px #aaaaaa;-webkit-box-shadow: 0px 0px 4px #aaaaaa;box-shadow: 0px 0px 4px #aaaaaa">';

$aRows = Phpfox::getLib('phpfox.database')
          ->select('a.group_id, a.time_stamp, a.thread_id, a.title, a.total_post, a.total_view, a.title_url, c.gender, c.user_image, c.user_name, c.full_name, e.text_parsed')
            ->from(Phpfox::getT('forum_thread'), 'a')
            ->join(Phpfox::getT('user'), 'c', 'a.user_id = c.user_id')
            ->join(Phpfox::getT('forum_post'), 'd', 'd.post_id = a.start_id')
            ->join(Phpfox::getT('forum_post_text'), 'e', 'e.post_id = d.post_id')
            ->limit(Phpfox::getParam('forumsystem.threads_number'))
	    ->where('a.group_id = '.$aRow['group_id'])
            ->order('time_update DESC')
            ->execute('getRows');  

 
         
           

foreach ($aRows as $aRow)
{

$grupo = $aRow['group_id'];
$cop[$contar] = $grupo;
$contar=$contar+1;


if (Phpfox::getParam('forumsystem.char') != 0){
     $aChars = Phpfox::getParam('forumsystem.char');
     $aText = $aRow['text_parsed']." ";
if (strlen($aText) >= $aChars){
     $aText = substr($aText,0,$aChars);
     $aText = substr($aText,0,strrpos($aText,' '));
     $aText = $aText."...";
}
}else{
$aText = $aRow['text_parsed'];
}


echo "
<script>
function thread".$id.$id1."() {
if (document.getElementById('".$id.$id1."').style.display == 'none'){
	
	document.getElementById('".$id.$id1."').style.display = 'block';
}else{
	document.getElementById('".$id.$id1."').style.display = 'none';
}
}

</script>
";
	    $aRows1 = Phpfox::getLib('phpfox.database')
            ->select('*')
            ->from(Phpfox::getT('forum_post'), 'a')
            ->join(Phpfox::getT('forum_post_text'), 'b', 'b.post_id = a.post_id')
            ->join(Phpfox::getT('user'), 'c', 'a.user_id = c.user_id')
            ->limit(Phpfox::getParam('forumsystem.posts_number'))
            ->where('a.thread_id = '.$aRow['thread_id'])
            ->order('time_stamp DESC')
            ->execute('getRows');
            
        
            
$aFixe = str_replace("{file/pic/user/","",$aRow['user_image']);
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

     
$sAvatar = '<a href="'.Phpfox::getLib('url')->makeUrl($aRow['user_name']).'" ><img src="'.$avatarpath.'" width="50" title="'.$aRow['full_name'].'" style="	margin-right:5px;"></a>';

$name_var = $aRow['full_name'];

if (strpos($name_var,' ') !== false) {
$words = explode(" ", $aRow['full_name']);
$aName = "";
$i=0;

foreach ($words as $w) {
  $aName .= $w[0];
$i++;
if ($i==2){break;}	
}
}else{
$aName = substr($name_var,0,2); 
}

$aName = strtolower($aName);

$sAvatar = '<a class="no_image_user _size__50 _gender_ _first_'.$aName.'" href="'.Phpfox::getLib('url')->makeUrl($aRow['user_name']).'" ><img src="'.$avatarpath.'" width="50" title="'.$aRow['full_name'].'" style="	margin-right:5px;"></a>';

 if (!$aRow['user_image']){ 

$sAvatar  = '<a class="no_image_user _size__50 _gender_ _first_'.$aName.'" style="width:50px;padding:5px;" href="'.Phpfox::getLib('url')->makeUrl($aRow['user_name']).'" ><span style="top:11px;">'.$aName.'</span></a>';
}

     
	$aTime_forum = Phpfox::getTime(Phpfox::getParam('forum.forum_time_stamp'), $aRow['time_stamp']);

     $aUser_url = Phpfox::getLib('url')->makeUrl($aRow['user_name']);
     $aThread_url = Phpfox::getLib('url')->makeUrl('forum.thread', $aRow['thread_id'].'/'. $aRow['title_url'] ); 
     
     $aReply_url = Phpfox::getLib('url')->makeUrl('forum.post.reply.module_group', 'item_'.$aRow['group_id'].'/id_' .$aRow['thread_id']); 
     
     echo '<div class="row_title" style="margin:3px;padding:20px;background-color:white;border-radius:10px"><div class="row_title_image" >'.$sAvatar.'</div>';
     echo '<div class="row_title_info" style="margin-left:55px;min-height:55px;height:auto !important;height:55px;"><a href="'.$aThread_url.'"><b>'.$aRow['title'].'</b></a> ' . Phpfox::getPhrase('forumsystem.by') . ' <i>'.$aRow['full_name'].'</i><font size=1 color=gray><br> (' . Phpfox::getPhrase('forumsystem.posted_on') . ' '.$aTime_forum.')</font><br>'.Phpfox::getLib('phpfox.parse.output')->parse($aText);


echo '<br><font size=1 color=gray>' . Phpfox::getPhrase('forumsystem.posts') . ': '.$aRow['total_post'].' | ' . Phpfox::getPhrase('forumsystem.views') . ': '.$aRow['total_view'].' - <a class=" " href="#" onclick="$Core.box(\'forum.reply\', 800, \'id='.$aRow['thread_id'].'\'); return false;"> ' . Phpfox::getPhrase('forumsystem.reply') . '</a>'; if (Phpfox::getParam('forumsystem.showposts') && $aRow['total_post'] != 0){ echo ' - <a href="javascript:void(0)" onclick="thread'.$id.$id1.'();">' . Phpfox::getPhrase('forumsystem.show_posts') . '</a>'; } echo '</div></div></font></font>';

echo '<div id='.$id.$id1.' class='.$id.$id1.' style="position:relative;display:none;left:30px;width:90%;top:-10px;z-index:99999;-moz-border-radius: 10px;-webkit-border-radius: 10px;">';

$count=0;  
if ($aRow['total_post'] != '0')
{     

echo '<div style="margin-left:5px;">';
foreach ($aRows1 as $aRow1)
{
if ($aRow['title'] != $aRow1['title']){

     $aPost_url = Phpfox::getLib('url')->makeUrl('forum.thread', $aRow1['thread_id'].'/'. $aRow['title_url'] .'/view_'. $aRow1['post_id'] );  
     $aTime = Phpfox::getTime(Phpfox::getParam('forum.forum_time_stamp'), $aRow1['time_stamp']);
     $aUser_url = Phpfox::getLib('url')->makeUrl($aRow1['user_name']);

$aFixe = str_replace("{file/pic/user/","",$aRow1['user_image']);
      $aFixe = str_replace("}","",$aFixe);

 
 if ($aRow1['user_image']){        
     $avatarpath_post = Phpfox::getParam('core.url_user');
     $avatarpath_post .= $aFixe;
     $avatarpath_post = str_replace("%s","_200_square",$avatarpath_post);
     
     if ($aRow1['user_image'] == "defaultfemale.jpg") 
     {
     $avatarpath_post = Phpfox::getParam('core.path').'theme/frontend/default/style/default/image/noimage/female_profile_50.png';
     }
     
     if ($aRow1['user_image'] == "defaultmale.jpg") 
     {
     $avatarpath_post = Phpfox::getParam('core.path').'theme/frontend/default/style/default/image/noimage/profile_50.png';
     }
     
     }else{
     if ($aRow1['gender'] == 1) 
     {
     $avatarpath_post = Phpfox::getParam('core.path').'theme/frontend/default/style/default/image/noimage/profile_50.png';
     }else{
     $avatarpath_post = Phpfox::getParam('core.path').'theme/frontend/default/style/default/image/noimage/female_profile_50.png';
     }
  }
 
$sAvatar = '<a href="'.Phpfox::getLib('url')->makeUrl($aRow1['user_name']).'" ><img src="'.$avatarpath_post.'" width="30" title="'.$aRow1['full_name'].'" style="	margin-right:5px;"></a>';

$name_var = $aRow1['full_name'];

if (strpos($name_var,' ') !== false) {
$words = explode(" ", $aRow1['full_name']);
$aName = "";
$i=0;

foreach ($words as $w) {
  $aName .= $w[0];
$i++;
if ($i==2){break;}	
}
}else{
$aName = substr($name_var,0,2); 
}

$aName = strtolower($aName);

$sAvatar = '<a class="no_image_user _size__25 _gender_ _first_'.$aName.'" href="'.Phpfox::getLib('url')->makeUrl($aRow1['user_name']).'" ><img src="'.$avatarpath_post.'" width="30" title="'.$aRow1['full_name'].'" style="style="width:30px;padding:0px""></a>';

 if (!$aRow1['user_image']){ 

$sAvatar  = '<a class="no_image_user _size__30 _gender_ _first_'.$aName.'" style="width:30px;padding:5px;" href="'.Phpfox::getLib('url')->makeUrl($aRow1['user_name']).'" ><span style="top:8px;">'.$aName.'</span></a>';
}

     //echo 'chars:'.Phpfox::getParam('forumsystem.char');
     
     //$aText = $aRow1['text_parsed'];
     
if (Phpfox::getParam('forumsystem.char') != 0){
     $aChars = Phpfox::getParam('forumsystem.char');
     $aText = $aRow1['text_parsed']." ";
if (strlen($aText) >= $aChars){
     $aText = substr($aText,0,$aChars);
     $aText = substr($aText,0,strrpos($aText,' '));
     $aText = $aText."...";
}
}else{
$aText = $aRow1['text_parsed'];
}

$aText_final = Phpfox::getLib('phpfox.parse.output')->parse($aText);


       echo '<div class="row_title" style="top:10px;margin: 2px;padding: 10px;background-color:white;-moz-border-radius: 10px;-webkit-border-radius: 10px;"><div class="row_title_image" >'.$sAvatar.'</div>';
     echo '<div style="margin-left:45px;min-height:25px;height:auto !important;height:25px;">'.$aText_final.'...<font size=1 color=gray><a href="'.$aPost_url.'"> ' . Phpfox::getPhrase('forumsystem.readmore') . '</a><br> ('.Phpfox::getPhrase('forumsystem.posted_on') . ' '.$aTime.')</font>';

$aPost_id = $aRow1['post_id'];
$aUser_id = $aRow1['user_id'];
$aThread_id = $aRow['thread_id'];
$aTotal_post = $aRow['total_post'];

if (Phpfox::getParam('forumsystem.attach'))
{
$aAttachs = Phpfox::getLib('phpfox.database')
          ->select('*')
           ->from(Phpfox::getT('attachment'), 'a') 
		->join(Phpfox::getT('forum_post'), 'b', 'b.post_id = a.item_id')
           ->where('b.post_id = '.$aRow1['post_id']) 
            ->order('a.time_stamp DESC')
            ->execute('getRows');  

if (!empty($aAttachs)){

echo '<h3>' . Phpfox::getPhrase('attachment.attached_files') . '</h3>';

}

foreach ($aAttachs as $aAttach){

if ($aAttach['link_id'] == 0){
$number = ($aAttach['file_size']/1024);
$image = str_replace("%s","",$aAttach['destination']);
$image_thumb = str_replace("%s","_thumb",$aAttach['destination']);


echo '<a href="'.Phpfox::getParam('core.path').'file/attachment/'.$image.'">'.$aAttach['file_name'].'</a><font size=1 color=gray> ('.number_format($number, 2, '.', '').'Kb, '.$aAttach['counter'].' ' . Phpfox::getPhrase('forumsystem.views') . ' )</font>';



echo '<br><a href="'.Phpfox::getParam('core.path').'file/attachment/'.$image.'" class="thickbox"><img src="'.Phpfox::getParam('core.path').'file/attachment/'.$image_thumb.'" width=120></a>';

echo '<br><br>';
}else{

$aLink = Phpfox::getLib('phpfox.database')
          ->select('*')
           ->from(Phpfox::getT('link'), 'a') 
		->where('a.link_id = '.$aAttach['link_id']) 
            ->order('a.time_stamp DESC')
            ->execute('getRow');  

$link = str_replace("http://", "", $aLink['link']);


//echo '<table ><tr><td>';

echo '<img src="'.$aLink['image'].'" width=40 height=40 align=left style="margin-right:5px;">';

//echo '</td><td>';

echo '<a href="http://'.$link.'" target=_new><b>'.$aLink['title'].'</b></a><br>'.$aLink['description'];

//echo '</td></tr></table>';
}

}
}


echo "<div class=\"forum_main forum_menu\" align=\"right\">";


     $aReply_url_quote = Phpfox::getLib('url')->makeUrl('forum.post.reply.module_group', 'item_'.$aRow['group_id'].'/id_' .$aRow['thread_id'].'/quote_'.$aPost_id); 


echo '<a href="#" class="forum_quote" onclick="$Core.box(\'forum.reply\', 800, \'item='.$aRow['group_id'].'&amp;id=' .$aRow['thread_id'].'&amp;quote='.$aRow1['post_id'].'\'); return false;"><img src="'.Phpfox::getParam('core.path').'theme/frontend/default/style/default/image/misc/comment_add.png" alt=""></a>';

echo '</div>'; 

 if (Phpfox::getParam('forumsystem.thank')){

$aThanks = Phpfox::getLib('phpfox.database')
          ->select('*')
           ->from(Phpfox::getT('like'), 'a') 
		->join(Phpfox::getT('user'), 'b', 'b.user_id = a.user_id')
		
           ->where('a.type_id = "forum_post" and a.item_id = '.$aRow1['post_id']) 
            ->order('a.time_stamp DESC')
            ->execute('getRows');  

if (!empty($aThanks)){

echo '<div class="forum_thank" style="background-image: url('.Phpfox::getParam('core.path').'module/forumsystem/images/background.png);-moz-box-shadow: 0px 0px 2px #aaaaaa;-webkit-box-shadow: 0px 0px 2px #aaaaaa;box-shadow: 0px 0px 2px #aaaaaa;"><font size=1>' . Phpfox::getPhrase('forumsystem.thanks') .'</font><div class="p_4">';

echo '<table><tr>';

foreach ($aThanks as $aThank){

$aFixe = str_replace("{file/pic/user/","",$aThank['user_image']);
      $aFixe = str_replace("}","",$aFixe);

 
 if ($aThank['user_image']){        
     $avatarpath_post = Phpfox::getParam('core.url_user');
     $avatarpath_post .= $aFixe;
     $avatarpath_post = str_replace("%s","_200_square",$avatarpath_post);
     
     if ($aThank['user_image'] == "defaultfemale.jpg") 
     {
     $avatarpath_post = Phpfox::getParam('core.path').'static/image/misc/female_noimage.png';
     }
     
     if ($aThank['user_image'] == "defaultmale.jpg") 
     {
     $avatarpath_post = Phpfox::getParam('core.path').'static/image/misc/noimage.png';
     }
     
     }else{
     if ($aThank['gender'] == 1) 
     {
     $avatarpath_post = Phpfox::getParam('core.path').'static/image/misc/noimage.png';
     }else{
     $avatarpath_post = Phpfox::getParam('core.path').'static/image/misc/female_noimage.png';
     }
  }
 
     

$name_var = $aThank['full_name'];

if (strpos($name_var,' ') !== false) {
$words = explode(" ", $aThank['full_name']);
$aName = "";
$i=0;

foreach ($words as $w) {
  $aName .= $w[0];
$i++;
if ($i==2){break;}	
}
}else{
$aName = substr($name_var,0,2); 
}

$aName = strtolower($aName);
$sAvatar = '<a class="no_image_user _size__25 _gender_ _first_'.$aName.'" href="'.Phpfox::getLib('url')->makeUrl($aThank['user_name']).'" ><img src="'.$avatarpath_post.'" width="30" title="'.$aThank['full_name'].'" style="padding:0px"></a>';

 if (!$aThank['user_image']){ 

$sAvatar  = '<div class="user_rows_image" style="padding:5px"><a class="no_image_user _size__30 _gender_ _first_'.$aName.'" style="width:30px;height:30px" href="'.Phpfox::getLib('url')->makeUrl($aThank['user_name']).'" ><span style="top:7px;">'.$aName.'</span></a></div>';
}


$aUser_url = Phpfox::getLib('url')->makeUrl($aThank['user_name']);

echo '
<td>'.$sAvatar.'</td>';

}
echo '</tr></table>';

echo '</div></div>';




}

}

echo '</div>';


$aThanks_ok = Phpfox::getLib('phpfox.database')
          ->select('*')
           ->from(Phpfox::getT('like'), 'a') 
		->where('a.item_id = '.$aRow1['post_id'].' and a.user_id = "'.$aMe.'" and a.type_id = "forum_post"') 
		 ->limit(1)
           ->order('a.time_stamp DESC')
           ->execute('getRow');


echo "<div class=\"forum_main forum_menu\" align=\"right\">";


$aTotal_post = $aTotal_post +1;

if (!$aThanks_ok){


if (Phpfox::isUser(true)){
echo '<div id="js_feed_like_holder_forum_post_'.$aPost_id .'" class="comment_mini_content_holder">
        <div class="comment_mini_content_holder_icon"></div>
			<div class="comment_mini_content_border">

				<div class="comment_mini_content_commands">
					<div class="feed_like_link">
    <a role="button" data-toggle="like_toggle_cmd" data-label1="Like" data-label2="Unlike" data-liked="0" data-type_id="forum_post" data-item_id="'.$aPost_id .'" data-feed_id="'.$aPost_id .'" data-is_custom="0" class="js_like_link_toggle unlike">
        <span>Like</span>
    </a>
					</div>

					<div class="js_comment_like_holder" id="js_feed_like_holder_'.$aPost_id .'">
						<div id="js_like_body_'.$aPost_id .'" class="font-size:8pt;">
	
						</div>
					</div></div></div></div>';
}

}else{
if (Phpfox::isUser(true)){



echo '
<div id="js_feed_like_holder_forum_post_'.$aPost_id .'" class="comment_mini_content_holder">
        <div class="comment_mini_content_holder_icon"></div>
			<div class="comment_mini_content_border">

				<div class="comment_mini_content_commands">
					<div class="feed_like_link">
    <a role="button" data-toggle="like_toggle_cmd" data-label1="Like" data-label2="Unlike" data-liked="1" data-type_id="forum_post" data-item_id="'.$aPost_id .'" data-feed_id="'.$aPost_id .'" data-is_custom="0" class="js_like_link_toggle liked">
        <span>Unlike</span>
    </a>
					</div>

					<div class="js_comment_like_holder" id="js_feed_like_holder_'.$aPost_id .'">
						<div id="js_like_body_'.$aPost_id .'"><div class="activity_like_holder" id="activity_like_holder_'.$aPost_id .'" >' . Phpfox::getPhrase('feed.you_like_this') . '
	
						</div></div>
					</div></div></div></div>';
}


}

echo '</div>'; 


echo '</div><br>';

 
}}




    echo '</div>';


    
}





echo '</div>'; 
  $id1++;


}

 echo '</div>';

 $id++; 

  
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
<?php endif;  unset($this->_aVars['sHeader'], $this->_aVars['sComponent'], $this->_aVars['aFooter'], $this->_aVars['sBlockBorderJsId'], $this->_aVars['bBlockDisableSort'], $this->_aVars['bBlockCanMove'], $this->_aVars['aEditBar'], $this->_aVars['sDeleteBlock'], $this->_aVars['sBlockTitleBar'], $this->_aVars['sBlockJsId'], $this->_aVars['sCustomClassName'], $this->_aVars['aMenu']); ?>
