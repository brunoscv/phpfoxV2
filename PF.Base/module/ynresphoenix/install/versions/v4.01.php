<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @version         4.01
 * @package         Ynclean
 *
 * @author          YouNetCo
 * @copyright       [YouNetCo]
 */

function ynresphoenix_install401()
{
    $oDb = Phpfox::getLib('phpfox.database');
    $oDb->query("
        CREATE TABLE IF NOT EXISTS `". Phpfox::getT('ynresphoenix_pages') ."` (
            `page_id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(256) NULL,
            `description` text NULL,
            `background_path` varchar(150) DEFAULT NULL,
            `icon_path` varchar(150) DEFAULT NULL,
            `icon_hover_path` varchar(150) DEFAULT NULL,
            `server_id` tinyint(1) NOT NULL DEFAULT '0',
            `type` varchar(64) NOT NULL DEFAULT '',
            `enabled` tinyint(1) NOT NULL DEFAULT '1',
            `ordering` int(2) NOT NULL DEFAULT '0',
            `params` text NULL,
            PRIMARY KEY (`page_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
    $oDb->query("
        CREATE TABLE IF NOT EXISTS `". Phpfox::getT('ynresphoenix_items') ."` (
            `item_id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(256) NULL,
            `description` text NULL,
            `type` varchar(64) NOT NULL DEFAULT '',
            `page_type` varchar(64) NOT NULL,
            `ordering` smallint(6) NOT NULL DEFAULT '0',
            `user_id` int(10) unsigned NOT NULL,
            `time_stamp` int(10) unsigned NOT NULL,
            `params` text NULL,
            PRIMARY KEY (`item_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
    $oDb->query("
        CREATE TABLE IF NOT EXISTS `". Phpfox::getT('ynresphoenix_photos') ."` (
            `photo_id` int(11) NOT NULL AUTO_INCREMENT,
            `parent_id` int(11) NOT NULL DEFAULT '0',
            `photo_path` varchar(255) DEFAULT NULL,
            `description` varchar(255) DEFAULT NULL,
            `photo_type` varchar(64) DEFAULT 'image',
            `server_id` tinyint(1) NOT NULL DEFAULT '0',
            `page_type` varchar(64) DEFAULT NULL,
            `user_id` int(10) unsigned NOT NULL,
            `time_stamp` int(10) unsigned NOT NULL,
            `ordering` tinyint(4) DEFAULT '0',
            PRIMARY KEY (`photo_id`),
            UNIQUE KEY `photo_path` (`photo_path`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

    $aRowPages = $oDb->select('background_path')->from(Phpfox::getT('ynresphoenix_pages'))->execute('getRows');
    if(!$aRowPages || !count($aRowPages)) {
        $oDb->query("
		INSERT IGNORE INTO `" . Phpfox::getT('ynresphoenix_pages') . "`(`page_id`, `title`,`description`,`params`,`background_path`,`type`) VALUES
			(1, 'ynresphoenix.home','The ideal template for business platform. You can build your own template simply by all settings in AdminCP. Especially, the template is design to be user-friendly and flexible with many blocks to enable you to...','{\"button_text\":\"View More\",\"link\":\"https://phpfox.younetco.com\",\"social_text\":\"Phoenix Template\",\"facebook\":\"https://www.facebook.com\",\"twitter\":\"https://www.twitter.com\",\"google\":\"https://www.google.com\"}','ynresphoenix/default/home_bg.png', 'home'),
			(2, 'ynresphoenix.team_members','','{\"button_text\":\"View Detail\"}','ynresphoenix/default/member_bg.jpg', 'member'),
			(3, 'ynresphoenix.feature_products','','{\"button_text\":\"View Detail\"}','ynresphoenix/default/product_bg.jpeg', 'product'),
			(4, 'ynresphoenix.testimonials','','','', 'testimonial'),
			(5, 'ynresphoenix.photo_galleries','','','', 'photo'),
			(6, 'ynresphoenix.contact_us','','{\"main_photo_path\":\"ynresphoenix/default/contact_photo.jpg\",\"show_map\":\"1\"}','ynresphoenix/default/contact_bg_reponsive.jpg','contact');
			");
    }
    $aRowPhotos = $oDb->select('photo_id')->from(Phpfox::getT('ynresphoenix_photos'))->execute('getRows');
    if(!$aRowPhotos || !count($aRowPhotos)) {
        $oDb->query("
        INSERT IGNORE INTO `" . Phpfox::getT('ynresphoenix_photos') . "`(`photo_id`, `parent_id`, `photo_path`,`photo_type`,`page_type`) VALUES
            (1,0,'ynresphoenix/default/home_img_slider1.jpg','photo','home'),
            (2,0,'ynresphoenix/default/home_img_slider2.jpg','photo','home'),
            (3,0,'ynresphoenix/default/home_img_slider3.jpg','photo','home'),
            (4,0,'ynresphoenix/default/home_img_slider4.jpg','photo','home'),
            (33,0,'ynresphoenix/default/home_img_slider5.jpg','photo','home'),
            (5,9,'ynresphoenix/default/member_avatar01.png','photo','member'),
            (6,10,'ynresphoenix/default/member_avatar02.png','photo','member'),
            (7,11,'ynresphoenix/default/member_avatar03.png','photo','member'),
            (8,12,'ynresphoenix/default/member_avatar04.png','photo','member'),
            (9,13,'ynresphoenix/default/member_avatar05.jpg','photo','member'),
            (10,14,'ynresphoenix/default/member_avatar06.png','photo','member'),
            (11,15,'ynresphoenix/default/member_avatar07.png','photo','member'),
            (12,16,'ynresphoenix/default/member_avatar08.png','photo','member'),
            (13,21,'ynresphoenix/default/photo01.png','photo','photo'),
            (14,21,'ynresphoenix/default/photo02.png','photo','photo'),
            (15,21,'ynresphoenix/default/photo03.png','photo','photo'),
            (16,21,'ynresphoenix/default/photo04.jpg','photo','photo'),
            (17,21,'ynresphoenix/default/photo05.png','photo','photo'),
            (18,21,'ynresphoenix/default/photo06.png','photo','photo'),
            (19,21,'ynresphoenix/default/photo07.png','photo','photo'),
            (20,21,'ynresphoenix/default/photo08.jpg','photo','photo'),
            (21,17,'ynresphoenix/default/product_slider_sm01.png','main_photo','product'),
            (22,18,'ynresphoenix/default/product_slider_sm02.png','main_photo','product'),
            (23,19,'ynresphoenix/default/product_slider_sm03.png','main_photo','product'),
            (24,20,'ynresphoenix/default/product_slider_sm04.jpg','main_photo','product'),
            (25,17,'ynresphoenix/default/product_sm01.png','photo','product'),
            (26,17,'ynresphoenix/default/product_sm02.png','photo','product'),
            (27,17,'ynresphoenix/default/product_sm03.png','photo','product'),
            (28,4,'ynresphoenix/default/testimonial_01.jpg','photo','testimonial'),
            (29,5,'ynresphoenix/default/testimonial_02.jpg','photo','testimonial'),
            (30,6,'ynresphoenix/default/testimonial_03.jpg','photo','testimonial'),
            (31,7,'ynresphoenix/default/testimonial_04.jpg','photo','testimonial'),
            (32,8,'ynresphoenix/default/testimonial_05.jpg','photo','testimonial')
    ");
    }
    $aRowItems = $oDb->select('item_id')->from(Phpfox::getT('ynresphoenix_items'))->execute('getRows');
    if(!$aRowItems || !count($aRowItems)) {
        $oDb->query("
        INSERT IGNORE INTO `" . Phpfox::getT('ynresphoenix_items') . "`(`item_id`, `title`, `description`,`type`,`page_type`,`params`,`time_stamp`) VALUES
            (1,'Head office','','contact','contact','{\"location_fulladdress\":\"19230 White Oak Farm Lane, Valley Lee, Maryland, United States\",\"location_address\":\"19230 White Oak Farm Lane, Valley Lee, Maryland, United States\",\"location_address_city\":\"\",\"location_address_country\":\"\",\"location_address_lat\":\"38.193615\",\"location_address_lng\":\"-76.49866500000002\",\"zip_code\":\"20692\",\"phone\":[\"2122454485\"],\"fax\":[\"2122454485\"],\"email\":\"business_support@webmail.com\"}'," . time() . "),
            (2,'Showroom','','contact','contact','{\"location_fulladdress\":\"7960 Homewood Street Randallstown, MD 21122\",\"location_address\":\"7960 Homewood Street Randallstown, MD 21122\",\"location_address_city\":\"\",\"location_address_country\":\"\",\"location_address_lat\":\"38.193615\",\"location_address_lng\":\"-76.49866500000002\",\"zip_code\":\"21122\",\"phone\":[\"213-453-0011\"],\"fax\":[\"520-254-7226\"],\"email\":\"showroom@webmail.com\"}'," . time() . "),
            (3,'Customer Care Centre','','contact','contact','{\"location_fulladdress\":\"7961 Homewood Street Randallstown, MD 21122\",\"location_address\":\"7961 Homewood Street Randallstown, MD 21122\",\"location_address_city\":\"\",\"location_address_country\":\"\",\"location_address_lat\":\"38.193615\",\"location_address_lng\":\"-76.49866500000002\",\"zip_code\":\"21122\",\"phone\":[\"213-455-0012\"],\"fax\":[\"256-353-9293\"],\"email\":\"custom_care@webmail.com\"}'," . time() . "),
            (4,'Sean. D Stack','Want a custom branding and user experience that goes beyond out-of-the box and other third-party phpFox templates?','testimonial','testimonial','{\"position\":\"Product Manager\"}'," . time() . "),
            (5,'Ryan Golover','Looking for an experienced professional to assist you with a phpFox PHP install? Need an expert in information architecutre and website planning?','testimonial','testimonial','{\"position\":\"Art & Brand Director\"}'," . time() . "),
            (6,'Jessica Biel','Need technical expertise that can get down and dirty with PHP code? Looking for a group of PHP programers and database gurus who customize sites all day long?','testimonial','testimonial','{\"position\":\"Web Developer\"}'," . time() . "),
            (7,'Anna Chirstine','Need help growing and nurturing your social community? Looking for best practices, strategies, tips and tricks for getting more community members and engagement?','testimonial','testimonial','{\"position\":\"Social Marketer\"}'," . time() . "),
            (8,'William Gommez','Need guaranteed up-times, around the clock technical support and a hosting provider with a phpFox track record of success? How about a load-balanced?','testimonial','testimonial','{\"position\":\"UX Designer Leader\"}'," . time() . "),
            (9,'Roger Watte','Currently, I am pursuing MBA from one of the best institute in MP: Prestige Institute of Management and Research with Marketing as specialisation.','member','member','{\"position\":\"Art & Brand Director\",\"phone\":\"+84 2126789\",\"email\":\"rogerwatte@webmail.com\",\"address\":\"237 Famoso Plz, Union City, CA, 94587\",\"favorite_quote\":\"People are definitely a companys greatest asset. It does not make any difference whether the product is cars or cosmetics. Acompany is only as good as the people it keeps\"}'," . time() . "),
            (10,'Anna Crulse','I had completed MBA from NIMS University and completed my graduation from Mumbai University my standard 12 and 10 had also been done from Mumbai Board','member','member','{\"position\":\"Product Manager\",\"phone\":\"+84 2126789\",\"email\":\"annacrulse@webmail.com\",\"address\":\"238 Famoso Plz, Union City, CA, 94587\",\"favorite_quote\":\"Success is not a destination, but the road that you are on. Being successful means that you are working hard and walking your walk every day. You can only live your dream by working hard towards it. That is living your dream.\"}'," . time() . "),
            (11,'Alexander Costa','','member','member','{\"position\":\"Web Developer\",\"phone\":\"+84 2126790\",\"email\":\"alexandercosta@webmail.com\",\"address\":\"239 Famoso Plz, Union City, CA, 94587\",\"favorite_quote\":\"Do not be afraid to be awesome. Sometimes being weird and different is good. When you think you are working hard, there is always someone else working harder, so always be yourself and know your stuff\"}'," . time() . "),
            (12,'Thomas Bujer','','member','member','{\"position\":\"Social Marketer\",\"phone\":\"+84 2126791\",\"email\":\"thomasbujer@webmail.com\",\"address\":\"240 Famoso Plz, Union City, CA, 94587\",\"favorite_quote\":\"You can admire people for sure, and they are worth admiring, but you need to find that special thing about yourself. It takes working hard, getting the technique, and learning to sing and all that stuff, but the master class is about bringing yourself to the role.\"}'," . time() . "),
            (13,'Willy Smith','','member','member','{\"position\":\"UX Designer Leader\",\"phone\":\"+84 2126792\",\"email\":\"willysmith@webmail.com\",\"address\":\"241 Famoso Plz, Union City, CA, 94587\",\"favorite_quote\":\"Our responsibility is to rally and lead the whole party and the Chinese people of all ethnic groups, take up this historic baton and continue working hard for the great renewal of the Chinese nation, so that we will stand rock firm in the family of nations and make fresh and greater contribution to mankind. \"}'," . time() . "),
            (14,'Brian Ferdinand','','member','member','{\"position\":\"Frontend Developer\",\"phone\":\"+84 2126793\",\"email\":\"brianferdinand@webmail.com\",\"address\":\"242 Famoso Plz, Union City, CA, 94587\",\"favorite_quote\":\"You really have to work hard and apply yourself and by applying yourself and working hard and being diligent, you can achieve success.\"}'," . time() . "),
            (15,'Aine McCarthy','','member','member','{\"position\":\"UX Designer\",\"phone\":\"+84 2126743\",\"email\":\"ainemccarthy@webmail.com\",\"address\":\"300 Famoso Plz, Union City, CA, 94587\",\"favorite_quote\":\"Enough is enough. Six years you serve the countries. You been working hard. You sacrifice your time even your life. And, even your family life. So it is, it is time for me to go back as a private citizen. And contribute to the Thai society outside political arena.\"}'," . time() . "),
            (16,'Jessica Shiner','','member','member','{\"position\":\"Account Manager\",\"phone\":\"+84 2126744\",\"email\":\"jessicashiner@webmail.com\",\"address\":\"300 Famoso Plz, Union City, CA, 94587\",\"favorite_quote\":\"One of the greatest things about being an artist is, as you get older, if you keep working hard in relationship to what you want the world to be and how you want it to become, there is a history of interesting growth that resonates with different moments in your life. \"}'," . time() . "),
            (17,'Nova creamy white sofa','The Nova collection characterizes a Danish design that elegantly unifies modern minimalist lines with functionality','product','product','{\"currency\":\"$\",\"price\":\"455\",\"discount_price\":\"325.99\",\"link_text\":\"View Detail\",\"link\":\"https:\/\/phpfox.younetco.com\"}'," . time() . "),
            (18,'Masculine Modern Products Rides','Sweet design on demand new products to brighten the winter blues modern products rides High Definition Rated 59 from 100 by 177 users','product','product','{\"currency\":\"$\",\"price\":\"300\",\"discount_price\":\"245.85\",\"link_text\":\"View Detail\",\"link\":\"https:\/\/phpfox.younetco.com\"}'," . time() . "),
            (19,'A Chair Resurrection for Easter','One of the nice little bonuses of doing a blog is that surprises land in my in-box out of the blue','product','product','{\"currency\":\"$\",\"price\":\"450\",\"discount_price\":\"315\",\"link_text\":\"View Detail\",\"link\":\"https:\/\/phpfox.younetco.com\"}'," . time() . "),
            (20,'Windback Chair For More Comfor Body','Wingback chair is used if you want to make that is also installed with the chair, the home is more beautiful by the chair','product','product','{\"currency\":\"$\",\"price\":\"330\",\"discount_price\":\"255.5\",\"link_text\":\"View Detail\",\"link\":\"https:\/\/phpfox.younetco.com\"}'," . time() . "),
            (21,'Working Environment','','gallery','photo',''," . time() . "),
            (22,'YouNetians','','gallery','photo',''," . time() . "),
            (23,'YouNet Office','','gallery','photo',''," . time() . "),
            (24,'Company Trip','','gallery','photo',''," . time() . "),
            (25,'Meetings','','gallery','photo',''," . time() . "),
            (26,'Team Building','','gallery','photo',''," . time() . "),
            (27,'Activities','','gallery','photo',''," . time() . "),
            (28,'YouNet Campaign','','gallery','photo',''," . time() . ")
            
        ");
    }
}

ynresphoenix_install401();