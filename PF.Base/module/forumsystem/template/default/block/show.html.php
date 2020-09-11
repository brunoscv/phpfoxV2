{php}
$aMe = Phpfox::getUserBy('user_id');
$id = 1;
$id1 = 10000; 
$count= 0;
$usergroup = Phpfox::getUserBy('user_group_id');



if (Phpfox::getParam('forumsystem.show_categories')){

$aForums = Phpfox::getLib('phpfox.database')
          ->select('b.name, b.name_url, b.forum_id, b.total_post, b.total_thread, b.description')
            ->from(Phpfox::getT('forum'), 'b')
	    ->where('is_category = 1')
            ->execute('getRows'); 

$sToken = Phpfox::getService('log.session')->getToken(); 
{/php}

<div style="position:relative;float: right;right:10px;top:0px;">
<form method="post" name="go" action="">

<select name="num" onChange="go.submit();" style="font-size: 8pt;font-style: normal;">
	<option value="">- {phrase var='forumsystem.select'} -</option>
	<option value="" selected>{phrase var='forumsystem.all'}</option>

{php}
	
foreach ($aForums as $aForum)
{ 

echo '<option value="'.$aForum['forum_id'].'"';

if (Phpfox::getLib('phpfox.request')->get('num') == $aForum['forum_id']){

echo 'selected';
}


echo '>'._p($aForum['name']).'</option>';
	
}

echo '</select>
<input name="phpfox[security_token]" value="'.$sToken.'" type="hidden" value="Select" /></form></div><br>';

}

if (Phpfox::getLib('phpfox.request')->get('num')){

$aForum_id = 'and b.parent_id = "'.Phpfox::getLib('phpfox.request')->get('num').'"';
}else{
$aForum_id = '';
}



$aRows = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('forum'), 'b')
            ->join(Phpfox::getT('forum_thread'), 'c', 'b.thread_id = c.thread_id')
            ->limit(Phpfox::getParam('forumsystem.forums_number'))
	    ->where('is_category = 0 '.$aForum_id)
            ->order('c.time_update DESC')
            ->execute('getRows');  

if (empty($aRows)){
$aRows = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('forum'), 'b')

            ->limit(Phpfox::getParam('forumsystem.forums_number'))
	    ->where('is_category = 0 '.$aForum_id)
            ->execute('getRows'); 
            
          
}






foreach ($aRows as $aRow)
{            

$access = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('forum_access'))
            ->limit(1)
	    ->where('forum_id = '.$aRow['forum_id'].' && user_group_id = '.$usergroup.' && var_name = "can_view_forum" && var_value = 0')
            ->execute('getRow'); 



if ($access)
{
continue;
}

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




          $aChars = 250;
     $aText = _p($aRow['description'])." ";
     $aText = substr($aText,0,$aChars);
     $aText = substr($aText,0,strrpos($aText,' '));
     $aText = $aText."...";
     
     
$aForum_url = Phpfox::getLib('url')->makeUrl('forum/'.$aRow['forum_id'], array($aRow['name_url'])); 

    	$aNewThread_url = Phpfox::getLib('url')->makeUrl('forum.post.thread', 'id_' . $aRow['forum_id']); 
	$aMarks_read = Phpfox::getLib('url')->makeUrl('forum.read', 'forum_' . $aRow['forum_id']);
	
	
     echo '<div class="row_title" style="padding:10px;"><div class="row_title_image" ><a href="'.$aForum_url.'"><img src="'.Phpfox::getParam('core.path').'module/forumsystem/images/'.strtolower(Phpfox::getParam('forumsystem.icon')).'/icon_forum.png" width=30 height=30></a></div>';
     echo '<div class="row_title_info" style="margin-left:45px"><b><a href="'.$aForum_url.'">'._p($aRow['name']).'</a></b><br>'.$aText;

     echo '<br><font size=1 color=gray>' . Phpfox::getPhrase('forumsystem.threads') . ': '.$aRow['total_thread'].' | ' . Phpfox::getPhrase('forumsystem.posts') . ': '.$aRow['total_post'].' - <a href="'.$aNewThread_url.'">' . Phpfox::getPhrase('forumsystem.new_thread') . '</a> - <a href="'.$aMarks_read.'">' . Phpfox::getPhrase('forumsystem.mark_read') . '</a>'; if (Phpfox::getParam('forumsystem.showthreads') && $aRow['total_thread'] != 0){echo ' - <a href="javascript:void(0)" onclick="forum'.$id.'();">' . Phpfox::getPhrase('forumsystem.show_hide_thread') . '</a>'; } echo'</div></div></font>';


echo '<div id='.$id.' class='.$id.' style="background-image: url('.Phpfox::getParam('core.path').'module/forumsystem/images/background.png);margin: 2px;padding: 10px;border-radius:10px;position:relative;display:none;left:60px;width:80%;top:-10px;-moz-box-shadow: 0px 0px 4px #aaaaaa;-webkit-box-shadow: 0px 0px 4px #aaaaaa;box-shadow: 0px 0px 4px #aaaaaa;">';

$aRows = Phpfox::getLib('phpfox.database')
          ->select('a.time_stamp, a.thread_id, a.title, a.total_post, a.total_view, a.title_url, b.name, b.name_url, b.forum_id, c.gender, c.user_image, c.user_name, c.full_name, e.text_parsed, d.post_id')
            ->from(Phpfox::getT('forum_thread'), 'a')
            ->join(Phpfox::getT('forum'), 'b', 'a.forum_id = b.forum_id')
            ->join(Phpfox::getT('user'), 'c', 'a.user_id = c.user_id')
            ->join(Phpfox::getT('forum_post'), 'd', 'd.post_id = a.start_id')
            ->join(Phpfox::getT('forum_post_text'), 'e', 'e.post_id = d.post_id')
            ->limit(Phpfox::getParam('forumsystem.threads_number'))
	    ->where('group_id = 0 and a.forum_id = "'.$aRow['forum_id'].'"')
            ->order('time_update DESC')
            ->execute('getRows');  

 
         
           

foreach ($aRows as $aRow)
{

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

$aMe = Phpfox::getUserBy('user_id');

$aRows_track = Phpfox::getLib('phpfox.database')
          ->select('a.time_stamp, b.time_stamp AS time')
            ->from(Phpfox::getT('forum_track'), 'a')
            ->join(Phpfox::getT('forum_thread_track'), 'b', 'b.thread_id = "'.$aRow['thread_id'].'"')
            ->where('a.forum_id = "'.$aRow['forum_id'].'" and a.user_id = "'.$aMe.'" and b.user_id != "'.$aMe.'" and a.time_stamp < b.time_stamp')
           ->execute('getRows'); 
  

  foreach ($aRows_track as $aTrack)
{
$count = 1;
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
            ->select('a.time_stamp, a.title, a.post_id, a.thread_id, b.text_parsed, b.text, c.gender, c.user_image, c.user_name, c.full_name, c.user_id')
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
     $avatarpath = Phpfox::getParam('core.path').'theme/frontend/default/style/default/image/noimage/profile_50.png';
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
         $aThread_url = Phpfox::getLib('url')->makeUrl('forum/thread/'.$aRow['thread_id'].'/'.$aRow['title_url']); 
     $aForum_url = Phpfox::getLib('url')->makeUrl('forum/'.$aRow['forum_id'], array($aRow['name_url'])); 
     $aReply_url = Phpfox::getLib('url')->makeUrl('forum.post.reply', 'id_' .$aRow['thread_id']); 
     
     echo '<div class="row_title" style="margin:3px;padding:20px;background-color:white;border-radius:10px"><div class="row_title_image" >'.$sAvatar;

if ($count == 1 && Phpfox::getParam('forumsystem.newposts')){

echo '<font size=1 color=white><div style="position:absolute;left:0px;width:47px;top:25px;background-color:'.Phpfox::getParam('forumsystem.tag_color').'">new posts</div></font>';
} 

echo'</div>';
     echo '<div class="row_title_info forum_content item_view_content" style="margin-left:55px;min-height:55px;height:auto !important;height:55px;"><a href="'.$aThread_url.'"><b>'.$aRow['title'].'</b></a> ' . Phpfox::getPhrase('forumsystem.by') . ' <i>'.$aRow['full_name'].'</i><font size=1 color=gray> (' . Phpfox::getPhrase('forumsystem.posted_on') . ' '.$aTime_forum.')</font><br>'.Phpfox::getLib('phpfox.parse.output')->parse($aText);
 

echo '<br><font size=1 color=gray>' . Phpfox::getPhrase('forumsystem.posts') . ': '.$aRow['total_post'].' | ' . Phpfox::getPhrase('forumsystem.views') . ': '.$aRow['total_view'].' - <a class=" " href="#" onclick="$Core.box(\'forum.reply\', 800, \'id='.$aRow['thread_id'].'\'); return false;">' . Phpfox::getPhrase('forumsystem.reply') . '</a>'; if (Phpfox::getParam('forumsystem.showposts') && $aRow['total_post'] != 0){ echo ' - <a href="javascript:void(0)" onclick="thread'.$id.$id1.'();">' . Phpfox::getPhrase('forumsystem.show_posts') . '</a>'; } 

echo '</font></font>';

if (Phpfox::getParam('forumsystem.attach'))
{
$aAttachs = Phpfox::getLib('phpfox.database')
          ->select('*')
           ->from(Phpfox::getT('attachment'), 'a') 
		->join(Phpfox::getT('forum_post'), 'b', 'b.post_id = a.item_id')
           ->where('a.item_id = '.$aRow['post_id']) 
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

echo '</div></div>';

echo '<div id='.$id.$id1.' class='.$id.$id1.' style="position:relative;display:none;left:30px;width:90%;top:-10px;z-index:99999;-moz-border-radius: 10px;-webkit-border-radius: 10px;">';

$count=0;  
if ($aRow['total_post'] != '0')
{     

echo '<div style="margin-left:5px;">';
foreach ($aRows1 as $aRow1)
{
if ($aRow['title'] != $aRow1['title']){

     $aPost_url = Phpfox::getLib('url')->makeUrl('forum/thread/'.$aRow['thread_id'].'/'.$aRow['title_url'].'/post_'.$aRow1['post_id']); 
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

$sAvatar = '<a class="no_image_user _size__25 _gender_ _first_'.$aName.'" href="'.Phpfox::getLib('url')->makeUrl($aRow1['user_name']).'" ><img src="'.$avatarpath_post.'" width="30" title="'.$aRow1['full_name'].'" style="width:30px;padding:0px"></a>';

 if (!$aRow1['user_image']){ 

$sAvatar  = '<div class="user_rows_image" style="padding:5px"><a class="no_image_user _size__30 _gender_ _first_'.$aName.'" style="width:30px;" href="'.Phpfox::getLib('url')->makeUrl($aRow1['user_name']).'" ><span style="top:7px;">'.$aName.'</span></a></div>';
}


     //echo 'chars:'.Phpfox::getParam('forumsystem.char');
     
     //$aText = $aRow1['text_parsed'];
     
if (Phpfox::getParam('forumsystem.char') != 0){
     $aChars = Phpfox::getParam('forumsystem.char');
     $aText = $aRow1['text_parsed']." ";
     $aText = substr($aText,0,$aChars);
     $aText = substr($aText,0,strrpos($aText,' '));
     $aText = $aText."...";
}else{
$aText = $aRow1['text_parsed'];
}

$aText_final = Phpfox::getLib('phpfox.parse.output')->parse($aText);

$url = Phpfox::getParam('core.path');
$url = str_replace("index.php/","PF.Base/",$url);

       echo '<div class="row_title" style="top:10px;margin: 2px;padding: 10px;background-color:white;border-radius:5px;-moz-border-radius: 10px;-webkit-border-radius: 10px;"><div class="row_title_image" >'.$sAvatar.'</div>';
     echo '<div style="margin-left:45px;min-height:25px;height:auto !important;height:25px;" class="forum_content item_view_content">'.$aText_final.'<font size=1 color=gray><a href="'.$aPost_url.'">' . Phpfox::getPhrase('forumsystem.readmore') . '</a><br> ('.Phpfox::getPhrase('forumsystem.posted_on') . ' '.$aTime.')</font>';

     $aReply_url_quote = Phpfox::getLib('url')->makeUrl('forum.post.reply', 'id_' .$aRow['thread_id'].'/quote_'.$aRow1['post_id']); 


echo '<div style="float: right;"><a href="#" class="forum_quote" onclick="$Core.box(\'forum.reply\', 800, \'id=' .$aRow['thread_id'].'&amp;quote='.$aRow1['post_id'].'\'); return false;" title="' . Phpfox::getPhrase('forumsystem.quote_reply') . '"><img src="'.$url.'theme/frontend/default/style/default/image/misc/comment.png" alt=""></a></div>';


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



}

}


    echo '</div>';
    
}
echo '</div>'; 
  $id1++;
}

 echo '</div>';

 $id++; 

  
}


{/php}


