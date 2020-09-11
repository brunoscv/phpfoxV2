<?php
$auth = new Core\Auth\User();
	if (!$auth->isLoggedIn()) {
		return false;
	}

(new Core\Route\Group('admincp/ces_weather', function () {
    new Core\Route('/promotions', function (\Core\Controller $Controller) {

        return $Controller->render('promotions.html');
    });
}));



block('Weather Widget', function(){
	
$html ="";
$aEu = Phpfox::getUserBy('user_id');

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
$aCity = $aUsuario['city_location'];

}

If (setting('weather_temperature') == 'C'){
	$temp = 'CELSIUS';
}else{
	$temp = 'FAHRENHEIT';
}

If (setting('win_spead') == 'M'){
	$win = 'MILE_PER_HOUR';
}else{
	$win = 'KILOMETER_PER_HOUR';
}

if (setting('show_widget') ){
$html .= '

<iframe src="https://www.meteoblue.com/'.setting('weather_language').'/weather/widget/three?geoloc=detect&nocurrent=0&nocurrent=1&noforecast=0&days=4&tempunit='.$temp.'&windunit='.$win.'&layout=image"  frameborder="0" scrolling="NO" allowtransparency="true" sandbox="allow-same-origin allow-scripts allow-popups allow-popups-to-escape-sandbox" style="width: 100%;height: 490px"></iframe><div><!-- DO NOT REMOVE THIS LINK --><a href="https://www.meteoblue.com/en/weather/forecast/week?utm_source=weather_widget&utm_medium=linkus&utm_content=three&utm_campaign=Weather%2BWidget" target="_blank">meteoblue</a></div>';

}else{

$html .= '<a href="https://www.accuweather.com/'.setting('weather_language').'/pt/lisbon/274087/weather-forecast/274087" class="aw-widget-legal">
<!--
By accessing and/or using this code snippet, you agree to AccuWeather’s terms and conditions (in English) which can be found at https://www.accuweather.com/en/free-weather-widgets/terms and AccuWeather’s Privacy Statement (in English) which can be found at http://www.accuweather.com/en/privacy.
-->
</a><div id="awcc1473936176665" class="aw-widget-current"  data-locationkey="" data-unit="'.setting('weather_temperature').'" data-language="'.setting('weather_language').'" data-useip="true" data-uid="awcc1473936176665"></div><script type="text/javascript" src="https://oap.accuweather.com/launch.js"></script>
';
}
return view('@ces_weather/index.html', [
			'content' => $html

		]);


	});


