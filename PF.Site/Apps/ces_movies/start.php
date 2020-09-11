<?php

event('feed_map', function($map) {
    if (substr($map->link, -13) == '/movies/view/') {
      
$value = $map->data_row['item_id'];  
$get = db()->select('*')->from(':feed')->where(['feed_id' => $value])->get();

$map->link = str_replace("view/","view",$map->link);

        $map->link = $map->link . '?m=tt' . $get['item_id'];
    }
});


(new Core\Route\Group('admincp/ces_movies', function () {
    new Core\Route('/', function (\Core\Controller $Controller) {

auth()->isAdmin(true);

		$c = storage()->order('DESC')->all('ces_movies_category');

		return view('admincp.html', [
			'categories' => $c
		]);
		


  });
}));

(new Core\Route\Group('admincp/ces_movies', function () {
    new Core\Route('/promotions', function (\Core\Controller $Controller) {

        return $Controller->render('promotions.html');
    });
}));



(new Core\Route\Group('admincp/ces_movies', function () {
    new Core\Route('/ratings', function (\Core\Controller $Controller) {

$html ="";

$html = 'In this page you can update the IMDb ratings of the movies that have no values. <br>This is special usefull for the ratings of upcoming movies that are added to the DB with no rating value.<br><br>';

$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'ratings" title="sss" ><button type="button" class="button">'._p('Click here to update ratings with no value').'</button>
</a>

<br><div id="ratings" style="width:100%;overflow:auto; overflow-x:hidden;">The update could take a while.... be patient!
</div>';

        return view('ratings.html', ['content' => $html]);
    });
}));



(new Core\Route\Group('admincp/ces_movies', function () {
    new Core\Route('/delete', function (\Core\Controller $Controller) {

auth()->isAdmin(true);

		storage()->delById(request()->get('id'));

		\Phpfox::addMessage(_p('Category successfully deleted.'));

		return url()->send('admincp.app', ['id' => 'ces_movies']);

  });
}));

(new Core\Route\Group('admincp/ces_movies', function () {
    new Core\Route('/order', function (\Core\Controller $Controller) {

		auth()->isAdmin(true);

		storage()->updateOrderById(request()->get('ids'));

		return true;

  });
}));


(new Core\Route\Group('admincp/ces_movies', function () {
    new Core\Route('/categories', function (\Core\Controller $Controller) {

auth()->isAdmin(true);

		$is_edit = false;
		$category_name = '';
		if (($id = request()->get('id'))) {
			$is_edit = true;

			$category = storage()->getById($id);
			$category_name = $category->value;
		}

		if ($val = request()->get('val')) {
			if (empty($val['name'])) {
				error(_p('Provide a name.'));
			}

			$name = $val['name'];
			if ($is_edit) {
				storage()->updateById($id, $name);
			}
			else {
				storage()->set('ces_movies_category', $name);
			}

			\Phpfox::addMessage(_p('Category successfully added.'));

			return url()->send('admincp.app', ['id' => 'ces_movies']);
		}

		title(_p('New Category'));

		return view('admincp_category.html', [
			'category_id' => $id,
			'category_name' => $category_name
		]);

        
    });
}));


/**
 * namespace for the app and group all routes in it.
 */
group('/movies', function() {

   /**
    * Index route for your namespace.
    */


route('/', function() {

if (setting('hide_guests')){
  auth()->membersOnly();
}

  // Set the title
      title(_p('Movie'));
 
      // Set a section title
      section(_p('Movies'), '/movies');
 
      // Create a sub menu
	
	$sub_menu = [
		
      ];

	  
 Menu('/movies/', $sub_menu);
storage()->del('menu');
storage()->set('menu', $sub_menu);

storage()->del('section');
storage()->set('section', 'last');

url()->send('/movies/last');  

$html ="";

if (auth()->isLoggedIn() && user('share_movie', true)) {

if (setting('share_manual')){
button(_p('Share a Movie'), url('/movies/sharenew'));
}else{
button(_p('Share a Movie'), url('/movies/add'), ['css_class' => 'popup']);
}

}



      // SEARCH BLOCK
    block(1, function() {
$html=""; 
$html .= '<form method="post" action="'.Phpfox::getParam('core.path').'movies/search" >

			<input type="text" id="name" name="name" value="" placeholder="'._p('Write some words to search').'">
		<select name="type" class="dropdown-toggle">
<option value="0" selected>'._p('Title').'</option>
<option value="1">'._p('imdbID').'</option>
<option value="2">'._p('Director').'</option>
<option value="3">'._p('Actor').'</option>
<option value="4">'._p('Writer').'</option>
<option value="5">'._p('Genre').'</option>
</select>
		<input type="submit" value="'._p('Submit').'" class="btn btn-primary">
</form>';
         // Load views/search.html
         return view('@ces_movies/search.html', ['content' => $html]);
      });


//CATEGORY BLOCK

block(1, function() {

$html ="";

			$categories = storage()->order('DESC')->all('ces_movies_category');

			if (!$categories) {
			$html = 'No categories!';			
			}



foreach ($categories as $category) {

	$html .= '<a href="'.Phpfox::getParam('core.path').'movies/category?c='.$category->value.'" ><input type="button"  class="button" style="padding:5px;margin:2px" value="'.$category->value.'"></a>';
			}



			return view('@ces_movies/category.html', ['content' => $html]);

		});



// NEW RELEASES BLOCK  

if (auth()->isLoggedIn() && setting('show_upcoming')) {
    block(2, function() {
$html=""; 
$html1=""; 
$get="";
$addfeed=0;
$upcoming=array();
$time="";
$imdb="";
$Me="";
$url="";
$lang="";
$country="";
$path="";
$loop="";
$loop1="";
$internal ="";

$country = user()->location['iso'];

$upcoming = storage()->get($country);

if (!$upcoming){

$url = 'https://www.imdb.com/calendar/?region='.user()->location['iso'];
//get the page content
$get = file_get_contents($url);

$time= time()+43000;
storage()->del($country);
storage()->set($country, [
   'imdb' => $get,
   'time' => $time	
]);

}else{

$get = $upcoming->value->imdb;
if ($upcoming->value->time < time()){
storage()->del($country);
}
}



$pattern = '/<\/h4>(.*?)<h4>/ms';
preg_match($pattern, $get, $match);


preg_match_all('/title\/(.*?)\/\?ref_=rlm/ms', $match[1], $match1);



$loop = setting('num_upcoming_search');


for ($i = 0; $i < $loop; $i++) {


if (isset($match1[1][$i])){
		$imdb = $match1[1][$i];
}


$check_movie = db()->select('*')->from(':ces_movies')->where(['imdbID' => $imdb])->get();

if (!$check_movie){

		$movie = file_get_contents('https://www.omdbapi.com/?i='.$imdb.'&type=movie&plot=full&r=json&apikey=2398c1d6');
		$movie = json_decode($movie, true);


if (isset($movie['Poster']) && $movie['Poster'] != "N/A" && $movie['Response'] != "False"){
$titulo = str_replace(" ","%20",$movie['Title']);
$director = str_replace(" ","%20",$movie['Director']);

		$trailers = file_get_contents('https://www.googleapis.com/youtube/v3/search?part=id,snippet&q='.$titulo.'%20'.$director.'%20offical%20trailer%20movie&key=AIzaSyCwNJ28JWwlX6Q3D-7AanWZvd5N_VWpuzw&maxResults=1&type=video');
		$trailers = json_decode($trailers, true);

$videoId="";

foreach ($trailers['items'] as $trailer) {
        $videoId  = $trailer['id']['videoId'];  
    }

   $embed = '<iframe width="640" height="360" src="https://www.youtube.com/embed/'.$videoId.'" frameborder="0" allowfullscreen></iframe>';

$Me = user()->id;

if (setting('translate_content')){

$lang = strtoupper(setting('translate_language'));

$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=EN&tl=".urlencode($lang)."&dt=t&q=".urlencode($movie['Genre']);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
if($response !== false){
      preg_match('/\[\[\[\"(.*?)\"/', $response, $matches);
      $movie['Genre'] = $matches[1];
}

$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=EN&tl=".urlencode($lang)."&dt=t&q=".urlencode($movie['Plot']);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
if($response !== false){
      preg_match('/\[\[\[\"(.*?)\"/', $response, $matches);
      $movie['Plot'] = $matches[1];
}

$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=EN&tl=".urlencode($lang)."&dt=t&q=".urlencode($movie['Language']);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
if($response !== false){
      preg_match('/\[\[\[\"(.*?)\"/', $response, $matches);
      $movie['Language'] = $matches[1];
}

$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=EN&tl=".urlencode($lang)."&dt=t&q=".urlencode($movie['Country']);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
if($response !== false){
      preg_match('/\[\[\[\"(.*?)\"/', $response, $matches);
      $movie['Country'] = $matches[1];
}

$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=EN&tl=".urlencode($lang)."&dt=t&q=".urlencode($movie['Awards']);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
if($response !== false){
      preg_match('/\[\[\[\"(.*?)\"/', $response, $matches);
      $movie['Awards'] = $matches[1];
}

}

		db()->insert(':ces_movies', ['imdbID' => $imdb, 'Title' => $movie['Title'], 'Year' => $movie['Year'], 'User' => 1, 'Runtime' => $movie['Runtime'], 'Genre' => $movie['Genre'], 'Released' => $movie['Released'], 'Director' => $movie['Director'], 'Writer' => $movie['Writer'], 'Actors' => $movie['Actors'], 'Rated' => $movie['Rated'], 'imdbRating' => $movie['imdbRating'], 'imdbVotes' => $movie['imdbVotes'], 'Embed' => $embed, 'Plot' => $movie['Plot'], 'Language' => $movie['Language'], 'Country' => $movie['Country'], 'Awards' => $movie['Awards'], 'time_stamp' => time(), 'Upcoming' => $country]);


$internal = str_replace("index.php","",$_SERVER['SCRIPT_FILENAME']); 

$ch = curl_init($movie['Poster']);
$fp = fopen($internal.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg', 'wb');
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);

$addfeed=1;

}
}else{


if (strpos($check_movie['Upcoming'],$country) !== false) {
}else{
$check_movie['Upcoming'] = $check_movie['Upcoming'].', '.$country;
db()->update(':ces_movies', ['Upcoming' => $check_movie['Upcoming']], ['imdbID' => $check_movie['imdbID']]);

}


}


}

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('num_upcoming'))
		 ->where ('Upcoming LIKE "%'.$country.'%"')
	       ->order('time_stamp DESC')
            ->execute('getRows');

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);

if (!$movies){
$html .= _p('No Movies Found!');
}

$html1 .= '<br><div>';
$i=1;
foreach ($movies as $movie) {

$filename = $internal.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg';
$size = getimagesize($filename);

if (!$size[0]){

$movie['Poster'] = $path.'PF.Site/Apps/ces_movies/no_image.jpg';
$ch = curl_init($movie['Poster']);
$fp = fopen($internal.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg', 'wb');
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);

}

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:1px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 100px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:100px;height:150px;background-color:#dddddd;"></div>';

if ($addfeed == 1 && setting('add_feed_upcoming') && $i<6){

$i=$i+1;     
$html1 .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:5px;padding:3px;width:100px;height:150px;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#dddddd;" align=left>';


}
}

$html1 .= '</div>';

$html .= '<div class="page_breadcrumbs_menu" style="position:absolute;top:-40px;right:1px;"><a class="btn-success" style="padding:5px" href="'.Phpfox::getParam('core.path').'movies/theaters"><span></span>'._p('More Movies').'</a></div>'; 

$country = Phpfox::getPhraseT(Phpfox::getService('core.country')->getCountry(Phpfox::getUserBy('country_iso')), 'country');

if ($addfeed == 1 && setting('add_feed_upcoming')){

$html1 = str_replace('"','\"',$html1);
$html1 = str_replace("/","\/",$html1);
$feed = '{"title":"'._p('Upcoming movie releases in ').$country.'","text":"'.$html1.'"}';

$imdb1 = str_replace("tt","",$imdb);



}

         return view('@ces_movies/releases_block.html', ['content' => $html,'country' => $country]);
      });
}

// LAST MOVIES BLOCK  
if (setting('show_last')) {
      
block(2, function() {
$html=""; 

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('num_last'))
		 ->where ('Upcoming = ""')
	       ->order('time_stamp DESC')
            ->execute('getRows');

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);

if (!$movies){
$html .= _p('No Movies Found!');
}



foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:1px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 100px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:100px;height:150px;background-color:#dddddd;">';

if (setting('show_tag_dashboard')){
$html .= '<div style="position:absolute;right:3px;bottom:3px;border-radius: 2px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:1px;font-size:xx-small;color:black">'.(new \Api\User())->get($movie['User'])->name.'</div>';
}



$html.= '</div>';
}
$html .= '<div class="page_breadcrumbs_menu" style="position:absolute;top:-40px;right:1px;"><a class="btn-success" style="padding:5px" href="'.Phpfox::getParam('core.path').'movies/last"><span></span>'._p('More Movies').'</a></div>'; 

         return view('@ces_movies/last_block.html', ['content' => $html]);
      });
}



// TOP MOVIES BLOCK  
if (setting('show_top')) {

block(2, function() {
$html=""; 

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('num_top'))
		 ->order('imdbRating DESC')
            ->execute('getRows');

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);

if (!$movies){
$html .= _p('No Movies Found!');
}

foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:1px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 100px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:100px;height:150px;background-color:#dddddd;">';

if (setting('show_tag_dashboard')){
$html .= '<div style="position:absolute;right:3px;bottom:3px;border-radius: 2px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:1px;font-size:xx-small;color:black">IMDb: '.$movie['imdbRating'].'</div>';
}


$html .= '</div>';
}

$html .= '<div class="page_breadcrumbs_menu" style="position:absolute;top:-40px;right:1px;"><a class="btn-success" style="padding:5px" href="'.Phpfox::getParam('core.path').'movies/top"><span></span>'._p('More Movies').'</a></div>'; 

         return view('@ces_movies/top_block.html', ['content' => $html]);
      });

}

// MOST VIEWED BLOCK  
if (setting('show_viewed')) {

block(2, function() {
$html=""; 

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('num_viewed'))
		 ->where('views != 0')
		 ->order('views DESC')
            ->execute('getRows');

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);

if (!$movies){
$html .= _p('No Movies Found!');
}

foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:1px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 100px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:100px;height:150px;background-color:#dddddd;">';

if (setting('show_tag_dashboard')){
$html .= '<div style="position:absolute;right:3px;bottom:3px;border-radius: 2px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:1px;font-size:xx-small;color:black">Views: '.$movie['views'].'</div>';
}


$html .= '</div>';
}

$html .= '<div class="page_breadcrumbs_menu" style="position:absolute;top:-40px;right:1px;"><a class="btn-success" style="padding:5px" href="'.Phpfox::getParam('core.path').'movies/viewed"><span></span>'._p('More Movies').'</a></div>'; 

         return view('@ces_movies/views_block.html', ['content' => $html]);
      });
}

// MOST REVIEWED BLOCK  
if (setting('show_reviewed')) {

block(2, function() {
$html=""; 

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('num_reviewed'))
		 ->where('votes != 0')
		 ->order('votes DESC')
            ->execute('getRows');

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);

if (!$movies){
$html .= _p('No Movies Found!');
}

foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:1px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 100px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:100px;height:150px;background-color:#dddddd;">';

if (setting('show_tag_dashboard')){
$html .= '<div style="position:absolute;right:3px;bottom:3px;border-radius: 2px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:1px;font-size:xx-small;color:black">Reviews: '.$movie['Votes'].'</div>';
}

$html .= '</div>';
}

$html .= '<div class="page_breadcrumbs_menu" style="position:absolute;top:-40px;right:1px;"><a class="btn-success" style="padding:5px" href="'.Phpfox::getParam('core.path').'movies/reviewed"><span></span>'._p('More Movies').'</a></div>'; 

         return view('@ces_movies/reviewed_block.html', ['content' => $html]);
      });
}

if (setting('show_right')){
// FEATURED MOVIE BLOCK

block(3, function() {
$html="";  

$movie = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies_fav'), 'a')
		 ->join(Phpfox::getT('ces_movies'), 'b', 'a.imdbID = b.imdbID')
		 ->where('a.user_id = 1')
            ->limit(1)
	       ->order('RAND()')
            ->execute('getRow');

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);

if ($movie){
$html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:3px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 100%;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:100%;background-color:#dddddd;">';

if (setting('show_imdb')){
$html .= '<div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:2px;font-size:x-small;color:black">IMDb:'.$movie['imdbRating'].'</div>';
}

if (setting('show_year')){
$html .= '<div style="position:absolute;right:5px;bottom:5px;border-radius: 3px;background-color:'.setting('year_color').';opacity: 0.9;padding:2px;font-size:x-small;color:white">'.$movie['Year'].'</div>';
}

if (setting('show_star')){

$Me = user()->id;
$check_movie = db()->select('*')->from(':ces_movies_fav')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_movie){
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Add to Favorite list').'"><div  id = "star-'.$movie['imdbID'].'" class="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.7;color:white"><i class="fa fa-star fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Remove from Favorite list').'"><div  class="star-'.$movie['imdbID'].'" id="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.9;color:'.setting('star_color').'"><i class="fa fa-star fa-lg"></i></div></a>';
}

$check_watch = db()->select('*')->from(':ces_movies_watch')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_watch){
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Add to Watch list').'"><div  class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.7;color:white"><i class="fa fa-eye fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Remove from Watch list').'"><div   class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.9;color:'.setting('eye_color').'"><i class="fa fa-eye fa-lg"></i></div></a>';
}
}

$html .= '</div></a>';
}else{
$html .= _p('No featured movies!');
}

return view('@ces_movies/featured_block.html', ['content' => $html]);
      });


// LAST REVIEWS

block(3, function() {
$html="";  

$movies = Phpfox::getLib('phpfox.database')
          ->select('*, a.title AS titulo, a.rating AS stars, a.time_stamp AS tempo')
            ->from(Phpfox::getT('ces_movies_reviews'), 'a')
		 ->join(Phpfox::getT('ces_movies'), 'b', 'a.imdbID = b.imdbID')
            ->limit(setting('review_num'))
	       ->order('a.time_stamp DESC')
            ->execute('getRows');

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);

if (!$movies){
$html .= _p('No reviews yet!');
}

foreach ($movies as $movie) {

if ($movie['stars'] == 10){
$rating = '&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;';
}

if ($movie['stars'] == 9){
$rating = '&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2606;';
}

if ($movie['stars'] == 8){
$rating = '&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2606;&#x2606;';
}

if ($movie['stars'] == 7){
$rating = '&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2606;&#x2606;&#x2606;';
}

if ($movie['stars'] == 6){
$rating = '&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2606;&#x2606;&#x2606;&#x2606;';
}

if ($movie['stars'] == 5){
$rating = '&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;&#x2606;&#x2606;&#x2606;&#x2606;&#x2606;';
}

if ($movie['stars'] == 4){
$rating = '&#x2605;&#x2605;&#x2605;&#x2605;&#x2606;&#x2606;&#x2606;&#x2606;&#x2606;&#x2606;';
}

if ($movie['stars'] == 3){
$rating = '&#x2605;&#x2605;&#x2605;&#x2606;&#x2606;&#x2606;&#x2606;&#x2606;&#x2606;&#x2606;';
}

if ($movie['stars'] == 2){
$rating = '&#x2605;&#x2605;&#x2606;&#x2606;&#x2606;&#x2606;&#x2606;&#x2606;&#x2606;&#x2606;';
}

if ($movie['stars'] == 1){
$rating = '&#x2605;&#x2606;&#x2606;&#x2606;&#x2606;&#x2606;&#x2606;&#x2606;&#x2606;&#x2606;';
}

$html .= '<div  style="position:relative;margin:5px;float:left;padding:1px;border:2px;solid black;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #777777;box-shadow: 0px 0px 4px #777777;background-color:#f2f4f6;width: 100%;
"><a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div style="width:100%;height:100px;background-image: url(\''.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg\');background-repeat: no-repeat;   background-position: 0px -20px;background-size: cover;"><div style="background-color:black;width:100%:height:20px;color:white;opacity: 0.7;"><center>'.$movie['Title'].'</center></div></div></a>';
$html .= '<div style="padding:3px"><h3>'.substr($movie['titulo'], 0, 31).'</h3><div style="position:absolute;top:138px"><font size=2>'.$rating.' <p style="line-height: 0.5;"> </font><font size=1>'.moment($movie['tempo']).'</font></p></div><br>'.substr($movie['review'], 0, setting('review_text')).'...<br><br><br><div style="background-color:lightgrey;color:white;width:145px;position:absolute;bottom:1px;left:1px;padding:3.5px;"><font size=2><center>'.(new \Api\User())->get($movie['user'])->name_link.'</center></font></div>';

$html .= '<div class="page_breadcrumbs_menu" style="position:absolute;bottom:1px;right:1px;"><a class="btn-success" style="padding:3px" href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'"><span></span>'._p('Read More').'</a></div>'; 


$html .= '</div></div>';

}

return view('@ces_movies/reviews_block.html', ['content' => $html]);
      });

}

// Load HTML
	$html = "";


      return view('view.html', ['content' => $html]);


   });

// IN THEATERS

route('/theaters', function() {
 auth()->membersOnly();
      // Set the title
      title(_p('In Theaters'));
 
$country_name = Phpfox::getPhraseT(Phpfox::getService('core.country')->getCountry(Phpfox::getUserBy('country_iso')), 'country');
     
 // Set a section title
      section(_p('In').' '.$country_name.' '._p('Theaters'), '/movies/theaters');
 
      // Create a sub menu
	
	$sub_menu = storage()->get('menu');
     Menu('/theaters', $sub_menu->value);


storage()->del('section');
storage()->set('section', 'theaters');



$html ="";

if (auth()->isLoggedIn() && user('share_movie', true)) {

if (setting('share_manual')){
button(_p('Share a Movie'), url('/movies/sharenew'));
}else{
button(_p('Share a Movie'), url('/movies/add'), ['css_class' => 'popup']);
}

}



      // SEARCH BLOCK
    block(1, function() {
$html=""; 
$html .= '<form method="post" action="'.Phpfox::getParam('core.path').'movies/search" >

			<input type="text" id="name" name="name" value="" placeholder="'._p('Write some words to search').'">
		<select name="type" class="dropdown-toggle">
<option value="0" selected>'._p('Title').'</option>
<option value="1">'._p('imdbID').'</option>
<option value="2">'._p('Director').'</option>
<option value="3">'._p('Actor').'</option>
<option value="4">'._p('Writer').'</option>
<option value="5">'._p('Genre').'</option>
</select>
		<input type="submit" value="'._p('Submit').'" class="btn btn-primary">
</form>';
         // Load views/search.html
         return view('@ces_movies/search.html', ['content' => $html]);
      });
  
//CATEGORY BLOCK

block(1, function() {

$html ="";

			$categories = storage()->order('DESC')->all('ces_movies_category');

			if (!$categories) {
			$html = 'No categories!';			
			}



foreach ($categories as $category) {

	$html .= '<a href="'.Phpfox::getParam('core.path').'movies/category?c='.$category->value.'" ><input type="button"  class="button" style="padding:5px;margin:2px" value="'.$category->value.'"></a>';
			}



			return view('@ces_movies/category.html', ['content' => $html]);

		});


// Load HTML
	$html = "";


$country = user()->location['iso'];

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('number_movies'))
		 ->where ('Upcoming LIKE "%'.$country.'%"')
	       ->order('time_stamp DESC')
            ->execute('getRows');

storage()->del('viewmore');
storage()->set('viewmore', 2);

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);



if (!$movies){
$html .= _p('No Movies Found!');
}

foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:3px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 155px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:155px;height:225px;background-color:#dddddd;">';

if (setting('show_imdb')){
$html .= '<div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:2px;font-size:x-small;color:black">IMDb:'.$movie['imdbRating'].'</div>';
}

if (setting('show_year')){
$html .= '<div style="position:absolute;right:5px;bottom:5px;border-radius: 3px;background-color:'.setting('year_color').';opacity: 0.9;padding:2px;font-size:x-small;color:white">'.$movie['Year'].'</div>';
}

if (setting('show_star')){

$Me = user()->id;
$check_movie = db()->select('*')->from(':ces_movies_fav')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_movie){
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Add to Favorite list').'"><div  id = "star-'.$movie['imdbID'].'" class="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.7;color:white"><i class="fa fa-star fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Remove from Favorite list').'"><div  class="star-'.$movie['imdbID'].'" id="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.9;color:'.setting('star_color').'"><i class="fa fa-star fa-lg"></i></div></a>';
}

$check_watch = db()->select('*')->from(':ces_movies_watch')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_watch){
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Add to Watch list').'"><div  class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.7;color:white"><i class="fa fa-eye fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Remove from Watch list').'"><div   class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.9;color:'.setting('eye_color').'"><i class="fa fa-eye fa-lg"></i></div></a>';
}
}

$html .= '</div></a>';

}

$html .= '<div id="viewmore"></div>';

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies'))
		 ->where ('Upcoming LIKE "%'.$country.'%"')
			->execute('getSlaveField');



if ($total > setting('number_movies')){
$html .= '<div class="botao">
<a href="#" data-url="' . url('/viewmore') . '" class="view-more">
<button type="button" class="btn btn-primary" style="width:100%">'._p('VIEW MORE').'</button>
</a></div>
';
}

$html .=   "<script>$('ul li.active').removeClass('active');
    $(\"li:contains('In Theaters')\").addClass('active');
</script>";

      return view('view_more.html', ['content' => $html]);


   });


// LAST MOVIES
route('/last', function() {
 
      // Set the title
      title(_p('Last Movies'));
 
      // Set a section title
      section(_p('Last Movies'), '/movies/last');
 
      // Create a sub menu
	
	$sub_menu = storage()->get('menu');
     subMenu('Last Movies', $sub_menu->value);


storage()->del('section');
storage()->set('section', 'last');


$html ="";

if (auth()->isLoggedIn() && user('share_movie', true)) {

if (setting('share_manual')){
button(_p('Share a Movie'), url('/movies/sharenew'));
}else{
button(_p('Share a Movie'), url('/movies/add'), ['css_class' => 'popup']);
}

}



     


// Load HTML
	$html = "";

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('number_movies'))
	       ->order('time_stamp DESC')
            ->execute('getRows');

storage()->del('viewmore');
storage()->set('viewmore', 2);

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);



foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:3px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 155px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:155px;height:225px;background-color:#dddddd;">';

if (setting('show_imdb')){
$html .= '<div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:2px;font-size:x-small;color:black">IMDb:'.$movie['imdbRating'].'</div>';
}

if (setting('show_year')){
$html .= '<div style="position:absolute;right:5px;bottom:5px;border-radius: 3px;background-color:'.setting('year_color').';opacity: 0.9;padding:2px;font-size:x-small;color:white">'.$movie['Year'].'</div>';
}

if (setting('show_star')){

$Me = user()->id;
$check_movie = db()->select('*')->from(':ces_movies_fav')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_movie){
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Add to Favorite list').'"><div  id = "star-'.$movie['imdbID'].'" class="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.7;color:white"><i class="fa fa-star fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Remove from Favorite list').'"><div  class="star-'.$movie['imdbID'].'" id="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.9;color:'.setting('star_color').'"><i class="fa fa-star fa-lg"></i></div></a>';
}

$check_watch = db()->select('*')->from(':ces_movies_watch')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_watch){
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Add to Watch list').'"><div  class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.7;color:white"><i class="fa fa-eye fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Remove from Watch list').'"><div   class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.9;color:'.setting('eye_color').'"><i class="fa fa-eye fa-lg"></i></div></a>';
}
}

$html .= '</div></a>';

}

$html .= '<div id="viewmore"></div>';

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies'))
			->execute('getSlaveField');

$total = $total -1;

if ($total > setting('number_movies')){
$html .= '<div class="botao">
<a href="#" data-url="' . url('/viewmore') . '" class="view-more">
<button type="button" class="btn btn-primary" style="width:100%">'._p('VIEW MORE').'</button>
</a></div>
';
}
$html .=   "<script>$('ul li.active').removeClass('active');
    $(\"li:contains('Last Movies')\").addClass('active');
</script>";

      return view('view_more.html', ['content' => $html]);


   });

// TOP RATED MOVIES
 Route('/top', function() {

// Set the title
      title(_p('Movie'));
 
      // Set a section title
      section(_p('Top Rated Movies'), '/movies/top');
 
      // Create a sub menu
	
	$sub_menu = storage()->get('menu');
     subMenu('addmovie', $sub_menu->value);


storage()->del('section');
storage()->set('section', 'top');


$html ="";

if (auth()->isLoggedIn() && user('share_movie', true)) {

if (setting('share_manual')){
button(_p('Share a Movie'), url('/movies/sharenew'));
}else{
button(_p('Share a Movie'), url('/movies/add'), ['css_class' => 'popup']);
}

}



      // SEARCH BLOCK
    block(1, function() {
$html=""; 
$html .= '<form method="post" action="'.Phpfox::getParam('core.path').'movies/search" >

			<input type="text" id="name" name="name" value="" placeholder="'._p('Write some words to search').'">
		<select name="type" class="dropdown-toggle">
<option value="0" selected>'._p('Title').'</option>
<option value="1">'._p('imdbID').'</option>
<option value="2">'._p('Director').'</option>
<option value="3">'._p('Actor').'</option>
<option value="4">'._p('Writer').'</option>
<option value="5">'._p('Genre').'</option>
</select>
		<input type="submit" value="'._p('Submit').'" class="btn btn-primary">
</form>';
         // Load views/search.html
         return view('@ces_movies/search.html', ['content' => $html]);
      });
  
//CATEGORY BLOCK

block(1, function() {

$html ="";

			$categories = storage()->order('DESC')->all('ces_movies_category');

			if (!$categories) {
			$html = 'No categories!';			
			}



foreach ($categories as $category) {

	$html .= '<a href="'.Phpfox::getParam('core.path').'movies/category?c='.$category->value.'" ><input type="button"  class="button" style="padding:5px;margin:2px" value="'.$category->value.'"></a>';
			}



			return view('@ces_movies/category.html', ['content' => $html]);

		});


// Load HTML
	$html = "";

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('number_movies'))
	       ->order('imdbRating DESC')
            ->execute('getRows');

storage()->del('viewmore');
storage()->set('viewmore', 2);

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);



foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:3px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 155px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:155px;height:225px;background-color:#dddddd;">';

if (setting('show_imdb')){
$html .= '<div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:2px;font-size:x-small;color:black">IMDb:'.$movie['imdbRating'].'</div>';
}

if (setting('show_year')){
$html .= '<div style="position:absolute;right:5px;bottom:5px;border-radius: 3px;background-color:'.setting('year_color').';opacity: 0.9;padding:2px;font-size:x-small;color:white">'.$movie['Year'].'</div>';
}

if (setting('show_star')){

$Me = user()->id;
$check_movie = db()->select('*')->from(':ces_movies_fav')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_movie){
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Add to Favorite list').'"><div  id = "star-'.$movie['imdbID'].'" class="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.7;color:white"><i class="fa fa-star fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Remove from Favorite list').'"><div  class="star-'.$movie['imdbID'].'" id="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.9;color:'.setting('star_color').'"><i class="fa fa-star fa-lg"></i></div></a>';
}

$check_watch = db()->select('*')->from(':ces_movies_watch')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_watch){
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Add to Watch list').'"><div  class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.7;color:white"><i class="fa fa-eye fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Remove from Watch list').'"><div   class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.9;color:'.setting('eye_color').'"><i class="fa fa-eye fa-lg"></i></div></a>';
}
}

$html .= '</div></a>';

}

$html .= '<div id="viewmore"></div>';

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies'))
			->execute('getSlaveField');

$total = $total -1;

if ($total > setting('number_movies')){
$html .= '<div class="botao">
<a href="#" data-url="' . url('/viewmore') . '" class="view-more">
<button type="button" class="btn btn-primary" style="width:100%">'._p('VIEW MORE').'</button>
</a></div>
';
}
$html .=   "<script>$('ul li.active').removeClass('active');
    $(\"li:contains('Top Rated Movies')\").addClass('active');
</script>";

      return view('view_more.html', ['content' => $html]);

});


// MOST VIEWED MOVIES
 
Route('/viewed', function() {

// Set the title
      title(_p('Movie'));
 
      // Set a section title
      section(_p('Most Viewed Movies'), '/movies/viewed');
 
      // Create a sub menu
	
	$sub_menu = storage()->get('menu');
     subMenu('addmovie', $sub_menu->value);


storage()->del('section');
storage()->set('section', 'viewed');


$html ="";

if (auth()->isLoggedIn() && user('share_movie', true)) {

if (setting('share_manual')){
button(_p('Share a Movie'), url('/movies/sharenew'));
}else{
button(_p('Share a Movie'), url('/movies/add'), ['css_class' => 'popup']);
}

}



      // SEARCH BLOCK
    block(1, function() {
$html=""; 
$html .= '<form method="post" action="'.Phpfox::getParam('core.path').'movies/search" >

			<input type="text" id="name" name="name" value="" placeholder="'._p('Write some words to search').'">
		<select name="type" class="dropdown-toggle">
<option value="0" selected>'._p('Title').'</option>
<option value="1">'._p('imdbID').'</option>
<option value="2">'._p('Director').'</option>
<option value="3">'._p('Actor').'</option>
<option value="4">'._p('Writer').'</option>
<option value="5">'._p('Genre').'</option>
</select>
		<input type="submit" value="'._p('Submit').'" class="btn btn-primary">
</form>';
         // Load views/search.html
         return view('@ces_movies/search.html', ['content' => $html]);
      });
  

//CATEGORY BLOCK

block(1, function() {

$html ="";

			$categories = storage()->order('DESC')->all('ces_movies_category');

			if (!$categories) {
			$html = 'No categories!';			
			}



foreach ($categories as $category) {

	$html .= '<a href="'.Phpfox::getParam('core.path').'movies/category?c='.$category->value.'" ><input type="button"  class="button" style="padding:5px;margin:2px" value="'.$category->value.'"></a>';
			}



			return view('@ces_movies/category.html', ['content' => $html]);

		});

// Load HTML
	$html = "";

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('number_movies'))
		 ->where('views != 0')
	       ->order('views DESC')
            ->execute('getRows');

storage()->del('viewmore');
storage()->set('viewmore', 2);

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);



foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:3px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 155px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:155px;height:225px;background-color:#dddddd;">';

if (setting('show_imdb')){
$html .= '<div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:2px;font-size:x-small;color:black">Views:'.$movie['views'].'</div>';
}

if (setting('show_year')){
$html .= '<div style="position:absolute;right:5px;bottom:5px;border-radius: 3px;background-color:'.setting('year_color').';opacity: 0.9;padding:2px;font-size:x-small;color:white">'.$movie['Year'].'</div>';
}

if (setting('show_star')){

$Me = user()->id;
$check_movie = db()->select('*')->from(':ces_movies_fav')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_movie){
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Add to Favorite list').'"><div  id = "star-'.$movie['imdbID'].'" class="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.7;color:white"><i class="fa fa-star fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Remove from Favorite list').'"><div  class="star-'.$movie['imdbID'].'" id="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.9;color:'.setting('star_color').'"><i class="fa fa-star fa-lg"></i></div></a>';
}

$check_watch = db()->select('*')->from(':ces_movies_watch')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_watch){
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Add to Watch list').'"><div  class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.7;color:white"><i class="fa fa-eye fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Remove from Watch list').'"><div   class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.9;color:'.setting('eye_color').'"><i class="fa fa-eye fa-lg"></i></div></a>';
}
}

$html .= '</div></a>';

}

$html .= '<div id="viewmore"></div>';

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies'))
		 	->where('views != 0')
			->execute('getSlaveField');

$total = $total -1;

if ($total > setting('number_movies')){
$html .= '<div class="botao">
<a href="#" data-url="' . url('/viewmore') . '" class="view-more">
<button type="button" class="btn btn-primary" style="width:100%">'._p('VIEW MORE').'</button>
</a></div>
';
}

$html .=   "<script>$('ul li.active').removeClass('active');
    $(\"li:contains('Most Viewed')\").addClass('active');
</script>";

      return view('view_more.html', ['content' => $html]);

});

// MOST REVIEWED MOVIES

 Route('/reviewed', function() {
// Set the title
      title(_p('Movie'));
 
      // Set a section title
      section(_p('Most Reviewed Movies'), '/movies/reviewed');
 
      // Create a sub menu
	
	$sub_menu = storage()->get('menu');
     subMenu('addmovie', $sub_menu->value);


storage()->del('section');
storage()->set('section', 'reviewed');


$html ="";

if (auth()->isLoggedIn() && user('share_movie', true)) {

if (setting('share_manual')){
button(_p('Share a Movie'), url('/movies/sharenew'));
}else{
button(_p('Share a Movie'), url('/movies/add'), ['css_class' => 'popup']);
}

}



      // SEARCH BLOCK
    block(1, function() {
$html=""; 
$html .= '<form method="post" action="'.Phpfox::getParam('core.path').'movies/search" >

			<input type="text" id="name" name="name" value="" placeholder="'._p('Write some words to search').'">
		<select name="type" class="dropdown-toggle">
<option value="0" selected>'._p('Title').'</option>
<option value="1">'._p('imdbID').'</option>
<option value="2">'._p('Director').'</option>
<option value="3">'._p('Actor').'</option>
<option value="4">'._p('Writer').'</option>
<option value="5">'._p('Genre').'</option>
</select>
		<input type="submit" value="'._p('Submit').'" class="btn btn-primary">
</form>';
         // Load views/search.html
         return view('@ces_movies/search.html', ['content' => $html]);
      });
  
//CATEGORY BLOCK

block(1, function() {

$html ="";

			$categories = storage()->order('DESC')->all('ces_movies_category');

			if (!$categories) {
			$html = 'No categories!';			
			}



foreach ($categories as $category) {

	$html .= '<a href="'.Phpfox::getParam('core.path').'movies/category?c='.$category->value.'" ><input type="button"  class="button" style="padding:5px;margin:2px" value="'.$category->value.'"></a>';
			}



			return view('@ces_movies/category.html', ['content' => $html]);

		});


// Load HTML
	$html = "";

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('number_movies'))
		 ->where('votes != 0')
	       ->order('votes DESC')
            ->execute('getRows');

storage()->del('viewmore');
storage()->set('viewmore', 2);

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);



foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:3px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 155px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:155px;height:225px;background-color:#dddddd;">';

if (setting('show_imdb')){
$html .= '<div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:2px;font-size:x-small;color:black">Reviews: '.$movie['Votes'].'</div>';
}

if (setting('show_year')){
$html .= '<div style="position:absolute;right:5px;bottom:5px;border-radius: 3px;background-color:'.setting('year_color').';opacity: 0.9;padding:2px;font-size:x-small;color:white">'.$movie['Year'].'</div>';
}

if (setting('show_star')){

$Me = user()->id;
$check_movie = db()->select('*')->from(':ces_movies_fav')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_movie){
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Add to Favorite list').'"><div  id = "star-'.$movie['imdbID'].'" class="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.7;color:white"><i class="fa fa-star fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Remove from Favorite list').'"><div  class="star-'.$movie['imdbID'].'" id="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.9;color:'.setting('star_color').'"><i class="fa fa-star fa-lg"></i></div></a>';
}

$check_watch = db()->select('*')->from(':ces_movies_watch')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_watch){
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Add to Watch list').'"><div  class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.7;color:white"><i class="fa fa-eye fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Remove from Watch list').'"><div   class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.9;color:'.setting('eye_color').'"><i class="fa fa-eye fa-lg"></i></div></a>';
}
}

$html .= '</div></a>';

}

$html .= '<div id="viewmore"></div>';

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies'))
		 	->where('votes != 0')
			->execute('getSlaveField');

$total = $total -1;

if ($total > setting('number_movies')){
$html .= '<div class="botao">
<a href="#" data-url="' . url('/viewmore') . '" class="view-more">
<button type="button" class="btn btn-primary" style="width:100%">'._p('VIEW MORE').'</button>
</a></div>
';
}

$html .=  "<script>$('ul li.active').removeClass('active');
    $(\"li:contains('Most Reviewed')\").addClass('active');
</script>";

      return view('view_more.html', ['content' => $html]);

});


// FRIENDS MOVIES

 Route('/friends', function() {
auth()->membersOnly();
// Set the title
      title(_p('Movie'));
 
      // Set a section title
      section(_p('My Friends Movies'), '/movies/friends');
 
      // Create a sub menu
	
	$sub_menu = storage()->get('menu');
     subMenu('addmovie', $sub_menu->value);


storage()->del('section');
storage()->set('section', 'friends');


$html ="";

if (auth()->isLoggedIn() && user('share_movie', true)) {

if (setting('share_manual')){
button(_p('Share a Movie'), url('/movies/sharenew'));
}else{
button(_p('Share a Movie'), url('/movies/add'), ['css_class' => 'popup']);
}

}



      // SEARCH BLOCK
    block(1, function() {
$html=""; 
$html .= '<form method="post" action="'.Phpfox::getParam('core.path').'movies/search" >

			<input type="text" id="name" name="name" value="" placeholder="'._p('Write some words to search').'">
		<select name="type" class="dropdown-toggle">
<option value="0" selected>'._p('Title').'</option>
<option value="1">'._p('imdbID').'</option>
<option value="2">'._p('Director').'</option>
<option value="3">'._p('Actor').'</option>
<option value="4">'._p('Writer').'</option>
<option value="5">'._p('Genre').'</option>
</select>
		<input type="submit" value="'._p('Submit').'" class="btn btn-primary">
</form>';
         // Load views/search.html
         return view('@ces_movies/search.html', ['content' => $html]);
      });
  
//CATEGORY BLOCK

block(1, function() {

$html ="";

			$categories = storage()->order('DESC')->all('ces_movies_category');

			if (!$categories) {
			$html = 'No categories!';			
			}



foreach ($categories as $category) {

	$html .= '<a href="'.Phpfox::getParam('core.path').'movies/category?c='.$category->value.'" ><input type="button"  class="button" style="padding:5px;margin:2px" value="'.$category->value.'"></a>';
			}



			return view('@ces_movies/category.html', ['content' => $html]);

		});


// Load HTML
	$html = "";
	$Me = user()->id;

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'), 'a')
		 ->join(Phpfox::getT('friend'), 'c', 'c.user_id = "'.$Me.'" and c.friend_user_id = a.user')
            ->limit(setting('number_movies'))
	       ->order('a.time_stamp DESC')
            ->execute('getRows');

storage()->del('viewmore');
storage()->set('viewmore', 2);

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);



foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:3px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 155px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:155px;height:225px;background-color:#dddddd;">';

if (setting('show_imdb')){
$html .= '<div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:2px;font-size:x-small;color:black">'.(new \Api\User())->get($movie['User'])->name.'</div>';
}

if (setting('show_year')){
$html .= '<div style="position:absolute;right:5px;bottom:5px;border-radius: 3px;background-color:'.setting('year_color').';opacity: 0.9;padding:2px;font-size:x-small;color:white">'.$movie['Year'].'</div>';
}

if (setting('show_star')){

$Me = user()->id;
$check_movie = db()->select('*')->from(':ces_movies_fav')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_movie){
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Add to Favorite list').'"><div  id = "star-'.$movie['imdbID'].'" class="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.7;color:white"><i class="fa fa-star fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Remove from Favorite list').'"><div  class="star-'.$movie['imdbID'].'" id="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.9;color:'.setting('star_color').'"><i class="fa fa-star fa-lg"></i></div></a>';
}

$check_watch = db()->select('*')->from(':ces_movies_watch')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_watch){
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Add to Watch list').'"><div  class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.7;color:white"><i class="fa fa-eye fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Remove from Watch list').'"><div   class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.9;color:'.setting('eye_color').'"><i class="fa fa-eye fa-lg"></i></div></a>';
}
}

$html .= '</div></a>';

}

$html .= '<div id="viewmore"></div>';

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies'), 'a')
		 	->join(Phpfox::getT('friend'), 'c', 'c.user_id = "'.$Me.'" and c.friend_user_id = a.user')
			->execute('getSlaveField');

$total = $total -1;

if ($total > setting('number_movies')){
$html .= '<div class="botao">
<a href="#" data-url="' . url('/viewmore') . '" class="view-more">
<button type="button" class="btn btn-primary" style="width:100%">'._p('VIEW MORE').'</button>
</a></div>
';
}

$html .=   "<script>$('ul li.active').removeClass('active');
    $(\"li:contains('My Friends Movies')\").addClass('active');
</script>";

      return view('view_more.html', ['content' => $html]);

});


// MY MOVIES

 Route('/mymovies', function() {
auth()->membersOnly();
// Set the title
      title(_p('Movie'));
 
      // Set a section title
      section(_p('My Movies'), '/movies/mymovies');
 
      // Create a sub menu
	
	$sub_menu = storage()->get('menu');
     subMenu('addmovie', $sub_menu->value);


storage()->del('section');
storage()->set('section', 'mymovies');


$html ="";

if (auth()->isLoggedIn() && user('share_movie', true)) {

if (setting('share_manual')){
button(_p('Share a Movie'), url('/movies/sharenew'));
}else{
button(_p('Share a Movie'), url('/movies/add'), ['css_class' => 'popup']);
}

}



      // SEARCH BLOCK
    block(1, function() {
$html=""; 
$html .= '<form method="post" action="'.Phpfox::getParam('core.path').'movies/search" >

			<input type="text" id="name" name="name" value="" placeholder="'._p('Write some words to search').'">
		<select name="type" class="dropdown-toggle">
<option value="0" selected>'._p('Title').'</option>
<option value="1">'._p('imdbID').'</option>
<option value="2">'._p('Director').'</option>
<option value="3">'._p('Actor').'</option>
<option value="4">'._p('Writer').'</option>
<option value="5">'._p('Genre').'</option>
</select>
		<input type="submit" value="'._p('Submit').'" class="btn btn-primary">
</form>';
         // Load views/search.html
         return view('@ces_movies/search.html', ['content' => $html]);
      });
  
//CATEGORY BLOCK

block(1, function() {

$html ="";

			$categories = storage()->order('DESC')->all('ces_movies_category');

			if (!$categories) {
			$html = 'No categories!';			
			}



foreach ($categories as $category) {

	$html .= '<a href="'.Phpfox::getParam('core.path').'movies/category?c='.$category->value.'" ><input type="button"  class="button" style="padding:5px;margin:2px" value="'.$category->value.'"></a>';
			}



			return view('@ces_movies/category.html', ['content' => $html]);

		});


// Load HTML
	$html = "";
	$Me = user()->id;

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('number_movies'))
            ->where('User = '.$Me)
	       ->order('time_stamp DESC')
            ->execute('getRows');

storage()->del('viewmore');
storage()->set('viewmore', 2);

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);



foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:3px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 155px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:155px;height:225px;background-color:#dddddd;">';

if (setting('show_imdb')){
$html .= '<div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:2px;font-size:x-small;color:black">IMDb:'.$movie['imdbRating'].'</div>';
}

if (setting('show_year')){
$html .= '<div style="position:absolute;right:5px;bottom:5px;border-radius: 3px;background-color:'.setting('year_color').';opacity: 0.9;padding:2px;font-size:x-small;color:white">'.$movie['Year'].'</div>';
}

if (setting('show_star')){

$Me = user()->id;
$check_movie = db()->select('*')->from(':ces_movies_fav')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_movie){
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Add to Favorite list').'"><div  id = "star-'.$movie['imdbID'].'" class="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.7;color:white"><i class="fa fa-star fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Remove from Favorite list').'"><div  class="star-'.$movie['imdbID'].'" id="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.9;color:'.setting('star_color').'"><i class="fa fa-star fa-lg"></i></div></a>';
}

$check_watch = db()->select('*')->from(':ces_movies_watch')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_watch){
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Add to Watch list').'"><div  class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.7;color:white"><i class="fa fa-eye fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Remove from Watch list').'"><div   class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.9;color:'.setting('eye_color').'"><i class="fa fa-eye fa-lg"></i></div></a>';
}
}

$html .= '</div></a>';

}

$html .= '<div id="viewmore"></div>';

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies'))
		 	->where('User = '.$Me)
			->execute('getSlaveField');

$total = $total -1;

if ($total > setting('number_movies')){
$html .= '<div class="botao">
<a href="#" data-url="' . url('/viewmore') . '" class="view-more">
<button type="button" class="btn btn-primary" style="width:100%">'._p('VIEW MORE').'</button>
</a></div>
';
}

$html .=   "<script>$('ul li.active').removeClass('active');
    $(\"li:contains('My Movies')\").addClass('active');
</script>";

      return view('view_more.html', ['content' => $html]);

});

// FAVORITE LIST

 Route('/favorite', function() {

auth()->membersOnly();

// Set the title
      title(_p('Movies') );
 
      // Set a section title
      section(_p('My Favorite List') , '/movies/favorite');
 
      // Create a sub menu
	$sub_menu = storage()->get('menu');
     subMenu('friends', $sub_menu->value);
 

if (auth()->isLoggedIn() && user('share_movie', true)) {

      // Create an action button
button(_p('Share a Movie') , url('/movies/add'), ['css_class' => 'popup']);
}
 
    


	// Load HTML
	$html = "";
$Me = user()->id;

$movies = Phpfox::getLib('phpfox.database')
          ->select('*, a.time_stamp AS tempo')
            ->from(Phpfox::getT('ces_movies_fav'), 'a')
		->join(Phpfox::getT('ces_movies'), 'b', 'a.imdbID = b.imdbID')
		->where('a.user_id ='.$Me)
            ->limit(setting('number_movies'))
	       ->order('a.time_stamp DESC')
            ->execute('getRows');

storage()->del('viewmore');
storage()->set('viewmore', 2);

storage()->del('section');
storage()->set('section', 'favorites');


$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);


foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:3px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 155px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:155px;height:225px;background-color:#dddddd;"><div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:#dfa800;opacity: 0.9;padding:2px;font-size:x-small;color:black">'._p('Added').': '.moment()->toString($movie['tempo']).'</div>';



if (setting('show_star')){

$Me = user()->id;
$check_movie = db()->select('*')->from(':ces_movies_fav')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_movie){
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Add to Favorite list').'"><div  id = "star-'.$movie['imdbID'].'" class="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.7;color:white"><i class="fa fa-star fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Remove from Favorite list').'"><div  class="star-'.$movie['imdbID'].'" id="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.9;color:'.setting('star_color').'"><i class="fa fa-star fa-lg"></i></div></a>';
}

$check_watch = db()->select('*')->from(':ces_movies_watch')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_watch){
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Add to Watch list').'"><div  class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.7;color:white"><i class="fa fa-eye fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Remove from Watch list').'"><div   class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.9;color:'.setting('eye_color').'"><i class="fa fa-eye fa-lg"></i></div></a>';
}
}

$html .= '</div></a>';

}

$html .= '<div id="viewmore"></div>';

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies_fav'))
			->where('user_id ='.$Me)
			->execute('getSlaveField');

$total = $total -1;

if ($total > setting('number_movies')){
$html .= '<div class="botao">
<a href="#" data-url="' . url('/viewmore') . '" class="view-more">
<button type="button" class="btn btn-primary" style="width:100%">'._p('VIEW MORE').'</button>
</a></div>
';
}

$html .=   "<script>$('ul li.active').removeClass('active');
    $(\"li:contains('My Favorite List')\").addClass('active');
</script>";

      return view('view_more.html', ['content' => $html]);


   });


// WATCH LIST

 Route('/watchlist', function() {
auth()->membersOnly();
// Set the title
      title(_p('Movies') );
 
      // Set a section title
      section(_p('My Watch List') , '/movies/watchlist');
 
      // Create a sub menu
	$sub_menu = storage()->get('menu');
     subMenu('friends', $sub_menu->value);
 

if (auth()->isLoggedIn() && user('share_movie', true)) {

      // Create an action button
button(_p('Share a Movie') , url('/movies/add'), ['css_class' => 'popup']);
}
 
     


	// Load HTML
	$html = "";
$Me = user()->id;

$movies = Phpfox::getLib('phpfox.database')
          ->select('*, a.time_stamp AS tempo')
            ->from(Phpfox::getT('ces_movies_watch'), 'a')
		->join(Phpfox::getT('ces_movies'), 'b', 'a.imdbID = b.imdbID')
		->where('a.user_id ='.$Me)
            ->limit(setting('number_movies'))
	       ->order('a.time_stamp DESC')
            ->execute('getRows');

storage()->del('viewmore');
storage()->set('viewmore', 2);

storage()->del('section');
storage()->set('section', 'watchlist');


$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);


foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:3px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 155px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:155px;height:225px;background-color:#dddddd;"><div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:#dfa800;opacity: 0.9;padding:2px;font-size:x-small;color:black">'._p('Added').': '.moment()->toString($movie['tempo']).'</div>';



if (setting('show_star')){

$Me = user()->id;
$check_movie = db()->select('*')->from(':ces_movies_fav')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_movie){
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Add to Favorite list').'"><div  id = "star-'.$movie['imdbID'].'" class="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.7;color:white"><i class="fa fa-star fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Remove from Favorite list').'"><div  class="star-'.$movie['imdbID'].'" id="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.9;color:'.setting('star_color').'"><i class="fa fa-star fa-lg"></i></div></a>';
}

$check_watch = db()->select('*')->from(':ces_movies_watch')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_watch){
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Add to Watch list').'"><div  class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.7;color:white"><i class="fa fa-eye fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Remove from Watch list').'"><div   class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.9;color:'.setting('eye_color').'"><i class="fa fa-eye fa-lg"></i></div></a>';
}
}

$html .= '</div></a>';

}

$html .= '<div id="viewmore"></div>';

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies_watch'))
			->where('user_id ='.$Me)
			->execute('getSlaveField');

$total = $total -1;


if ($total > setting('number_movies')){
$html .= '<div class="botao">
<a href="#" data-url="' . url('/viewmore') . '" class="view-more">
<button type="button" class="btn btn-primary" style="width:100%">'._p('VIEW MORE').'</button>
</a></div>
';
}

$html .=  "<script>$('ul li.active').removeClass('active');
    $(\"li:contains('My Watch List')\").addClass('active');
</script>";

      return view('view_more.html', ['content' => $html]);


   });

// CATEGORIES
route('/category', function() {

	$cat = request()->get('c');

 
      // Set the title
      title(_p('Category'));
 
      // Set a section title
      section(_p('Category: ').$cat, '/movies/category');
 
      // Create a sub menu
	
	$sub_menu = storage()->get('menu');
     subMenu('Last Movies', $sub_menu->value);


storage()->del('section');
storage()->set('section', 'cat');


$html ="";

if (auth()->isLoggedIn() && user('share_movie', true)) {

if (setting('share_manual')){
button(_p('Share a Movie'), url('/movies/sharenew'));
}else{
button(_p('Share a Movie'), url('/movies/add'), ['css_class' => 'popup']);
}

}



      // SEARCH BLOCK
    block(1, function() {
$html=""; 
$html .= '<form method="post" action="'.Phpfox::getParam('core.path').'movies/search" >

			<input type="text" id="name" name="name" value="" placeholder="'._p('Write some words to search').'">
		<select name="type" class="dropdown-toggle">
<option value="0" selected>'._p('Title').'</option>
<option value="1">'._p('imdbID').'</option>
<option value="2">'._p('Director').'</option>
<option value="3">'._p('Actor').'</option>
<option value="4">'._p('Writer').'</option>
<option value="5">'._p('Genre').'</option>
</select>
		<input type="submit" value="'._p('Submit').'" class="btn btn-primary">
</form>';
         // Load views/search.html
         return view('@ces_movies/search.html', ['content' => $html]);
      });
  

//CATEGORY BLOCK

block(1, function() {

$html ="";

			$categories = storage()->order('DESC')->all('ces_movies_category');

			if (!$categories) {
			$html = 'No categories!';			
			}



foreach ($categories as $category) {

	$html .= '<a href="'.Phpfox::getParam('core.path').'movies/category?c='.$category->value.'" ><input type="button"  class="button" style="padding:5px;margin:2px" value="'.$category->value.'"></a>';
			}



			return view('@ces_movies/category.html', ['content' => $html]);

		});

// Load HTML
	$html = "";

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('number_movies'))
		 ->where('genre LIKE "%'.$cat.'%"')
	       ->order('time_stamp DESC')
            ->execute('getRows');

storage()->del('viewmore');
storage()->set('viewmore', 2);

storage()->del('cat');
storage()->set('cat', $cat);

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);



foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:3px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 155px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:155px;height:225px;background-color:#dddddd;">';

if (setting('show_imdb')){
$html .= '<div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:2px;font-size:x-small;color:black">IMDb:'.$movie['imdbRating'].'</div>';
}

if (setting('show_year')){
$html .= '<div style="position:absolute;right:5px;bottom:5px;border-radius: 3px;background-color:'.setting('year_color').';opacity: 0.9;padding:2px;font-size:x-small;color:white">'.$movie['Year'].'</div>';
}

if (setting('show_star')){

$Me = user()->id;
$check_movie = db()->select('*')->from(':ces_movies_fav')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_movie){
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Add to Favorite list').'"><div  id = "star-'.$movie['imdbID'].'" class="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.7;color:white"><i class="fa fa-star fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Remove from Favorite list').'"><div  class="star-'.$movie['imdbID'].'" id="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.9;color:'.setting('star_color').'"><i class="fa fa-star fa-lg"></i></div></a>';
}

$check_watch = db()->select('*')->from(':ces_movies_watch')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_watch){
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Add to Watch list').'"><div  class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.7;color:white"><i class="fa fa-eye fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Remove from Watch list').'"><div   class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.9;color:'.setting('eye_color').'"><i class="fa fa-eye fa-lg"></i></div></a>';
}
}

$html .= '</div></a>';

}

$html .= '<div id="viewmore"></div>';

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies'))
		     ->where('genre LIKE "%'.$cat.'%"')
			->execute('getSlaveField');

$total = $total -1;

if ($total > setting('number_movies')){
$html .= '<div class="botao">
<a href="#" data-url="' . url('/viewmore') . '" class="view-more">
<button type="button" class="btn btn-primary" style="width:100%">'._p('VIEW MORE').'</button>
</a></div>
';
}
$html .=   "<script>$('ul li.active').removeClass('active');
    $(\"li:contains('Last Movies')\").addClass('active');
</script>";

      return view('view_more.html', ['content' => $html]);


   });


Route('/sharenew', function() {
		$html="";
		title(_p('Share a Movie'));
		section(_p('Share a Movie'), url('/sharenew'));

      // Create a sub menu
	$sub_menu = storage()->get('menu');
     subMenu('view', $sub_menu->value);

if (auth()->isLoggedIn() && user('share_movie', true)) {

if (setting('share_manual')){
button(_p('Share a Movie'), url('/movies/sharenew'));
}else{
button(_p('Share a Movie'), url('/movies/add'), ['css_class' => 'popup']);
}

}



      // Place a block
    block(1, function() {
$html=""; 
$html .= '<form method="post" action="'.Phpfox::getParam('core.path').'movies/search" >

			<input type="text" id="name" name="name" value="" placeholder="'._p('Write some words to search').'">
		<select name="type" class="dropdown-toggle">
<option value="0" selected>'._p('Title').'</option>
<option value="1">'._p('imdbID').'</option>
<option value="2">'._p('Director').'</option>
<option value="3">'._p('Actor').'</option>
<option value="4">'._p('Writer').'</option>
<option value="5">'._p('Genre').'</option>
</select>
		<input type="submit" value="'._p('Submit').'" class="btn btn-primary">
</form>';
         // Load views/search.html
         return view('@ces_movies/search.html', ['content' => $html]);
      });

$title = '';
$imdbID = '';
$director = ''; 
$date = '';
$year = '';
$runtime = ''; 
$genre = '';
$actors = '';
$writer = '';
$rated = '';
$rating = '';
$votes = '';
$plot = '';
$language = '';
$country = '';
$poster = '';
$embed = '';
$trailers ='';
$count = 0;
$awards="";

if (isset($_POST['fetch']) == "ok"){

$url = "";
//url to imdb page
$url = $_POST['imdbURL'];
//get the page content
$html = file_get_contents($url);



$pattern = '/<title>(.*?)<\/title>/ms'; 
preg_match($pattern, $html, $match); 
$title = strip_tags($match[1]);
$title = str_replace("- IMDb","",$title);


$pattern = '/<meta property="pageId" content="(.*?)" \/>/ms'; 
preg_match($pattern, $html, $match); 
$imdbID = strip_tags($match[1]);


$pattern = '/<h4 class="inline">Directors:<\/h4>(.*?)<\/div>/ms'; 
$count = preg_match($pattern, $html, $match); 
if ($count == 0){
$pattern = '/<h4 class="inline">Director:<\/h4>(.*?)<\/div>/ms'; 
preg_match($pattern, $html, $match); 
}

$director = strip_tags($match[1]);
$director = str_replace("            ","",$director);
$director = str_replace("    ","",$director);

$pattern = '/<meta itemprop="datePublished" content="(.*?)"/ms'; 
preg_match($pattern, $html, $match); 
$date = $match[1];

$year = substr($date, 0, 4);


$html = preg_replace('/datetime="[^>]+\"/i', '', $html); 

$pattern = '/<h3 class="subheading">Technical Specs<\/h3>(.*?)<\/div>/ms';

preg_match($pattern, $html, $match1);

$pattern = '/<time itemprop="duration" >(.*?)</ms'; 
preg_match($pattern, $match1[1], $match); 
$runtime = $match[1];

$pattern = '/<span class="itemprop" itemprop="genre">(.*?)<\/span>/ms'; 
preg_match_all($pattern, $html, $match); 
$genre = strip_tags($match[0][0]).', '.strip_tags($match[0][1]).', '.strip_tags($match[0][2]);


$pattern = '/<h4 class="inline">Stars:<\/h4>(.*?)<\/div>/ms';
preg_match($pattern, $html, $match1);

$pattern = '/<span class="itemprop" itemprop="name">(.*?)<\/span>/ms'; 
preg_match_all($pattern, $match1[1], $match); 
$actors = strip_tags($match[0][0]).', '.strip_tags($match[0][1]).', '.strip_tags($match[0][2]);

$pattern = '/<h4 class="inline">Writers:<\/h4>(.*?)<\/div>/ms';
$count = preg_match($pattern, $html, $match1);
if ($count == 0){
$pattern = '/<h4 class="inline">Writer:<\/h4>(.*?)<\/div>/ms';
preg_match($pattern, $html, $match1);

}

$pattern = '/<span class="itemprop" itemprop="name">(.*?)</ms'; 
preg_match($pattern, $match1[1], $match); 
$writer = $match[1];

$pattern = '/<meta itemprop="contentRating" content="(.*?)">/ms'; 
preg_match($pattern, $html, $match); 
$rated = $match[1];

$pattern = '/<span itemprop="ratingValue">(.*?)</ms'; 
preg_match($pattern, $html, $match); 
$rating = $match[1];

$pattern = '/itemprop="ratingCount">(.*?)</ms'; 
preg_match($pattern, $html, $match); 
$votes = $match[1];


$pattern = '/<div class="inline canwrap" itemprop="description">
            <p>(.*?)<\/p>/ms'; 
preg_match($pattern, $html, $match); 
$plot = strip_tags($match[1]);
$plot = str_replace('"','\'',$plot);

$pattern = '/<h4 class="inline">Language:<\/h4>(.*?)<\/div>/ms'; 
preg_match($pattern, $html, $match); 
$language = strip_tags($match[1]);
$language = str_replace("    ","",$language);


$pattern = '/<h4 class="inline">Country:<\/h4>(.*?)<\/div>/ms'; 
preg_match($pattern, $html, $match); 
$country = strip_tags($match[1]);
$country = str_replace("    ","",$country);

$pattern = '/itemprop="awards">(.*?)<\/span>/ms'; 
preg_match($pattern, $html, $match); 
$awards = strip_tags($match[1]);
$awards = str_replace("        "," ",$awards);

$pattern = '/<div class="poster">(.*?)itemprop="image"/ms'; 
preg_match($pattern, $html, $match1); 

$pattern = '/src="(.*?)"/ms'; 
$count = preg_match($pattern, $match1[1], $match); 
$poster = $match[1];
$poster = str_replace("http://","",$poster);
$poster = str_replace("https://","",$poster);


if ($count == 0){
$pattern = '/<div class="image">(.*?)<div class="pro-title-link text-center">/ms'; 
preg_match($pattern, $html, $match1); 

$pattern = '/src="(.*?)"/ms'; 
$count = preg_match($pattern, $match1[1], $match); 
$poster = $match[1];
$poster = str_replace("http://","",$poster);
$poster = str_replace("https://","",$poster);

}

$trailer_url = 'https://www.googleapis.com/youtube/v3/search?part=id,snippet&q='.$title.'%20'.$director.'%20offical%20trailer%20movie&key=AIzaSyCwNJ28JWwlX6Q3D-7AanWZvd5N_VWpuzw&maxResults=1&type=video';
$trailer_url = preg_replace('/\s+/', '', $trailer_url);


$trailers = file_get_contents($trailer_url);

$trailers = json_decode($trailers, true);

$videoId="";

foreach ($trailers['items'] as $trailer) {
        $videoId  = $trailer['id']['videoId'];  
    }

   $embed = '<iframe width="640" height="360" src="https://www.youtube.com/embed/'.$videoId.'" frameborder="0" allowfullscreen></iframe>';

}

if (setting('translate_content')){

$lang = strtoupper(setting('translate_language'));

$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=EN&tl=".urlencode($lang)."&dt=t&q=".urlencode($genre);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
if($response !== false){
      preg_match('/\[\[\[\"(.*?)\"/', $response, $matches);
      $genre = $matches[1];
}

$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=EN&tl=".urlencode($lang)."&dt=t&q=".urlencode($plot);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
if($response !== false){
      preg_match('/\[\[\[\"(.*?)\"/', $response, $matches);
      $plot = $matches[1];
}

$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=EN&tl=".urlencode($lang)."&dt=t&q=".urlencode($language);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
if($response !== false){
      preg_match('/\[\[\[\"(.*?)\"/', $response, $matches);
      $language = $matches[1];
}

$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=EN&tl=".urlencode($lang)."&dt=t&q=".urlencode($country);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
if($response !== false){
      preg_match('/\[\[\[\"(.*?)\"/', $response, $matches);
      $country = $matches[1];
}

$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=EN&tl=".urlencode($lang)."&dt=t&q=".urlencode($awards);
echo $awards;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

curl_close($ch);
if($response !== false){
      preg_match('/\[\[\[\"(.*?)\"/', $response, $matches);
      $awards = $matches[1];
}


}

$html1 = '
<h3>'._p('Fetch the movie information from IMDb url').'</h3>
<form method="post" id="1" action="'.Phpfox::getParam('core.path').'movies/sharenew" >

<input type="hidden" name="fetch" value="ok" />
<font size=2>'._p('To fill the form with information from the movies page on IMDb, just go <a href="http://www.imdb.com" target=_new>HERE</a> and search for the movie. Then past the url here and Fetch.').'</font>	
<input type="text" name="imdbURL" value="" >
	
		<input type="submit" value="'._p('Fetch').'" class="btn btn-primary">
</form>

';

if (isset($_POST['form']) == "ok"){

$Me = user()->id;
$path = Phpfox::getParam('core.path');
$imdb = $_POST['imdbID'];
$imdb = str_replace(" ","",$imdb);


$check_movie = db()->select('*')->from(':ces_movies')->where(['imdbID' => $imdb])->get();

if ($check_movie){
$html1 = '<div class="error_message" role="error">'._p('This movie is already in our system. You can see it ').'<a href="'.$path.'movies/view?m='.$_POST['imdbID'].'">'._p('HERE').'</a></div>';
}else{


if ($_POST['imdbID'] != "" && $_POST['title'] != "" && $_POST['director'] != "" && $_POST['writer'] != "" && $_POST['actors'] != "" && $_POST['plot'] != "" && $_POST['year'] != "" && $_POST['rating'] != "" && $_POST['poster'] != "" && $_POST['genre'] != "") {



if (preg_match("/tt\\d{7}/", $_POST['imdbID']) == 0) {
$html1 = '<div class="error_message" role="error">'._p('The IMDB code is not a valide ID: ').$_POST['imdbID'].'</div>';
}else{
		db()->insert(':ces_movies', ['imdbID' => $imdb, 'Title' => $_POST['title'], 'Year' => $_POST['year'], 'User' => user()->id, 'Runtime' => $_POST['runtime'], 'Genre' => $_POST['genre'], 'Released' => $_POST['date'], 'Director' => $_POST['director'], 'Writer' => $_POST['writer'], 'Actors' => $_POST['actors'], 'Rated' => $_POST['rated'], 'imdbRating' => $_POST['rating'], 'imdbVotes' => $_POST['votes'], 'Embed' => $_POST['embed'], 'Plot' => $_POST['plot'], 'Language' => $_POST['language'], 'Country' => $_POST['country'], 'Awards' => $_POST['awards'], 'time_stamp' => time()]);

$image="";
$image = 'https://'.$_POST['poster'];
$internal="";
$internal = str_replace("index.php","",$_SERVER['SCRIPT_FILENAME']); 

$ch = curl_init($image);
$fp = fopen($internal.'PF.Base/file/movies/posters/'.$imdb.'.jpg', 'wb');
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);

//ADD TO FEED

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);

$check = 0;

if ($_POST['embed'] == ""){
$embed = '<img src="'.$path.'PF.Site/Apps/ces_movies/no_trailer.jpg">';
$check = 1;
}else{
$embed = str_replace("640","100%",$_POST['embed']);
$embed = str_replace("360","170",$embed);
}

$html .= '<div style="position:relative;width:100%;max-width:500px;height:300px;background-color:#f2f4f6;border: 1px lightgrey solid;margin:11px;padding:7px;-moz-box-shadow: 0px 0px 4px #aaaaaa;-webkit-box-shadow: 0px 0px 4px #aaaaaa;box-shadow: 0px 0px 4px #aaaaaa;"><table><tr><td valign=top width=40%><img src="'.$path.'PF.Base/file/movies/posters/'.$imdb.'.jpg" width=100%></td><td valign="top" width=60% height=200>'.$embed.'<br> <font size=1><div style="text-align:center;width:60%;position:absolute;top:180px">'.$_POST['rated'].' | '.$_POST['runtime'].' | '.$_POST['genre'].' | '.$_POST['released'].'<table width=100%><tr><td width=50%><b>'._p('Actors').': <br></b>'.$_POST['actors'].'</td><br><br><td width=50% valign="top"><b>'._p('Director').':<br></b>'.$_POST['director'].'</td></tr></table></div>';

$html .= '<div class="page_breadcrumbs_menu" style="position:absolute;bottom:-26px;right:0px;"><a class="btn btn-success" style="padding:2px" href="'.Phpfox::getParam('core.path').'movies/view?m='.$imdb.'"><span></span>'._p('VIEW DETAILS').'</a></div>'; 



$html .= '</table></tr></td></div>';

$html = str_replace('"','\"',$html);
$html = str_replace("/","\/",$html);
$feed = '{"title":"'._p('Added a new Movie: ').$_POST['title'].'","text":"'.$html.'"}';

$imdb1 = str_replace("tt","",$imdb);


url()->send('/movies/view?m='.$imdb);

}

}else{
$html1 .= '<div class="error_message" role="error">'._p('This fields are mandatory:  imdbID, title, director, writer, actors, plot, year, IMDb rating, poster and genre').'</div>';

$title = $_POST['title'];
$imdbID = $_POST['imdbID'];
$director = $_POST['director']; 
$date = $_POST['date'];
$year = $_POST['year'];
$runtime = $_POST['runtime']; 
$genre = $_POST['genre'];
$actors = $_POST['actors'];
$writer = $_POST['writer'];
$rated = $_POST['rated'];
$rating = $_POST['rating'];
$votes = $_POST['votes'];
$plot = $_POST['plot'];
$language = $_POST['language'];
$country = $_POST['country'];
$poster = $_POST['poster'];
$embed = $_POST['embed'];
$awards = $_POST['awards'];


}
}
}

$html1 .= '
<br><br><h3>'._p('Fill the form with movies information').'</h3>
<form method="post" id="2" action="'.Phpfox::getParam('core.path').'movies/sharenew" >

<input type="hidden" name="form" value="ok" />

IMDb ID:
<input type="text" name="imdbID" value="'.$imdbID.'" >
<br>'._p('Title').':
<input type="text" name="title" value="'.$title.'" >
<br>'._p('Director').':
<input type="text" name="director" value="'.$director.'" >
<br>'._p('Writer').':
<input type="text" name="writer" value="'.$writer.'" >
<br>'._p('Actors').':
<input type="text" name="actors" value="'.$actors.'" >
<br>'._p('Genre').':
<input type="text" name="genre" value="'.$genre.'" >
<br>'._p('Plot').':
<input type="text" name="plot" value="'.$plot.'" >
<br>'._p('Year').':
<input type="text" name="year" value="'.$year.'" >
<br>'._p('Released Date').':
<input type="text" name="date" value="'.$date.'" >
<br>'._p('Run Time').':
<input type="text" name="runtime" value="'.$runtime.'" >
<br>'._p('Rated').':
<input type="text" name="rated" value="'.$rated.'" >
<br>'._p('IMDb Rating').':
<input type="text" name="rating" value="'.$rating.'" >
<br>'._p('Votes').':
<input type="text" name="votes" value="'.$votes.'" >
<br>'._p('Language').':
<input type="text" name="language" value="'.$language.'" >
<br>'._p('Country').':
<input type="text" name="country" value="'.$country.'" >
<br>'._p('Awards').':
<input type="text" name="awards" value="'.$awards.'" >
<br>'._p('Poster url').':
<input type="text" name="poster" value="'.$poster.'" ><font size=1>'._p('Remove the http:// or https:// from the url').'</font>
<br>'._p('Trailer embed code').':
<input type="text" name="embed" value=\''.$embed.'\' ><br>

		
		<input type="submit" value="'._p('Submit').'" class="btn btn-primary">
</form>

';









return view('view.html', ['content' => $html1]);


});




Route('/edit', function() {
		$html="";
		title(_p('Edit Movie'));
		section(_p('Edit Movie'), url('/sharenew'));

      // Create a sub menu
	$sub_menu = storage()->get('menu');
     subMenu('view', $sub_menu->value);

$imdb = request()->get('m');

if (auth()->isLoggedIn() && user('share_movie', true)) {

if (setting('share_manual')){
button(_p('Share a Movie'), url('/movies/sharenew'));
}else{
button(_p('Share a Movie'), url('/movies/add'), ['css_class' => 'popup']);
}

}



      // Place a block
    block(1, function() {
$html=""; 
$html .= '<form method="post" action="'.Phpfox::getParam('core.path').'movies/search" >

			<input type="text" id="name" name="name" value="" placeholder="'._p('Write some words to search').'">
		<select name="type" class="dropdown-toggle">
<option value="0" selected>'._p('Title').'</option>
<option value="1">'._p('imdbID').'</option>
<option value="2">'._p('Director').'</option>
<option value="3">'._p('Actor').'</option>
<option value="4">'._p('Writer').'</option>
<option value="5">'._p('Genre').'</option>
</select>
		<input type="submit" value="'._p('Submit').'" class="btn btn-primary">
</form>';
         // Load views/search.html
         return view('@ces_movies/search.html', ['content' => $html]);
      });

$title = '';
$imdbID = '';
$director = ''; 
$date = '';
$year = '';
$runtime = ''; 
$genre = '';
$actors = '';
$writer = '';
$rated = '';
$rating = '';
$votes = '';
$plot = '';
$language = '';
$country = '';
$poster = '';
$embed = '';
$trailers ='';
$awards='';
$count = 0;

$movie = db()->select('*')->from(':ces_movies')->where(['imdbID' => $imdb ])->get();

$title = $movie['Title'];
$imdbID = $movie['imdbID'];
$director = $movie['Director']; 
$date = $movie['Released'];
$year = $movie['Year'];
$runtime = $movie['Runtime']; 
$genre = $movie['Genre'];
$actors = $movie['Actors'];
$writer = $movie['Writer'];
$rated = $movie['Rated'];
$rating = $movie['imdbRating'];
$votes = $movie['imdbVotes'];
$plot = $movie['Plot'];
$language = $movie['Language'];
$country = $movie['Country'];
$awards = $movie['Awards'];
$embed = $movie['Embed'];
$trailers ='';
$count = 0;

if (isset($_POST['form']) == "ok"){

$Me = user()->id;
$path = Phpfox::getParam('core.path');
$imdb = $_POST['imdbID'];
$imdb = str_replace(" ","",$imdb);



if ($_POST['imdbID'] != "" && $_POST['title'] != "" && $_POST['director'] != "" && $_POST['writer'] != "" && $_POST['actors'] != "" && $_POST['plot'] != "" && $_POST['year'] != "" && $_POST['rating'] != "" && $_POST['genre'] != "") {

db()->update(':ces_movies', ['imdbID' => $imdb, 'Title' => $_POST['title'], 'Year' => $_POST['year'], 'Runtime' => $_POST['runtime'], 'Genre' => $_POST['genre'], 'Released' => $_POST['date'], 'Director' => $_POST['director'], 'Writer' => $_POST['writer'], 'Actors' => $_POST['actors'], 'Rated' => $_POST['rated'], 'imdbRating' => $_POST['rating'], 'imdbVotes' => $_POST['votes'], 'Embed' => $_POST['embed'], 'Plot' => $_POST['plot'], 'Language' => $_POST['language'], 'Country' => $_POST['country'], 'Awards' => $_POST['awards']], ['imdbID' => $imdb]);

url()->send('/movies/view?m='.$imdb);

}else{
$html1 .= '<div class="error_message" role="error">'._p('This fields are mandatory:  imdbID, title, director, writer, actors, plot, year, IMDb rating, poster and genre').'</div>';

$title = $_POST['title'];
$imdbID = $_POST['imdbID'];
$director = $_POST['director']; 
$date = $_POST['date'];
$year = $_POST['year'];
$runtime = $_POST['runtime']; 
$genre = $_POST['genre'];
$actors = $_POST['actors'];
$writer = $_POST['writer'];
$rated = $_POST['rated'];
$rating = $_POST['rating'];
$votes = $_POST['votes'];
$plot = $_POST['plot'];
$language = $_POST['language'];
$country = $_POST['country'];
$awards = $_POST['awards'];
$poster = $_POST['poster'];
$embed = $_POST['embed'];


}

}

$html1 .= '

<form method="post" id="2" action="'.Phpfox::getParam('core.path').'movies/edit?m='.$imdb.'" >

<input type="hidden" name="form" value="ok" />

IMDb ID:
<input type="text" name="imdbID" value="'.$imdbID.'" readonly>
<br>'._p('Title').':
<input type="text" name="title" value="'.$title.'" >
<br>'._p('Director').':
<input type="text" name="director" value="'.$director.'" >
<br>'._p('Writer').':
<input type="text" name="writer" value="'.$writer.'" >
<br>'._p('Actors').':
<input type="text" name="actors" value="'.$actors.'" >
<br>'._p('Genre').':
<input type="text" name="genre" value="'.$genre.'" >
<br>'._p('Plot').':
<input type="text" name="plot" value="'.$plot.'" >
<br>'._p('Year').':
<input type="text" name="year" value="'.$year.'" >
<br>'._p('Released Date').':
<input type="text" name="date" value="'.$date.'" >
<br>'._p('Run Time').':
<input type="text" name="runtime" value="'.$runtime.'" >
<br>'._p('Rated').':
<input type="text" name="rated" value="'.$rated.'" >
<br>'._p('IMDb Rating').':
<input type="text" name="rating" value="'.$rating.'" >
<br>'._p('Votes').':
<input type="text" name="votes" value="'.$votes.'" >
<br>'._p('Language').':
<input type="text" name="language" value="'.$language.'" >
<br>'._p('Country').':
<input type="text" name="country" value="'.$country.'" >
<br>'._p('Awards').':
<input type="text" name="awards" value="'.$awards.'" >
<br>'._p('Trailer embed code').':
<input type="text" name="embed" value=\''.$embed.'\' ><br>

		
		<input type="submit" value="'._p('Submit').'" class="btn btn-primary">
</form>

';









return view('view.html', ['content' => $html1]);


});




// VIEW MOVIE
	Route('/view', function() {
		$html="";
		
		section(_p('Movies'), url('/movies'));

      // Create a sub menu
	$sub_menu = storage()->get('menu');
     subMenu('view', $sub_menu->value);

if (auth()->isLoggedIn() && user('share_movie', true)) {

	// Create an action button
		button(_p('Share a Movie'), url('/movies/add'), ['css_class' => 'popup']);
}
		$imdb = request()->get('m');
		$imdb = str_replace("/","",$imdb);

if ($imdb == 'tt0'){
url()->send('/movies/theaters');
}

if (strlen($imdb) == 3){
$imdb = str_replace("tt","",$imdb);
$imdb = 'tt000000'.$imdb;
url()->send('/movies/view?m='.$imdb);
}

if (strlen($imdb) == 4){
$imdb = str_replace("tt","",$imdb);
$imdb = 'tt00000'.$imdb;
url()->send('/movies/view?m='.$imdb);
}

if (strlen($imdb) == 5){
$imdb = str_replace("tt","",$imdb);
$imdb = 'tt0000'.$imdb;
url()->send('/movies/view?m='.$imdb);
}

if (strlen($imdb) == 6){
$imdb = str_replace("tt","",$imdb);
$imdb = 'tt000'.$imdb;
url()->send('/movies/view?m='.$imdb);
}

if (strlen($imdb) == 7){
$imdb = str_replace("tt","",$imdb);
$imdb = 'tt00'.$imdb;
url()->send('/movies/view?m='.$imdb);
}

if (strlen($imdb) == 8){
$imdb = str_replace("tt","",$imdb);
$imdb = 'tt0'.$imdb;
url()->send('/movies/view?m='.$imdb);
}





$movie = db()->select('*')->from(':ces_movies')->where(['imdbID' => $imdb ])->get();

		h1($movie['Title'], url('/movies/view?m='.$movie['imdbID']));

title($movie['Title'].' - '.$movie['Director'].' - '.$movie['Year']);


$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);
	
$views = $movie['views'] + 1;

db()->update(':ces_movies', ['views' => $views], ['imdbID' => $imdb]);


$html = '<div style="position:relative;max-width:100%;width:100%;min-height:330px;background-color:#f2f4f6;border: 1px lightgrey solid;margin:11px;padding:7px;-moz-box-shadow: 0px 0px 4px #aaaaaa;-webkit-box-shadow: 0px 0px 4px #aaaaaa;box-shadow: 0px 0px 4px #aaaaaa;"><div style="display:table;"><div style="display:table-row"><div style="display:table-cell;vertical-align:top;width:100%"><div style="position:relative"><div style="position:relative;margin:5px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#f2f4f6; width: 200px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:200px;height:300px;background-color:#dddddd;"><div style="position:absolute;left:5px;top:270px;border-radius: 3px;background-color:#dfa800;opacity: 0.9;padding:2px"><font size=2>IMDb:'.$movie['imdbRating'].'</font></div><div style="position:absolute;right:5px;top:270px;border-radius: 3px;background-color:#458a50;opacity: 0.9;padding:2px"><font size=2 color=white>'.$movie['Year'].'</font></div>';

$user = (new \Api\User())->get($movie['User']);
$movie_user = $user->name_link;


$html .= '<div style="position:relative;bottom:10px;left:-12px;width:200px;background-color:#eeeeee;border: 1px lightgrey solid;margin:11px;padding:7px;-moz-box-shadow: 0px 0px 2px #aaaaaa;-webkit-box-shadow: 0px 0px 4px #aaaaaa;box-shadow: 0px 0px 2px #aaaaaa;"><font size=2><b>'._p('Released').': </b>'.$movie['Released'].'<br><b>'._p('Rated').': </b>'.$movie['Rated'].'<br><b>'._p('Run Time').': </b>'.$movie['Runtime'].'<br><b>'._p('Language').': </b>'.$movie['Language'].'<br><b>'._p('Country').': </b>'.$movie['Country'];

if (!setting('hide_username')){
$html .= '<br><b>'._p('User').': </b>'.$movie_user;
}

$html .= '<br><b>'._p('Date').': </b>'.moment()->toString($movie['time_stamp']);

if (!setting('hide_views')){
$html .= '<br><b>'._p('Views').': </b>'.$movie['views'].'<br>';
}

$html .= '</font>';

if ($movie['Embed']){
$html .= '<div style="z-index:50;position:relative;left:-7px;bottom:-6px"><a class="popup" href="'.Phpfox::getParam('core.path').'movies/trailer?m='.$movie['imdbID'].'"><button type="button" class="btn btn-warning" style="width:200px">'._p('Watch the Trailer').'</button></a></div>';
}
$html .= '</div>';

$html .= '</div>';


if (auth()->isLoggedIn()){
$Me = user()->id;
$check_movie = db()->select('*')->from(':ces_movies_fav')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_movie){
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Add to Favorite list').'"><div  id = "star-'.$movie['imdbID'].'" class="star-'.$movie['imdbID'].'" style="z-index:50;position:absolute;left:185px;top:15px;color:white"><i class="fa fa-star fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Remove from Favorite list').'"><div  class="star-'.$movie['imdbID'].'" id="star-'.$movie['imdbID'].'" style="z-index:50;position:absolute;left:185px;top:15px;color:'.setting('star_color').'"><i class="fa fa-star fa-lg"></i></div></a>';
}

$check_watch = db()->select('*')->from(':ces_movies_watch')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_watch){
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Add to Watch list').'"><div  class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="z-index:50;position:absolute;left:160px;top:15px;color:white"><i class="fa fa-eye fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Remove from Watch list').'"><div   class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="z-index:50;position:absolute;left:160px;top:15px;color:'.setting('eye_color').'"><i class="fa fa-eye fa-lg"></i></div></a>';
}

$Me = user()->id;

if (auth()->isAdmin()) {
$html .= '<div style="position:absolute;top:-6px;right:0px;z-index:50"><a href="'.Phpfox::getParam('core.path').'movies/deleteconfirm?m='.$movie['imdbID'].'" class="popup"><i class="fa fa-close"></i></a></div>';
}else{

if ($Me == $movie['User']){
$html .= '<div style="position:absolute;top:-6px;right:0px;z-index:50"><a href="'.Phpfox::getParam('core.path').'movies/changeuserconfirm?m='.$movie['imdbID'].'" class="popup"><i class="fa fa-close"></i></a></div>';
}

}

if ((auth()->isAdmin() || $Me == $movie['User']) && user('edit', true)) {
$html .= '<div style="position:absolute;top:-6px;right:17px;z-index:50"><a href="'.Phpfox::getParam('core.path').'movies/edit?m='.$movie['imdbID'].'" ><i class="fa fa-edit"></i></a></div>';


}
}







$html .= '</div>';


$html .= '<div style="position:relative;vertical-align:top;width:98%;left:10px;margin:5px;min-width:200px">';


$html .= '<font size=5>'.$movie['Title'].'</font><br> <font size=3>'.$movie['Genre'].'<br><br></font><font size=2>'.$movie['Plot'].'<br><br><div style="display:table-row"><div style="display:table-cell"><div style="width:100%;position:relative;top:0px"><b>'._p('Director').': </b>'.$movie['Director'].'<b><br>'._p('Writer').': </b>'.$movie['Writer'].'<br><b>'._p('Actors').': </b>'.$movie['Actors'].'<br><b>'._p('Awards').': </b>'.$movie['Awards'].'<br></font>';


$rating = $movie['Rating'];

if (!$movie['Rating']){
$rating = 0;
$movie['Votes'] = 0;
}

if (setting('rating_stars')){

asset('<link rel="stylesheet" href ="https://fonts.googleapis.com/icon?family=Material+Icons"><script src="'.$path.'PF.Site/Apps/ces_movies/assets/Ratings.js"></script>
<link href ="'.$path.'PF.Site/Apps/ces_movies/assets/Ratings.css" rel="stylesheet"/>
');


$html .= '

<script>
document.addEventListener("DOMContentLoaded", function(event) { 
  
    document.querySelector(\'.input-float\')
        .appendChild(new Ratings({value: '.$rating.', input: \'float\', nStars: 10}));
  
});

</script>';

$html .= '<br><div class="demo-wrapper" style="font-size:20px">
            <div class="input-float"></div>
</div><font size=1>&nbsp;&nbsp;'.$rating.' / 10 ('._p('from').' '.$movie['Votes'].' '._p('Votes').')</font><br>
';
}
Phpfox_Template::instance()->setMeta('og:title', $movie['Title']);

Phpfox_Template::instance()->setMeta('og:description', $movie['Plot']);

Phpfox_Template::instance()->setMeta('description', $movie['Plot']);

Phpfox_Template::instance()->setMeta('og:url', Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID']);

Phpfox_Template::instance()->setMeta('og:image', $path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg');

if (setting('show_social')){
$html .= '<br>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57e4eaa01cb2852e"></script>
<div class="addthis_inline_share_toolbox" data-url="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" data-title="'.$movie['Title'].'" data-description="'.$movie['Plot'].'"  data-media="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="clear: both;"></div>';
}


$html .= '</div></div>';


$html .= '</div></div> </div></div></div></div>';





		return render('view_movie.html', ['content' => $html]);
	});



// Add movie form
	Route('/add', function() {
		auth()->membersOnly();
		title(_p('Add Movie'));
		section(_p('Movies'), url('/movies'));
		h1(_p('Share a Movie'), url('/movies/add'));
		$html ="";

		$html ='<form method="post" action="'.Phpfox::getParam('core.path').'movies/addmovie">

			<input type="text" id="name" name="name" value="" placeholder="'._p('Write some words to search for the movie or the imdbID').'">
		<select name="type">
<option value="0" selected>'._p('Movie Name').'</option>
<option value="1">'._p('imdbID').'</option>
</select>
		<input type="submit" value="'._p('Submit').'" class="btn btn-primary">
</form>';
		return render('add.html', ['content' => $html]);
	});



// Show Trailer
	Route('/trailer', function() {
		
		
		section(_p('Movies'), url('/movies'));
		$imdb = request()->get('m');

		$movie = db()->select('*')->from(':ces_movies')->where(['imdbID' => $imdb ])->get();
		title($movie['Title']);
		$embed = $movie['Embed'];


		echo $embed;

		return render('trailer.html');
	});




// Add to DB
	Route('/adddb', function() {
		auth()->membersOnly();

		$html="";
		$imdb = request()->get('m');
		$imdb_trailer = str_replace("tt","",$imdb);

		$movie = file_get_contents('http://www.omdbapi.com/?i='.$imdb.'&type=movie&plot=full&r=json&apikey=2398c1d6');
		$movie = json_decode($movie, true);

$titulo = str_replace(" ","%20",$movie['Title']);
$director = str_replace(" ","%20",$movie['Director']);

		$trailers = file_get_contents('https://www.googleapis.com/youtube/v3/search?part=id,snippet&q='.$titulo.'%20'.$director.'%20offical%20trailer%20movie&key=AIzaSyCwNJ28JWwlX6Q3D-7AanWZvd5N_VWpuzw&maxResults=1&type=video');
		$trailers = json_decode($trailers, true);

$videoId="";

foreach ($trailers['items'] as $trailer) {
        $videoId  = $trailer['id']['videoId'];  
    }

   $embed = '<iframe width="640" height="360" src="https://www.youtube.com/embed/'.$videoId.'" frameborder="0" allowfullscreen></iframe>';

if (setting('translate_content')){

$lang = strtoupper(setting('translate_language'));

$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=EN&tl=".urlencode($lang)."&dt=t&q=".urlencode($movie['Genre']);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
if($response !== false){
      preg_match('/\[\[\[\"(.*?)\"/', $response, $matches);
      $movie['Genre'] = $matches[1];
}

$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=EN&tl=".urlencode($lang)."&dt=t&q=".urlencode($movie['Plot']);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
if($response !== false){
      preg_match('/\[\[\[\"(.*?)\"/', $response, $matches);
      $movie['Plot'] = $matches[1];
}

$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=EN&tl=".urlencode($lang)."&dt=t&q=".urlencode($movie['Language']);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
if($response !== false){
      preg_match('/\[\[\[\"(.*?)\"/', $response, $matches);
      $movie['Language'] = $matches[1];
}

$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=EN&tl=".urlencode($lang)."&dt=t&q=".urlencode($movie['Country']);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
if($response !== false){
      preg_match('/\[\[\[\"(.*?)\"/', $response, $matches);
      $movie['Country'] = $matches[1];
}

$url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=EN&tl=".urlencode($lang)."&dt=t&q=".urlencode($movie['Awards']);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
if($response !== false){
      preg_match('/\[\[\[\"(.*?)\"/', $response, $matches);
      $movie['Awards'] = $matches[1];
}
}


$Me = user()->id;

$check_movie = db()->select('*')->from(':ces_movies')->where(['imdbID' => $imdb])->get();

if (!$check_movie){
		db()->insert(':ces_movies', ['imdbID' => $imdb, 'Title' => $movie['Title'], 'Year' => $movie['Year'], 'User' => user()->id, 'Runtime' => $movie['Runtime'], 'Genre' => $movie['Genre'], 'Released' => $movie['Released'], 'Director' => $movie['Director'], 'Writer' => $movie['Writer'], 'Actors' => $movie['Actors'], 'Rated' => $movie['Rated'], 'imdbRating' => $movie['imdbRating'], 'imdbVotes' => $movie['imdbVotes'], 'Embed' => $embed, 'Plot' => $movie['Plot'], 'Language' => $movie['Language'], 'Country' => $movie['Country'], 'Awards' => $movie['Awards'], 'time_stamp' => time()]);
}


$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);

$check = 0;

if ($embed == ""){
$embed = '<img src="'.$path.'PF.Site/Apps/ces_movies/no_trailer.jpg">';
$check = 1;
}else{
$embed = str_replace("640","100%",$embed);
$embed = str_replace("360","170",$embed);
}

$html .= '<div style="position:relative;max-width:100%;height:300px;background-color:#f2f4f6;border: 1px lightgrey solid;margin:11px;padding:7px;-moz-box-shadow: 0px 0px 4px #aaaaaa;-webkit-box-shadow: 0px 0px 4px #aaaaaa;box-shadow: 0px 0px 4px #aaaaaa;"><table><tr><td valign=top width=40%><img src="'.$path.'PF.Base/file/movies/posters/'.$imdb.'.jpg" height=290></td><td valign="top" width=100% height=200>'.$embed.'<br> <font size=1><div style="text-align:center;width:60%;position:absolute;top:180px">'.$movie['Rated'].' | '.$movie['Runtime'].' | '.$movie['Genre'].' | '.$movie['Released'].'<table width=100%><tr><td width=50%><b>Actors: <br></b>'.$movie['Actors'].'</td><br><br><td width=50% valign="top"><b>Director:<br></b>'.$movie['Director'].'</td></tr></table></div>';

$html .= '<div class="page_breadcrumbs_menu" style="position:absolute;bottom:-17px;right:0px;"><a class="btn btn-success" style="padding:2px" href="'.Phpfox::getParam('core.path').'movies/view?m='.$imdb.'"><span></span>'._p('VIEW DETAILS').'</a></div>'; 


$html .= '</table></tr></td></div>';

$html = str_replace('"','\"',$html);
$html = str_replace("/","\/",$html);
$feed = '{"title":"'._p('Added a new Movie: ').$movie['Title'].'","text":"'.$html.'"}';



$imdb = str_replace("tt","",$imdb);

//add to feed
if (setting('add_feed_movie')){

		
}
		url()->send('/movies/view?m='.$movie['imdbID']);
		

		return render('adddb.html');
	});




// Add to DB Favorites
	Route('/adddbfav', function() {
auth()->membersOnly();
		// Set the title
      title(_p('Favorites List'));
 
      // Set a section title
      section(_p('Favorites List'), '/favorites');

		$imdb = request()->get('m');
		
$movie = db()->select('*')->from(':ces_movies')->where(['imdbID' => $imdb ])->get();

$Me = user()->id;
$check_movie = db()->select('*')->from(':ces_movies_fav')->where(['imdbID' => $imdb, 'user_id' => $Me])->get();

if (!$check_movie){
		db()->insert(':ces_movies_fav', ['imdbID' => $imdb, 'user_id' => user()->id, 'owner' => $movie['User'], 'time_stamp' => time()]);
echo "<script>$('.star-".$imdb ."').css('color', '".setting('star_color')."');</script>";
echo '<div class="public_message" id="public_message">'._p('The movie was added to your favorite list').'</div>';

if ($movie['User'] != 1 && setting('notify_fav')){
$imdb1 = str_replace("tt","",$imdb);
$imdb1 = (int)$imdb1;
$feed_user = $movie['User'];
notify('ces_movies', 'my_update', $imdb1, $feed_user);
}


}else{
		db()->delete(':ces_movies_fav', ['imdbID' => $imdb, 'user_id' => user()->id]);
echo "<script>$('.star-".$imdb ."').css('color', 'white');</script>";
echo '<div class="public_message" id="public_message">'._p('The movie was removed from your favorite list').'</div>';
}


$html = "";

$movies = Phpfox::getLib('phpfox.database')
          ->select('*, a.time_stamp AS tempo')
            ->from(Phpfox::getT('ces_movies_fav'), 'a')
		->join(Phpfox::getT('ces_movies'), 'b', 'a.imdbID = b.imdbID')
		->where('a.user_id ='.$Me)
            ->limit(6)
	       ->order('a.time_stamp DESC')
            ->execute('getRows');

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);

$html .= '<div style="max-height:500px;">';
foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:10px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 165px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:165px;height:235px;background-color:#dddddd;"><div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:#dfa800;opacity: 0.9;padding:2px;font-size:x-small;color:black">'._p('Added').': '.moment()->toString($movie['tempo']).'</div>';



$html .= '</div></a>';

}
$html .= '</div><a href="'.Phpfox::getParam('core.path').'movies/favorite" >
<button type="button" class="btn btn-primary" style="width:100%">
'._p('VIEW MORE').'</button>
</a>';


//if (request()->segment(2) == "adddbfav"){
//url()->send('/movies/favorite');
//}
		

		return render('view.html', ['content' => $html] );
	});




// Add to DB Watch
	Route('/adddbwatch', function() {
auth()->membersOnly();
		// Set the title
      title(_p('Watch List'));
 
      // Set a section title
      section(_p('Watch List'), '/favorites');

		$imdb = request()->get('m');
		
$movie = db()->select('*')->from(':ces_movies')->where(['imdbID' => $imdb ])->get();

$Me = user()->id;
$check_movie = db()->select('*')->from(':ces_movies_watch')->where(['imdbID' => $imdb, 'user_id' => $Me])->get();

if (!$check_movie){
		db()->insert(':ces_movies_watch', ['imdbID' => $imdb, 'user_id' => user()->id, 'owner' => $movie['User'], 'time_stamp' => time()]);
echo "<script>$('.eye-".$imdb ."').css('color', '".setting('eye_color')."');</script>";
echo '<div class="public_message" id="public_message">'._p('The movie was added to your watch list').'</div>';

}else{
		db()->delete(':ces_movies_watch', ['imdbID' => $imdb, 'user_id' => user()->id]);
echo "<script>$('.eye-".$imdb ."').css('color', 'white');</script>";
echo '<div class="public_message" id="public_message">'._p('The movie was removed from your watch list').'</div>';

}

$html = "";

$movies = Phpfox::getLib('phpfox.database')
          ->select('*, a.time_stamp AS tempo')
            ->from(Phpfox::getT('ces_movies_watch'), 'a')
		->join(Phpfox::getT('ces_movies'), 'b', 'a.imdbID = b.imdbID')
		->where('a.user_id ='.$Me)
            ->limit(6)
	       ->order('a.time_stamp DESC')
            ->execute('getRows');

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);

$html .= '<div style="max-height:500px;">';
foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:10px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 165px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:165px;height:235px;background-color:#dddddd;"><div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:#dfa800;opacity: 0.9;padding:2px;font-size:x-small;color:black">'._p('Added').': '.moment()->toString($movie['tempo']).'</div>';



$html .= '</div></a>';

}
$html .= '</div><a href="'.Phpfox::getParam('core.path').'movies/watchlist" >
<button type="button" class="btn btn-primary" style="width:100%">
'._p('VIEW MORE').'</button>
</a>';

		//url()->send(request()->segment(1));
		

		return render('view.html', ['content' => $html] );
	});


// DELETE REVIEW
	Route('/deletereview', function() {
		auth()->membersOnly();
	
$imdb = request()->get('m');
$Me = user()->id;
$user = request()->get('u');

$movie = db()->select('*')->from(':ces_movies')->where(['imdbID' => $imdb ])->get();

$rating = $movie['Rating'] * $movie['Votes'];

$review = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies_reviews'))
		->where('user ='.$user.' and imdbID = "'.$imdb.'"')
            ->limit(1)
	       ->order('time_stamp DESC')
            ->execute('getRow');

$rating = $rating - $review['rating'];


$votes = $movie['Votes'] -1;

if ($votes != 0){
$rating = $rating / $votes;
}

$imdb1 = str_replace("tt","",$imdb);
$imdb1 = (int)$imdb1;
		
if (!auth()->isAdmin()) {
db()->delete(':ces_movies_reviews', ['imdbID' => $imdb, 'user' => $Me]);
db()->delete(':feed', ['item_id' => $imdb1, 'user_id' => $Me, 'app_id' => 1]);
}else{
db()->delete(':ces_movies_reviews', ['imdbID' => $imdb, 'user' => $user]);
db()->delete(':feed', ['item_id' => $imdb1, 'user_id' => $user, 'app_id' => 1]);
}


db()->update(':ces_movies', ['Votes' => $votes, 'Rating' => $rating], ['imdbID' => $imdb]);


		url()->send('/movies/view?m='.$imdb);
		

		return render('adddb.html');
	});

// DELETE REVIEW Confirmation
	Route('/deletereviewconfirm', function() {
		title(_p('DELETE'));
		$imdb = request()->get('m');
		$user = request()->get('u');
		$html ="";

		$html .= '<div class="error_message" role="error">'._p('Are you sure you want to delete this review?').'</div>';
		
	$html .= '<div class="page_breadcrumbs_menu" style="position:relative;bottom:0px;right:-98px;"><a class="btn btn-success" href="'.Phpfox::getParam('core.path').'movies/deletereview?m='.$imdb.'&u='.$user.'">
		<span></span>'._p('YES, DELETE!').'</a>
</div>'; 


		return render('view.html',['content' => $html]);
	});


// DELETE
	Route('/delete', function() {
		auth()->membersOnly();
	
$imdb = request()->get('m');
$imdb1 = str_replace("tt","",$imdb);
		
if (auth()->isAdmin()) {
		db()->delete(':ces_movies', ['imdbID' => $imdb]);
		db()->delete(':ces_movies_fav', ['imdbID' => $imdb]);
		db()->delete(':ces_movies_watch', ['imdbID' => $imdb]);
		db()->delete(':ces_movies_reviews', ['imdbID' => $imdb]);
		db()->delete(':feed', ['item_id' => $imdb1]);
}


		url()->send('/movies/');
		

		return render('adddb.html');
	});


// CHANGE USER
	Route('/changeuser', function() {
		auth()->membersOnly();
		$imdb = request()->get('m');
		$imdb1 = str_replace("tt","",$imdb);

		db()->update(':ces_movies', ['User' => 1], ['imdbID' => $imdb]);
		db()->update(':feed', ['user_id' => 1], ['item_id' => $imdb1, 'app_id' => 0]);




		url()->send('/movies/');
		

		return render('adddb.html');
	});


// DELETE Confirmation
	Route('/deleteconfirm', function() {
		title(_p('DELETE'));
		$imdb = request()->get('m');
		$html ="";

		$html .= '<div class="error_message" role="error">'._p('Are you sure you want to delete this movie?').'</div>';
		
	$html .= '<div class="page_breadcrumbs_menu" style="position:relative;bottom:0px;right:-98px;"><a class="btn btn-success" href="'.Phpfox::getParam('core.path').'movies/delete?m='.$imdb.'">
		<span></span>'._p('YES, DELETE!').'</a>
</div>'; 


		return render('view.html',['content' => $html]);
	});



// CHANGE USER confirm
	Route('/changeuserconfirm', function() {
		auth()->membersOnly();
		$imdb = request()->get('m');
		$html ="";
		
		$html .= '<div class="error_message" role="error">'._p('Are you sure you want to remove this movie from your list?').'</div>';
		
	$html .= '<div class="page_breadcrumbs_menu" style="position:relative;bottom:0px;right:-98px;"><a class="btn btn-success" href="'.Phpfox::getParam('core.path').'movies/changeuser?m='.$imdb.'">
		<span></span>'._p('YES, REMOVE!').'</a>
</div>'; 

	

		return render('view.html',['content' => $html]);
	});



// Confirm
	Route('/confirm', function() {
		auth()->membersOnly();
		section(_p('Movies'), url('/movies'));
		
	$html = "";
	$imdb = request()->get('m');
	
	$movie = file_get_contents('http://www.omdbapi.com/?i='.	$imdb.'&type=movie&plot=full&r=json&apikey=2398c1d6');
	$movie = json_decode($movie, true);

	title($movie['Title']);
	h1($movie['Title'], url('/movies/confirm'));

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);
$internal="";
$internal = str_replace("index.php","",$_SERVER['SCRIPT_FILENAME']); 

if ($movie['Poster'] != 'N/A'){
$ch = curl_init($movie['Poster']);
$fp = fopen($internal.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg', 'wb');
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);
}else{
$movie['Poster'] = $path.'PF.Site/Apps/ces_movies/no_image.jpg';
$ch = curl_init($movie['Poster']);
$fp = fopen($internal.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg', 'wb');
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);
}



$imdb = $movie['imdbID'];
$imdb = str_replace("tt","",$imdb);

$titulo = str_replace(" ","%20",$movie['Title']);
$director = str_replace(" ","%20",$movie['Director']);

		$trailers = file_get_contents('https://www.googleapis.com/youtube/v3/search?part=id,snippet&q='.$titulo.'%20'.$director.'%20offical%20trailer%20movie&key=AIzaSyCwNJ28JWwlX6Q3D-7AanWZvd5N_VWpuzw&maxResults=1&type=video');
		$trailers = json_decode($trailers, true);

$videoId="";

foreach ($trailers['items'] as $trailer) {
        $videoId  = $trailer['id']['videoId'];  
    }

   $embed = '<iframe width="100%" height="170" src="https://www.youtube.com/embed/'.$videoId.'" frameborder="0" allowfullscreen></iframe>';


if ($embed == ""){
$embed = '<img src="'.$path.'PF.Site/Apps/ces_movies/no_trailer.jpg">';
}

$check_movie = db()->select('*')->from(':ces_movies')->where(['imdbID' => $movie['imdbID']])->get();

$Me = user()->id;
$check_fav = db()->select('*')->from(':ces_movies_fav')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();


if ($check_movie){

if (!$check_fav){
$html .= '<div class="error_message" role="error">'._p('This movie is already on our DB. You can add it to your Favorite List!').'</div>';
}else{
$html .= '<div class="error_message" role="error">'._p('This movie is already on our DB and in your Favorite List!').'</div>';}
}

$html .= '<div style="position:relative;max-width:100%;height:300px;background-color:#f2f4f6;border: 1px lightgrey solid;margin:11px;padding:7px;-moz-box-shadow: 0px 0px 4px #aaaaaa;-webkit-box-shadow: 0px 0px 4px #aaaaaa;box-shadow: 0px 0px 4px #aaaaaa;"><table><tr><td valign=top width=35%><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" width=100%></td><td valign="top" width=65% height=200>'.$embed.'<br> <font size=1><div style="text-align:center;width:65%;position:absolute;top:180px">'.$movie['Rated'].' | '.$movie['Runtime'].' | '.$movie['Genre'].' | '.$movie['Released'].'<table width=100%><tr><td width=50%><b>'._p('Actors').': <br></b>'.$movie['Actors'].'</td><br><br><td width=50% valign="top"><b>'._p('Director').':<br></b>'.$movie['Director'].'</td></tr></table>';

if (!$check_movie){

$html .= '<div class="page_breadcrumbs_menu" style="position:absolute;bottom:-40px;right:0px;"><a class="btn btn-success" style="padding:2px" href="'.Phpfox::getParam('core.path').'movies/adddb?m='.$movie['imdbID'].'">
		<span></span>'._p('SHARE THIS MOVIE').'</a>
</div>'; 
}else{


if (!$check_fav){
$html .= '<div class="page_breadcrumbs_menu" style="position:absolute;bottom:-40px;right:0px;"><a class="btn btn-warning" style="padding:2px" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'">
		<span></span>'._p('ADD TO FAVORITES').'</a>
</div>'; 
}
}


$html .= '</td></tr></table></div> </font>';


	return render('confirm.html', ['content' => $html]);

	});






Route('/addmovie', function() {
auth()->membersOnly();
section(_p('Share a Movie'), '/movies/addmovies');

$html = "";   
$name = "";

if (auth()->isLoggedIn() && user('share_movie', true)) {

// Create an action button
button(_p('Share a Movie'), url('/movies/add'), ['css_class' => 'popup']);
}        
      // Create a sub menu
	$sub_menu = storage()->get('menu');
     subMenu('addmovie', $sub_menu->value);

 
     
$html ="";

if ($_POST['name'] == ""){
$html = '<div class="error_message" role="error">'._p('You must write the name of the movie or IMDb ID!').'</div>';
$_POST['name'] = "";
}

if ($_POST['type'] == 0){
$name ="";
$name = str_replace(" ","+",$_POST['name']);

$movie = file_get_contents('http://www.omdbapi.com/?s='.$name.'&type=movie&apikey=2398c1d6');

$movie = json_decode($movie, true);

if ($movie['Response'] == "False"){
$html .= '<div class="error_message" role="error">'._p('No movie found!').'</div>';
}

$count = count($movie['Search']);

for ($i = 0; $i < $count; $i++) {

$html.= '<div style="position:relative;max-width:100%;width:100%;background-color:#ffffff;border: 1px lightgrey solid;margin:11px;padding:7px;-moz-box-shadow: 0px 0px 4px #aaaaaa;-webkit-box-shadow: 0px 0px 4px #aaaaaa;box-shadow: 0px 0px 4px #aaaaaa;"><font size=4>'.$movie['Search'][$i]['Title'].' ('.$movie['Search'][$i]['Year'].')</font><div class="pull-right breadcrumbs_right_section" style="position:absolute;bottom:0px;right:0px"><div class="page_breadcrumbs_menu"><a class="btn btn-success popup" href="'.Phpfox::getParam('core.path').'movies/confirm?m='.$movie['Search'][$i]['imdbID'].'">
		<span></span>'._p('Share').'</a>
</div></div></div>';
}

}else{
$name = $_POST['name'];

$movie = file_get_contents('http://www.omdbapi.com/?i='.$name.'&plot=full&r=json&apikey=2398c1d6');
$movie = json_decode($movie, true);

if ($movie['Response'] == "False"){
$html .= '<div class="error_message" role="error">'._p('No movie found!').'</div>';
}else{


$html.= '<div style="position:relative;max-width:100%;width:100%;background-color:#ffffff;border: 1px lightgrey solid;margin:11px;padding:7px;-moz-box-shadow: 0px 0px 4px #aaaaaa;-webkit-box-shadow: 0px 0px 4px #aaaaaa;box-shadow: 0px 0px 4px #aaaaaa;"><font size=4>'.$movie['Title'].' ('.$movie['Year'].')</font><div class="pull-right breadcrumbs_right_section" style="position:absolute;bottom:0px;right:0px"><div class="page_breadcrumbs_menu"><a class="btn btn-success popup" href="'.Phpfox::getParam('core.path').'movies/confirm?m='.$movie['imdbID'].'">
		<span></span>'._p('Share').'</a>
</div></div></div>';

}

}


return render('addmovie.html', ['content' => $html]);



});

Route('/search', function() {

section(_p('Search').': '.$_POST['name'], '/movies/search');

$html = "";  
$name="";
if (auth()->isLoggedIn() && user('share_movie', true)) {

// Create an action button
button(_p('Share a Movie'), url('/movies/add'), ['css_class' => 'popup']);
        }
      // Create a sub menu
	$sub_menu = storage()->get('menu');
     subMenu('addmovie', $sub_menu->value);

 
      // Place a block
      block(1, function() {
	$html="";
 $html .= '<form method="post" action="'.Phpfox::getParam('core.path').'movies/search" >

			<input type="text" id="name" name="name" value="" placeholder="'._p('Write some words to search').'">
		<select name="type" class="dropdown-toggle">
<option value="0" selected>'._p('Title').'</option>
<option value="1">'._p('imdbID').'</option>
<option value="2">'._p('Director').'</option>
<option value="3">'._p('Actor').'</option>
<option value="4">'._p('Writer').'</option>
<option value="5">'._p('Genre').'</option>
</select>
		<input type="submit" value="'._p('Submit').'" class="btn btn-primary">
</form>';


         // Load views/search.html
         return view('@ces_movies/search.html', ['content' => $html]);
      });


if (!$_POST['name']){
$html = '<div class="error_message" role="error">'._p('You must write some words to find a movie!').'</div>';

}else{

if ($_POST['type'] == 0){

$name = $_POST['name'];

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('num_search'))
	    ->where('Title LIKE "%'.$name.'%"')
            ->order('time_stamp DESC')
            ->execute('getRows');
}


if ($_POST['type'] == 1){
$name = $_POST['name'];

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('num_search'))
	    	    ->where('imdbID LIKE "%'.$name.'%"')
            ->order('time_stamp DESC')
            ->execute('getRows');
}


if ($_POST['type'] == 2){

$name = $_POST['name'];

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('num_search'))
	    ->where('Director LIKE "%'.$name.'%"')
            ->order('time_stamp DESC')
            ->execute('getRows');
}

if ($_POST['type'] == 3){

$name = $_POST['name'];

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('num_search'))
	    ->where('Actors LIKE "%'.$name.'%"')
            ->order('time_stamp DESC')
            ->execute('getRows');
}

if ($_POST['type'] == 4){

$name = $_POST['name'];

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('num_search'))
	    ->where('Writer LIKE "%'.$name.'%"')
            ->order('time_stamp DESC')
            ->execute('getRows');
}

if ($_POST['type'] == 5){

$name = $_POST['name'];

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit(setting('num_search'))
	    ->where('Genre LIKE "%'.$name.'%"')
            ->order('time_stamp DESC')
            ->execute('getRows');
}



if (!$movies){
$html .= '<div class="error_message" role="error">'._p('No movie found!').'</div>';
}else{

$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);


foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:3px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 155px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:155px;height:225px;background-color:#dddddd;">';


if (setting('show_imdb')){
$html .= '<div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:2px;font-size:x-small;color:black">IMDb:'.$movie['imdbRating'].'</div>';
}

if (setting('show_year')){
$html .= '<div style="position:absolute;right:5px;bottom:5px;border-radius: 3px;background-color:'.setting('year_color').';opacity: 0.9;padding:2px;font-size:x-small;color:white">'.$movie['Year'].'</div>';
}


if (setting('show_star')){

$Me = user()->id;
$check_movie = db()->select('*')->from(':ces_movies_fav')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_movie){
$html .= '<a href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Add to Favorite list').'" class="popup"><div class="star-'.$movie['imdbID'].'" id="star-'.$movie['imdbID'].'"  style="position:absolute;right:5px;top:8px;opacity: 0.7;color:white"><i class="fa fa-star fa-lg"></i></div></a>';
}else{
$html .= '<a href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Remove from Favorite list').'" class="popup"><div class="star-'.$movie['imdbID'].'" id="star-'.$movie['imdbID'].'"   style="position:absolute;right:5px;top:8px;opacity: 0.9;color:'.setting('star_color').'"><i class="fa fa-star fa-lg"></i></div></a>';
}

$check_watch = db()->select('*')->from(':ces_movies_watch')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_watch){
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Add to Watch list').'"><div   class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"   style="position:absolute;right:27px;top:8px;opacity: 0.7;color:white"><i class="fa fa-eye fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Remove from Watch list').'"><div  class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"   style="position:absolute;right:27px;top:8px;opacity: 0.9;color:'.setting('eye_color').'"><i class="fa fa-eye fa-lg"></i></div></a>';
}
}

$html .= '</div></a>';
}
}
}

return render('view.html', ['content' => $html]);


});

});

new Core\Route('/viewmore', function(Core\Controller $controller) {

$html = "";
$Me = user()->id;
$object = storage()->get('viewmore');
$start = $object->value;

$get = storage()->get('cat');
$cat = $get->value;

echo "<script>$('#viewmore').attr('id','old');</script>";

$section = storage()->get('section');
$section = $section->value;

$country = user()->location['iso'];

if ($section == "theaters"){

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies'))
		 ->where ('Upcoming LIKE "%'.$country.'%"')
			->execute('getSlaveField');

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
		 ->where ('Upcoming LIKE "%'.$country.'%"')
            ->limit($start, setting('number_movies'))
	       ->order('time_stamp DESC')
            ->execute('getRows');
}


if ($section == "last"){

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies'))
			->execute('getSlaveField');

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit($start, setting('number_movies'))
	       ->order('time_stamp DESC')
            ->execute('getRows');
}

if ($section == "top"){

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies'))
			->execute('getSlaveField');

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit($start, setting('number_movies'))
	       ->order('imdbRating DESC')
            ->execute('getRows');
}

if ($section == "viewed"){

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies'))
		 	->where('views != 0')
			->execute('getSlaveField');

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit($start, setting('number_movies'))
		 ->where('views != 0')
	       ->order('views DESC')
            ->execute('getRows');
}

if ($section == "reviewed"){

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies'))
		 	->where('votes != 0')
			->execute('getSlaveField');

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit($start, setting('number_movies'))
		 ->where('votes != 0')
	       ->order('votes DESC')
            ->execute('getRows');
}

if ($section == "friends"){

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies'), 'a')
		 	->join(Phpfox::getT('friend'), 'c', 'c.user_id = "'.$Me.'" and c.friend_user_id = a.user')
			->execute('getSlaveField');

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'), 'a')
		 ->join(Phpfox::getT('friend'), 'c', 'c.user_id = "'.$Me.'" and c.friend_user_id = a.user')
            ->limit($start, setting('number_movies'))
	       ->order('a.time_stamp DESC')
            ->execute('getRows');
}


if ($section == "mymovies"){

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies'))
		 	->where('User = '.$Me)
			->execute('getSlaveField');

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit($start, setting('number_movies'))
		 ->where('User = '.$Me)
	       ->order('time_stamp DESC')
            ->execute('getRows');
}



if ($section == "favorites"){

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies_fav'))
			->where('user_id ='.$Me)
			->execute('getSlaveField');

$movies = Phpfox::getLib('phpfox.database')
          ->select('*, a.time_stamp AS tempo')
            ->from(Phpfox::getT('ces_movies_fav'), 'a')
		->join(Phpfox::getT('ces_movies'), 'b', 'a.imdbID = b.imdbID')
		->where('a.user_id ='.$Me)
            ->limit($start, setting('number_movies'))
	       ->order('a.time_stamp DESC')
            ->execute('getRows');
}

if ($section == "watchlist"){

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies_fav'))
			->where('user_id ='.$Me)
			->execute('getSlaveField');

$movies = Phpfox::getLib('phpfox.database')
          ->select('*, a.time_stamp AS tempo')
            ->from(Phpfox::getT('ces_movies_watch'), 'a')
		->join(Phpfox::getT('ces_movies'), 'b', 'a.imdbID = b.imdbID')
		->where('a.user_id ='.$Me)
            ->limit($start, setting('number_movies'))
	       ->order('a.time_stamp DESC')
            ->execute('getRows');
}

if ($section == "cat"){

$total = Phpfox::getLib('phpfox.database')
			->select('count(*)')
			->from(Phpfox::getT('ces_movies'))
			->where('genre LIKE "%'.$cat.'%"')
			->execute('getSlaveField');

$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
            ->limit($start, setting('number_movies'))
	       ->where('genre LIKE "%'.$cat.'%"')
	       ->order('time_stamp DESC')
            ->execute('getRows');
}



$total1 = setting('number_movies') * $start;
if ($total1 >= $total ){
echo '<script>$( ".botao" ).remove();</script>';
}

$start = $start +1;

storage()->del('viewmore');
storage()->set('viewmore', $start);


$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);


foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:3px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 155px;
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:155px;height:225px;background-color:#dddddd;">';

if ($section == "favorites" || $section == "watchlist"){

$html.= '<div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:#dfa800;opacity: 0.9;padding:2px;font-size:x-small;color:black">'._p('Added').': '.moment()->toString($movie['tempo']).'</div>';

}else{
if (setting('show_imdb')){

if ($section == "viewed"){
$html .= '<div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:2px;font-size:x-small;color:black">Views:'.$movie['views'].'</div>';
}else{

if ($section == "reviewed"){
$html .= '<div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:2px;font-size:x-small;color:black">Reviews:'.$movie['Votes'].'</div>';
}else{

if ($section == "friends"){
$html .= '<div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:2px;font-size:x-small;color:black">'.(new \Api\User())->get($movie['User'])->name.'</div>';
}else{
$html .= '<div style="position:absolute;left:5px;bottom:5px;border-radius: 3px;background-color:'.setting('imdb_color').';opacity: 0.9;padding:2px;font-size:x-small;color:black">IMDb:'.$movie['imdbRating'].'</div>';
}

}
}


}

if (setting('show_year')){
$html .= '<div style="position:absolute;right:5px;bottom:5px;border-radius: 3px;background-color:'.setting('year_color').';opacity: 0.9;padding:2px;font-size:x-small;color:white">'.$movie['Year'].'</div>';
}
}

if (setting('show_star')){

$Me = user()->id;
$check_movie = db()->select('*')->from(':ces_movies_fav')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_movie){
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Add to Favorite list').'"><div  id = "star-'.$movie['imdbID'].'" class="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.7;color:white"><i class="fa fa-star fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup" href="'.Phpfox::getParam('core.path').'movies/adddbfav?m='.$movie['imdbID'].'" title="'._p('Remove from Favorite list').'"><div  class="star-'.$movie['imdbID'].'" id="star-'.$movie['imdbID'].'" style="position:absolute;right:5px;top:8px;opacity: 0.9;color:'.setting('star_color').'"><i class="fa fa-star fa-lg"></i></div></a>';
}

$check_watch = db()->select('*')->from(':ces_movies_watch')->where(['imdbID' => $movie['imdbID'], 'user_id' => $Me])->get();

if (!$check_watch){
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Add to Watch list').'"><div  class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.7;color:white"><i class="fa fa-eye fa-lg"></i></div></a>';
}else{
$html .= '<a class="popup"  href="'.Phpfox::getParam('core.path').'movies/adddbwatch?m='.$movie['imdbID'].'" title="'._p('Remove from Watch list').'"><div   class="eye-'.$movie['imdbID'].'" id="eye-'.$movie['imdbID'].'"  style="position:absolute;right:27px;top:8px;opacity: 0.9;color:'.setting('eye_color').'"><i class="fa fa-eye fa-lg"></i></div></a>';
}
}


$html .= '</div></a>';

}

$html .= '<div id="viewmore"></div>';
echo $html;
});

new Core\Route('/ratings', function(Core\Controller $controller) {

title(_p('Updated Ratings'));


$html="";


$movies = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('ces_movies'))
		 ->where ('imdbRating = 0')
	       ->order('time_stamp DESC')
            ->execute('getRows');

echo '<br>';

foreach ($movies as $movie) {

$imdb = $movie['imdbID'];

		$check = file_get_contents('http://www.omdbapi.com/?i='.$imdb.'&type=movie&plot=full&r=json&apikey=2398c1d6');
		$check = json_decode($check, true);

if ($check['imdbRating'] == "N/A"){
$html .= '<b>'.$movie['Title'].'</b><br><font size=2>  Rating ('.$movie['imdbRating'].')  >>> New Rating('.$check['imdbRating'].') </font><br><br>';

}else{

$html .=  '<b>'.$movie['Title'].'</b><br><font size=2 color=green><b>  Rating ('.$movie['imdbRating'].')  >>> New Rating('.$check['imdbRating'].') </b></font><br><br>';

db()->update(':ces_movies', ['imdbRating' => $check['imdbRating']], ['imdbID' => $imdb]);
}

}

return render('view.html', ['content' => $html]);
});

block('Favorite Movies', function(){
		
$User_name  = request()->segment(1);
$html = "";

$Get = Phpfox::getLib('phpfox.database')
          ->select('*')
            ->from(Phpfox::getT('user'), 'a')
            ->limit(1)
            ->where('a.user_name = "'.$User_name.'"')
		 ->execute('getRow');

$Me = $Get['user_id'];

$movies = Phpfox::getLib('phpfox.database')
          ->select('*, a.time_stamp AS tempo')
            ->from(Phpfox::getT('ces_movies_fav'), 'a')
		->join(Phpfox::getT('ces_movies'), 'b', 'a.imdbID = b.imdbID')
		->where('a.user_id ='.$Me)
            ->limit(setting('fav_block'))
	       ->order('rand()')
            ->execute('getRows');


$path = Phpfox::getParam('core.path');
$path = str_replace("index.php","",$path);

if (!$movies){
$html = _p('No movies added to the favorite list');
}

foreach ($movies as $movie) {

     $html .= '<a href="'.Phpfox::getParam('core.path').'movies/view?m='.$movie['imdbID'].'" title="'.$movie['Title'].' ('.$movie['Year'].') - '.$movie['Director'].'" ><div  style="position:relative;margin:2px;float:left;padding:1px;border:1px;solid #ccc;color: #444;-moz-box-shadow: 0px 0px 4px #cccccc;-webkit-box-shadow: 0px 0px 4px #cccccc;box-shadow: 0px 0px 4px #cccccc;background-color:#ffffff;width: 60px;height:90px
"><img src="'.$path.'PF.Base/file/movies/posters/'.$movie['imdbID'].'.jpg" style="margin:0px;width:60px;height:90px;background-color:#dddddd;"></div></a>';
}
return view('@ces_movies/fav_block.html', [
			'content' => $html

		]);


	});
