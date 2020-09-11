<?php

$installer = new Core\App\Installer();

$installer->onInstall(function() use ($installer) {
	
$internal = str_replace("index.php","",$_SERVER['SCRIPT_FILENAME']); 

$path1 = $internal.'PF.Base/file/movies/posters/';
$path = $internal.'PF.Base/file/movies/';

if(!is_dir($path)) {
     mkdir($path, 0777);
     mkdir($path1, 0777);
    }

$installer->db->query("CREATE TABLE IF NOT EXISTS `".Phpfox::getT('ces_movies')."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imdbID` varchar(45) NOT NULL,
  `Title` varchar(200) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL,
  `User` int(11) DEFAULT NULL,
  `Runtime` varchar(45) DEFAULT NULL,
  `Genre` varchar(200) DEFAULT NULL,
  `Released` varchar(45) DEFAULT NULL,
  `Director` varchar(45) DEFAULT NULL,
  `Writer` varchar(45) DEFAULT NULL,
  `Actors` text,
  `Rated` varchar(11) DEFAULT NULL,
  `Rating` double DEFAULT NULL,
  `Votes` int(11) DEFAULT NULL,
  `imdbRating` double DEFAULT NULL,
  `imdbVotes` int(11) DEFAULT NULL,
  `Embed` varchar(500) DEFAULT NULL,
  `Plot` text,
  `Language` varchar(45) DEFAULT NULL,
  `Country` varchar(45) DEFAULT NULL,
  `Awards` varchar(200) DEFAULT NULL,
  `Upcoming` varchar(300) NOT NULL,
  `time_stamp` varchar(45) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`Title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");

$installer->db->query("CREATE TABLE IF NOT EXISTS `".Phpfox::getT('ces_movies_fav')."` (
  `user_id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `imdbID` varchar(45) NOT NULL,
  `time_stamp` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;");

$installer->db->query("CREATE TABLE IF NOT EXISTS `".Phpfox::getT('ces_movies_watch')."` (
  `user_id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `imdbID` varchar(45) NOT NULL,
  `time_stamp` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;");

$installer->db->query("CREATE TABLE IF NOT EXISTS `".Phpfox::getT('ces_movies_reviews')."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imdbID` varchar(45) NOT NULL,
  `title` varchar(100) NOT NULL,
  `review` mediumtext,
  `user` int(11) DEFAULT NULL,
  `rating` double DEFAULT NULL,
  `time_stamp` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");


});