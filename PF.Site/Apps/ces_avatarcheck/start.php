<?php
$auth = new Core\Auth\User();
	if (!$auth->isLoggedIn()) {
		return false;
	}

(new Core\Route\Group('admincp/ces_avatarcheck', function () {
    new Core\Route('/promotions', function (\Core\Controller $Controller) {

        return $Controller->render('promotions.html');
    });
}));



block('Avatar Check', function(){
	
$html ="";

$path1 = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path1);

$aUser = Phpfox::getService('user')->get(Phpfox::getUserId(), true);

if (setting('enable_avatarcheck') && $aUser['user_image'] == null){
$html .= '

<div style="width:100%;height:80px;background-color:#ffffff;border: 1px lightgrey solid;padding:3px;-moz-box-shadow: 0px 0px 4px #aaaaaa;-webkit-box-shadow: 0px 0px 4px #aaaaaa;box-shadow: 0px 0px 4px #aaaaaa;"><img src="'.$path.'PF.Site/Apps/ces_avatarcheck/no-avatar.png" width=75 align=left><h4 style="display: table-cell; vertical-align: middle;height:80px">'._p('Remember to add an Avatar to your profile. Change your profile image ').'<a href="'.user()->url.'">'._p('HERE').'</a></h4>

</div><br>
';
}
return view('@ces_avatarcheck/index.html', [
			'content' => $html

		]);


	});


