<?php

namespace Apps\YNC_FbClone\Installation\Data;
use Phpfox;

class v402
{
    private $_sIcons;

    public function __construct()
    {
        $this->_sIcons = "INSERT IGNORE INTO `" . Phpfox::getT('ync_facebook_icons') . "` (`keywords`, `icon`) VALUES
            ('blog,write','ico-blogs.png'),
            ('music,sound','ico-music.png'),
            ('video,clip','ico-videos.png'),
            ('photo,picture','ico-photos.png'),
            ('poll,analytic','ico-poll.png'),
            ('quizz,question','ico-quizz.png'),
            ('event','ico-event.png'),
            ('shop,listing,market','ico-shops.png'),
            ('discussion,forum','ico-forum.png'),
            ('member,members,user','ico-members.png'),
            ('group','ico-groups.png'),
            ('page','ico-pages.png'),
            ('home,feed,news,dashboard','ico-news-feed.png'),
            ('message,chat','ico-message.png')
		";
    }

    public function process()
    {
        $oDatabase = db();
        if (!$oDatabase->isField(':menu', 'server_id')) {
            $oDatabase->query("ALTER TABLE `" . Phpfox::getT('menu') . "` ADD `server_id` INT(11) DEFAULT '0'");
        }
        if (!$oDatabase->isField(':menu', 'image_path')) {
            $oDatabase->query("ALTER TABLE `" . Phpfox::getT('menu') . "` ADD `image_path` VARCHAR(200)");
        }

        $iTotalIcons = db()
            ->select('COUNT(icon_id)')
            ->from(':ync_facebook_icons')
            ->execute('getField');

        if ($iTotalIcons == 0) {
            db()->query($this->_sIcons);
        }
    }
}