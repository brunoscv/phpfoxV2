<?php

block(11, 'profile.index', function() {
	if(setting("ennableUP") == 0) return;

	$color = setting("colorUP");
	$size = setting("sizeUP");
	$shadow = setting("ennableSH");

	$owner = User_Service_User::instance()->get(request()->segment(1), false);

	$name =	$owner['user_name'];
	if ($owner['user_name'] == NULL || substr_count($owner['user_name'], "profile-") > 0) {
		$name = $owner['full_name'];
	}
		
	return view('@username_on_profile_page/user.html', [
		'name' => $name,
		'color' => $color,
		'size' => $size,
		'shadow' => $shadow
	]);
});

?>