<?php
$auth = new Core\Auth\User();
	if (!$auth->isLoggedIn()) {
		return false;
	}

(new Core\Route\Group('admincp/ces_members_in_your_state', function () {
    new Core\Route('/promotions', function (\Core\Controller $Controller) {

        return $Controller->render('promotions.html');
    });
}));



block('Members In Your State', function(){

$aEu = Phpfox::getUserBy('user_id');
$aGender = Phpfox::getUserBy('gender');
$State="";
$html1="";

$aUsuarios = Phpfox::getLib('phpfox.database')
          ->select('a.gender, a.user_id, a.country_iso, b.country_child_id,  b.city_location')
            ->from(Phpfox::getT('user'), 'a')
            ->join(Phpfox::getT('user_field'), 'b', 'a.user_id = b.user_id')
            ->limit(2)
	    ->where('a.user_id = "'.$aEu.'"')
            ->order('joined DESC')
            ->execute('getRows');

foreach ($aUsuarios as $aUsuario)
{		
$aState = $aUsuario['country_child_id'];
$aSee_more = Phpfox::getLib('url')->makeUrl('user.browse');
$aSee_more = $aSee_more.'?search%5Bcountry_child_id%5D='.$aState;
}

if (setting('gender_state')){

	if ($aGender == 1){
		$filter = 'a.gender = 2 and ';
	}else{
		$filter = 'a.gender = 1 and ';
	}

}else{
	$filter = '';
}

if (setting('avatar_state')){

$avatar= ' and a.user_image != ""';
}else{
$avatar= '';
}


$aUsers = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('user'), 'a')
            ->join(Phpfox::getT('user_field'), 'b', 'a.user_id = b.user_id')
            ->limit(setting('number_members_state'))
            ->where($filter.'b.country_child_id = "'.$aState.'" and a.user_id != "'.$aEu.'"'.$avatar)
            ->order('rand()')
            ->execute('getRows');


if ($aState) {

if (!$aUsers) {$html1 = _p('No members in your state'); }

$html1 .= '<div class="user_rows_mini">';
foreach ($aUsers as $aUser)
{	
       
     
    $html1 .= '


    <div class="user_rows" style="position:relative;top:15px;left:5px;width:100px;height:120px;"><div class="user_rows_image">';




$html1 .= '<div align="center" style="position:absolute;bottom:19px;width:95px;left: 0px;
right: 0px;margin: auto;z-index:10;font-size:xx-small;color:white;font-weight: bold;background-color:orange;padding:2px;border-radius:5px;">'.moment()->toString($aUser['last_activity']).'</div>';



if ($aRow1['user_image']){        
	$avatarpath = '<a href="'.Phpfox::getLib('url')->makeUrl($aUser['user_name']).'"><img src="'.(new \Api\User())->get($aUser['user_id'])->photo['120px'].'"></a>';
}else{
$avatarpath = (new \Api\User())->get($aUser['user_id'])->photo_link; 
}

$html1 .= $avatarpath.'</div>

<span class="user_profile_link_span">

    '.(new \Api\User())->get($aUser['user_id'])->name_link.'

</span>
</div>';



     

}
$html1 .= '</div>';
}else{
$html1 .= _p('To see the results you must configure your state').' <a href="'.Phpfox::getLib('url')->makeUrl('user.profile').'">'._p('HERE').'</a>';
}


if ($aUsers && $aState){
	$html1 .= '<br><br><a href="'.$aSee_more.'"><div class="message" style="position:absolute;bottom:-10px;right:-5px;padding:2px;text-transform: uppercase;color:#ffffff;text-decoration:none;text-transform: uppercase;font-size: 12px;display: inline-block;margin: 0 0px;">'._p('View All').'</div></a>';


}



return view('@ces_members_in_your_state/index.html', [
			'content' => $html1

		]);

	});
