<?php
namespace Apps\YNC_FbClone\Service;
use Phpfox_Service;
use Phpfox;
use Phpfox_Request;
use Phpfox_Error;
use Phpfox_Plugin;

class Process extends Phpfox_Service
{
    public function __construct()
    {
        $this->_sTable = Phpfox::getT('ync_facebook_shortcuts');
    }

    public function insertShortcut()
    {
        $sCondType = '';
        $sCondLike = '';
        if (Phpfox::isModule('pages') && Phpfox::isModule('groups')) {
            $sCondType = ' AND (p.item_type IN (0,1))';
            $sCondLike = '(l.type_id IN (\'groups\', \'pages\'))';
        } else {
            if (Phpfox::isModule('pages')) {
                $sCondType = ' AND p.item_type = ' . Phpfox::getService('pages')->getFacade()->getItemTypeId();
                $sCondLike = 'l.type_id = \'pages\'';
            } elseif (Phpfox::isModule('groups')) {
                $sCondType = ' AND p.item_type = ' . Phpfox::getService('groups')->getFacade()->getItemTypeId();
                $sCondLike = 'l.type_id = \'groups\'';
            }
        }
        $aPages = Phpfox::getLib('database')->select('p.*, pt.name as type_name, pc.name as category_name, ph.destination as cover_image_path, ph.server_id as cover_image_server_id, pu.vanity_url, u.server_id, ' . Phpfox::getUserField())
            ->from(':like', 'l')
            ->join(':pages', 'p',
                'p.page_id = l.item_id AND p.view_id = 0 ' . $sCondType)
            ->join(':user', 'u', 'u.profile_page_id = p.page_id')
            ->leftJoin(':pages_url', 'pu', 'pu.page_id = p.page_id')
            ->leftJoin(':photo', 'ph', 'ph.photo_id = p.cover_photo_id')
            ->leftJoin(':pages_type', 'pt', 'p.type_id = pt.type_id')
            ->leftJoin(':pages_category', 'pc', 'p.category_id = pc.category_id')
            ->where($sCondLike)
            ->group('p.page_id', true)
            ->executeRows();
        $aShortcutId = db()->select('page_id')
            ->from($this->_sTable, 'ys')
            ->where('ys.owner_id = ' . Phpfox::getUserId())
            ->executeRows();
        $aPagesId = db()->select('distinct l.item_id')
            ->from(':like', 'l')
            ->where('l.type_id IN (\'pages\', \'groups\') AND l.user_id = ' . Phpfox::getUserId())
            ->executeRows();
        $aExists = array();
        foreach ($aShortcutId as $iKey => $aValue) {
            if (!in_array($aValue['page_id'], $aExists, true)) {
                array_push($aExists, $aValue['page_id']);
            }
        }
        $aInsert = array();
        foreach ($aPagesId as $iKey => $aValue) {
            if (!in_array($aValue['item_id'], $aInsert, true)) {
                array_push($aInsert, $aValue['item_id']);
            }
        }

        foreach ($aPages as $iKey => $aPage) {
            if (in_array($aPage['page_id'], $aInsert,
                    true) && (count($aShortcutId) < count($aPagesId)) && !in_array($aPage['page_id'], $aExists, true)) {
                $iMinOrder = db()->select('min(ordering) as min')
                    ->from($this->_sTable)
                    ->where('owner_id = ' . Phpfox::getUserId())
                    ->executeField();
                db()->insert($this->_sTable, array(
                    'page_id' => $aPage['page_id'],
                    'owner_id' => Phpfox::getUserId(),
                    'ordering' => $iMinOrder - 1
                ));
            }
        }
    }

    public function getItemsShortcuts($iLimit = null, $sExtraCond = null)
    {
        $this->insertShortcut();
        $sCondType = '';
        $sCondLike = '';
        if (Phpfox::isModule('pages') && Phpfox::isModule('groups')) {
            $sCondType = ' AND (p.item_type IN (0,1))';
            $sCondLike = '(l.type_id IN (\'groups\', \'pages\')) AND ';
        } else {
            if (Phpfox::isModule('pages')) {
                $sCondType = ' AND p.item_type = ' . Phpfox::getService('pages')->getFacade()->getItemTypeId();
                $sCondLike = 'l.type_id = \'pages\'' . ' AND ';
            } elseif (Phpfox::isModule('groups')) {
                $sCondType = ' AND p.item_type = ' . Phpfox::getService('groups')->getFacade()->getItemTypeId();
                $sCondLike = 'l.type_id = \'groups\'' . ' AND ';
            }
        }
        $aPages = Phpfox::getLib('database')->select('p.*, pt.name as type_name, pc.name as category_name, ph.destination as cover_image_path, ph.server_id as cover_image_server_id, pu.vanity_url, u.server_id, ' . Phpfox::getUserField())
            ->from(':like', 'l')
            ->join(':pages', 'p',
                'p.page_id = l.item_id AND p.view_id = 0 ' . $sCondType)
            ->join(':user', 'u', 'u.profile_page_id = p.page_id')
            ->leftJoin(':pages_url', 'pu', 'pu.page_id = p.page_id')
            ->leftJoin(':photo', 'ph', 'ph.photo_id = p.cover_photo_id')
            ->leftJoin(':pages_type', 'pt', 'p.type_id = pt.type_id')
            ->leftJoin(':pages_category', 'pc', 'p.category_id = pc.category_id')
            ->where($sCondLike . 'l.user_id = ' . (int)Phpfox::getUserId() . $sExtraCond)
            ->group('p.page_id', true)
            ->order('l.time_stamp DESC, RAND()')
            ->limit($iLimit)
            ->execute('getSlaveRows');

        foreach ($aPages as $iKey => $aPage) {
            if ($aPage['item_type'] == 0) {
                $aPages[$iKey]['url'] = Phpfox::getService('pages')->getUrl($aPage['page_id'], $aPage['title'],
                    $aPage['vanity_url']);
            } elseif ($aPage['item_type'] == 1) {
                $aPages[$iKey]['url'] = Phpfox::getService('groups')->getUrl($aPage['page_id'], $aPage['title'],
                    $aPage['vanity_url']);
            }
        }
        return $aPages;
    }

    function getLimitShortcut($iLimit = 15, $sExtraCond)
    {
        if (!Phpfox::isModule('pages') && !Phpfox::isModule('groups')) {
            return false;
        }
        $iCnt = db()->select('count(*)')
            ->from($this->_sTable)
            ->where('owner_id = ' . Phpfox::getUserId())
            ->executeField();
        if ($iCnt > 0) {
            $aItems = $this->getItemIsPin($iLimit, $sExtraCond);
        } else {
            $aItems = $this->getItemsShortcuts($iLimit);
        }
        return $aItems;
    }

    function getItemIsPin($iLimit = 15, $sExtraCond = null)
    {
        $this->insertShortcut();
        $sCondType = '';
        $sCondLike = '';
        if (Phpfox::isModule('pages') && Phpfox::isModule('groups')) {
            $sCondType = ' AND (p.item_type IN (0,1))';
            $sCondLike = '(l.type_id IN (\'groups\', \'pages\')) AND ';
        } else {
            if (Phpfox::isModule('pages')) {
                $sCondType = ' AND p.item_type = ' . Phpfox::getService('pages')->getFacade()->getItemTypeId();
                $sCondLike = 'l.type_id = \'pages\'' . ' AND ';
            } elseif (Phpfox::isModule('groups')) {
                $sCondType = ' AND p.item_type = ' . Phpfox::getService('groups')->getFacade()->getItemTypeId();
                $sCondLike = 'l.type_id = \'groups\'' . ' AND ';
            }
        }
        $aPages = Phpfox::getLib('database')->select('p.*, ys.ordering, ys.is_pin, ys.is_hidden, pt.name as type_name, pc.name as category_name, ph.destination as cover_image_path, ph.server_id as cover_image_server_id, pu.vanity_url, u.server_id, ' . Phpfox::getUserField())
            ->from(':like', 'l')
            ->join(':pages', 'p',
                'p.page_id = l.item_id AND p.view_id = 0 ' . $sCondType)
            ->join(':user', 'u', 'u.profile_page_id = p.page_id')
            ->join($this->_sTable, 'ys', 'ys.page_id = p.page_id AND ' . 'ys.owner_id = ' . Phpfox::getUserId())
            ->leftJoin(':pages_url', 'pu', 'pu.page_id = p.page_id')
            ->leftJoin(':photo', 'ph', 'ph.photo_id = p.cover_photo_id')
            ->leftJoin(':pages_type', 'pt', 'p.type_id = pt.type_id')
            ->leftJoin(':pages_category', 'pc', 'p.category_id = pc.category_id')
            ->where($sCondLike . 'l.user_id = ' . (int)Phpfox::getUserId() . $sExtraCond)
            ->group('p.page_id', true)
            ->order('ys.ordering DESC')
            ->limit($iLimit)
            ->executeRows();
        foreach ($aPages as $iKey => $aPage) {
            if ($aPage['item_type'] == 0) {
                $aPages[$iKey]['url'] = Phpfox::getService('pages')->getUrl($aPage['page_id'], $aPage['title'],
                    $aPage['vanity_url']);
            } elseif ($aPage['item_type'] == 1) {
                $aPages[$iKey]['url'] = Phpfox::getService('groups')->getUrl($aPage['page_id'], $aPage['title'],
                    $aPage['vanity_url']);
            }
        }
        return $aPages;
    }

    function tooglePin($Id, $iPin)
    {
        $iMaxOrder = db()->select('max(ordering) as max')
            ->from($this->_sTable)
            ->where('owner_id = ' . Phpfox::getUserId())
            ->executeField();
        if ($iPin == 1) {
            db()->update($this->_sTable, ['is_pin' => $iPin, 'ordering' => $iMaxOrder + 1],
                ['page_id' => $Id, 'owner_id' => Phpfox::getUserId()]);
        } else {
            db()->update($this->_sTable,
                ['is_pin' => $iPin, 'ordering' => 0],
                ['page_id' => $Id, 'owner_id' => Phpfox::getUserId()]);
        }
        db()->update($this->_sTable, ['is_hidden' => 0], ['page_id' => $Id, 'owner_id' => Phpfox::getUserId()]);

    }

    function toogleHidden($Id)
    {
        db()->update($this->_sTable, ['is_hidden' => 1], ['page_id' => $Id, 'owner_id' => Phpfox::getUserId()]);
        db()->update($this->_sTable, ['is_pin' => 0, 'ordering' => 0],
            ['page_id' => $Id, 'owner_id' => Phpfox::getUserId()]);
    }

    function updateShortcutStatus($aData)
    {
        foreach ($aData as $iKey => $data) {
            $aItem = db()->select('*')
                ->from($this->_sTable)
                ->where('page_id = ' . (int)$data['id'] . ' AND owner_id = ' . Phpfox::getUserId())
                ->executeRow();
            $iMaxOrder = db()->select('max(ordering) as max')
                ->from($this->_sTable)
                ->where('owner_id = ' . Phpfox::getUserId())
                ->executeField();
            if ($data['status'] == 2 && $aItem['is_pin'] == 0) {
                db()->update($this->_sTable, ['is_pin' => 1, 'ordering' => $iMaxOrder + 1],
                    ['page_id' => $data['id'], 'owner_id' => Phpfox::getUserId()]);
                db()->update($this->_sTable, ['is_hidden' => 0], ['page_id' => $data['id'], 'owner_id' => Phpfox::getUserId()]);
            } elseif ($data['status'] == 3) {
                $this->toogleHidden($data['id']);
            } elseif ($data['status'] == 1) {
                db()->update($this->_sTable,
                    ['is_hidden' => 0, 'is_pin' => 0, 'ordering' => 0],
                    ['page_id' => $data['id'], 'owner_id' => Phpfox::getUserId()]);
            }
        }
    }

    public function get(
        $aCond,
        $sSort = 'friend.time_stamp DESC',
        $iPage = '',
        $sLimit = '',
        $bCount = true,
        $bAddDetails = false,
        $bIsOnline = false,
        $iUserId = null,
        $bIncludeList = false,
        $iListId = 0
    ) {
        if (!Phpfox::isModule('friend')) {
            return false;
        }
        $bSuperCache = false;
        $sSuperCacheId = '';
        // Not all calls to this function can be cached in the same way
        if ((Phpfox::getParam('friend.cache_rand_list_of_friends_custom') > 0) &&
            (is_string($aCond) && strpos($aCond, 'friend.is_page = 0 AND friend.user_id = ') !== false) &&
            ($sSort == 'friend.is_top_friend DESC, friend.ordering ASC, RAND()') &&
            ($iPage == 0)
            && ($bIsOnline === false)
        ) {
            $iUserId = str_replace('friend.is_page = 0 AND friend.user_id = ', '', $aCond);
            // the folder name has to be fixed so we can clear it from the add and delete functions
            $sCacheId = $this->cache()->set(array('friend_rand_9', $iUserId));

            $sSuperCacheId = $sCacheId;

            if (($aRows = $this->cache()->get($sCacheId,
                Phpfox::getParam('friend.cache_rand_list_of_friends_custom')))) {
                if (is_bool($aRows)) {
                    return array();
                }

                return $aRows;
            }
            $bSuperCache = true;
        }

        $bIsListView = ((Phpfox_Request::instance()->get('view') == 'list' || (defined('PHPFOX_IS_USER_PROFILE') && Phpfox_Request::instance()->getInt('list'))) ? true : false);
        $iCnt = ($bCount ? 0 : 1);
        $aRows = array();

        if ($sPlugin = \Phpfox_Plugin::get('friend.service_friend_get')) {
            eval($sPlugin);
        }

        if ($bIsOnline) {
            if (is_string($aCond)) {
                $aCond .= ' AND u.is_invisible = 0';
            } elseif (is_array($aCond)) {
                $aCond[] = ' AND u.is_invisible = 0';
            }
        }

        if ($bCount === true) {
            if ($bIsOnline === true) {
                $this->database()->join(Phpfox::getT('log_session'), 'ls',
                    'ls.user_id = friend.friend_user_id AND ls.last_activity > \'' . Phpfox::getService('log.session')->getActiveTime() . '\' AND ls.im_hide = 0');
            }

            if ($iUserId !== null && !empty($iUserId)) {
                $this->database()->innerJoin('(SELECT friend_user_id FROM ' . Phpfox::getT('friend') . ' WHERE is_page = 0 AND user_id = ' . $iUserId . ')',
                    'sf', 'sf.friend_user_id = friend.friend_user_id');
            }

            if ($bIsListView) {
                $this->database()->join(Phpfox::getT('friend_list_data'), 'fld',
                    'fld.friend_user_id = friend.friend_user_id');
                $aCond[] = 'AND friend.user_id = ' . (int)Phpfox::getUserId() . ' AND friend.friend_user_id = fld.friend_user_id';
            }

            if ((int)$iListId > 0) {
                $this->database()->innerJoin(Phpfox::getT('friend_list_data'), 'fld',
                    'fld.list_id = ' . (int)$iListId . ' AND fld.friend_user_id = friend.friend_user_id');
            }

            $iCnt = $this->database()->select('COUNT(DISTINCT u.user_id)')
                ->from($this->_sTable, 'friend')
                ->join(Phpfox::getT('user'), 'u',
                    'u.user_id = friend.friend_user_id AND u.status_id = 0 AND u.view_id = 0')
                ->where($aCond)
                ->execute('getSlaveField');
        }

        if ($iCnt) {
            if ($bAddDetails === true) {
                $this->database()->select('u.status, u.user_id, u.birthday, u.gender, u.country_iso AS location, ');
            }

            if ($bIsOnline === true) {
                $this->database()->select('ls.last_activity, ')->join(Phpfox::getT('log_session'), 'ls',
                    'ls.user_id = friend.friend_user_id AND ls.last_activity > \'' . Phpfox::getService('log.session')->getActiveTime() . '\' AND ls.im_hide = 0');
            }

            if ($iUserId !== null && !empty($iUserId)) {
                $this->database()->innerJoin('(SELECT friend_user_id FROM ' . Phpfox::getT('friend') . ' WHERE is_page = 0 AND user_id = ' . $iUserId . ')',
                    'sf', 'sf.friend_user_id = friend.friend_user_id');
            }

            if ($bIsListView) {
                $this->database()->join(Phpfox::getT('friend_list_data'), 'fld',
                    'fld.friend_user_id = friend.friend_user_id');
                $aCond[] = 'AND friend.user_id = ' . (int)Phpfox::getUserId() . ' AND friend.friend_user_id = fld.friend_user_id';
            }

            if ((int)$iListId > 0) {
                $this->database()->innerJoin(Phpfox::getT('friend_list_data'), 'fld',
                    'fld.list_id = ' . (int)$iListId . ' AND fld.friend_user_id = friend.friend_user_id');
            }
            $aRows = $this->database()->select('uf.total_friend, uf.dob_setting, friend.friend_id, friend.friend_user_id, friend.is_top_friend, friend.time_stamp, ' . Phpfox::getUserField())
                ->from(Phpfox::getT('friend'), 'friend')
                ->join(Phpfox::getT('user'), 'u',
                    'u.user_id = friend.friend_user_id AND u.status_id = 0 AND u.view_id = 0')
                ->join(Phpfox::getT('user_field'), 'uf', 'u.user_id = uf.user_id')
                ->where($aCond)
                ->group('u.user_id', true)
                ->order($sSort)
                ->limit($iPage, $sLimit, $iCnt)
                ->execute('getSlaveRows');

            if ($bAddDetails === true) {
                $oUser = Phpfox::getService('user');
                $oCoreCountry = Phpfox::getService('core.country');
                foreach ($aRows as $iKey => $aRow) {
                    $aBirthDay = Phpfox::getService('user')->getAgeArray($aRow['birthday']);

                    $aRows[$iKey]['month'] = Phpfox::getLib('date')->getMonth($aBirthDay['month']);
                    $aRows[$iKey]['day'] = $aBirthDay['day'];
                    $aRows[$iKey]['year'] = $aBirthDay['year'];
                    $aRows[$iKey]['gender_phrase'] = $oUser->gender($aRow['gender']);
                    $aRows[$iKey]['birthday'] = $oUser->age($aRow['birthday']);
                    $aRows[$iKey]['location'] = $oCoreCountry->getCountry($aRow['location']);

                    (($sPlugin = \Phpfox_Plugin::get('friend.service_friend_get_2')) ? eval($sPlugin) : false);
                }
            }

            if ($bIncludeList) {
                foreach ($aRows as $iKey => $aRow) {
                    $aRows[$iKey]['lists'] = Phpfox::getService('friend.list')->getListForUser($aRow['friend_user_id']);
                }
            }
        }

        if ($bCount === false) {
            if ($bSuperCache == true) {
                $this->cache()->save($sSuperCacheId, $aRows);
            }
            return $aRows;
        }

        return array($iCnt, $aRows);
    }

    function getInfoAbout($userID)
    {
        $aRow = db()->select('*')
            ->from(Phpfox::getT('user_custom'))
            ->where('user_id = ' . $userID)
            ->executeRow();

        return empty($aRow['cf_about_me']) ? '' : $aRow['cf_about_me'];
    }

    function getVideoForProfile($userID)
    {
        if (Phpfox::isModule('v')) {
            $aRows = db()->select('video.*, u.*')
                ->from(Phpfox::getT('video'), 'video')
                ->join(Phpfox::getT('user'), 'u', 'u.user_id = video.user_id')
                ->where('video.in_process = 0 AND video.view_id = 0 AND video.item_id = 0 AND video.privacy IN(0,1,2,3,4) AND video.user_id = ' . $userID)
                ->order('video.time_stamp DESC')
                ->executeRows();
            return $aRows;
        } else {
            return false;
        }

    }

    public function convertImagePath($aRow, $iSize = 500)
    {
        if (Phpfox::isModule('v')) {
            if (isset($aRow['image_server_id']) && $aRow['image_server_id'] == -1 && !empty($aRow['image_path'])) {
                $aRow['image_path'] = setting('pf_video_s3_url') . $aRow['image_path'];
            } elseif (isset($aRow['image_server_id']) && $aRow['image_server_id'] == -2 && !empty($aRow['image_path'])) {
                $aRow['image_path'] = str_replace('dailymotion.com/thumbnail/160x120',
                    'dailymotion.com/thumbnail/640x360',
                    $aRow['image_path']);
            } elseif (empty($aRow['image_path'])) {
                $aRow['image_path'] = Phpfox::getParam('video.default_video_photo');
            } else {
                if (strpos($aRow['image_path'], 'video/') !== 0) { // support V3 video
                    $aRow['image_path'] = 'video/' . $aRow['image_path'];
                }
                $aRow['image_path'] = Phpfox::getLib('image.helper')->display(array(
                        'server_id' => $aRow['image_server_id'],
                        'path' => 'core.url_pic',
                        'file' => $aRow['image_path'],
                        'suffix' => '_' . $iSize,
                        'return_url' => true
                    )
                );
            }
            return $aRow['image_path'];
        } else {
            return false;
        }
    }

    public function countVideos($userID)
    {
        if (Phpfox::isModule('v')) {
            $iCnt = db()->select('count(video.video_id)')
                ->from(Phpfox::getT('video'), 'video')
                ->join(Phpfox::getT('user'), 'u', 'u.user_id = video.user_id')
                ->where('video.in_process = 0 AND video.view_id = 0 AND video.item_id = 0 AND video.privacy IN(0,1,2,3,4) AND video.user_id = ' . $userID)
                ->executeField();
            return $iCnt;
        } else {
            return false;
        }
    }

    public function getTotalLike($id)
    {
        $iTotal = db()->select('total_like')
            ->from(Phpfox::getT('photo'))
            ->where('photo_id = ' . $id)
            ->executeField();
        return $iTotal;
    }

    public function countFriendRequest($userID)
    {
        if (Phpfox::isModule('friend')) {
            $iCnt = db()->select('count(fr.request_id)')
                ->from(Phpfox::getT('friend_request'), 'fr')
                ->where('fr.user_id =' . $userID . ' AND is_ignore = 0')
                ->executeField();
            return $iCnt;
        } else {
            return null;
        }
    }

    public function add($sType, $iItemId, $iUserId = null, $app_id = null, $params = [], $sTablePrefix = '')
    {
        $bIsNotNull = false;
        if ($iUserId === null) {
            $iUserId = Phpfox::getUserId();
            $bIsNotNull = true;
        }
        if ($sType == 'pages') {
            $bIsNotNull = false;
        }

        // check if iUserId can Like this item
        $aFeed = $this->database()->select('*')
            ->from(Phpfox::getT($sTablePrefix . 'feed'))
            ->where(($app_id === null ? 'item_id = ' . (int) $iItemId . ' AND type_id = \'' . Phpfox::getLib('parse.input')->clean($sType) . '\'' : 'feed_id = ' . (int) $iItemId))
            ->execute('getSlaveRow');

        if (!empty($aFeed) && isset($aFeed['privacy']) && !empty($aFeed['privacy']) && !empty($aFeed['user_id']) && $aFeed['user_id'] != $iUserId)
        {
            if (Phpfox::getService('user.block')->isBlocked($iUserId, $aFeed['user_id']))
            {
                return Phpfox_Error::display(_p('you_are_not_allowed_to_like_this_item'));
            }
            if ($aFeed['privacy'] == 1 && Phpfox::isModule('friend') && Phpfox::getService('friend')->isFriend($iUserId, $aFeed['user_id']) != true)
            {
                return Phpfox_Error::display(_p('you_are_not_allowed_to_like_this_item'));
            }
            else if ($aFeed['privacy'] == 2 && Phpfox::isModule('friend') &&  Phpfox::getService('friend')->isFriendOfFriend($iUserId) != true)
            {
                return Phpfox_Error::display(_p('you_are_not_allowed_to_like_this_item'));
            }
            else if ($aFeed['privacy'] == 3 && ($aFeed['user_id'] != Phpfox::getUserId()))
            {
                return Phpfox_Error::display(_p('you_are_not_allowed_to_like_this_item'));
            }
            else if ($aFeed['privacy'] == 4 && ( $bCheck = Phpfox::getService('privacy')->check($sType, $iItemId, $aFeed['user_id'], $aFeed['privacy'], null, true)) != true)
            {
                return Phpfox_Error::display(_p('you_are_not_allowed_to_like_this_item'));
            }
        }

        $iCheck = $this->database()->select('COUNT(*)')
            ->from(Phpfox::getT('like'))
            ->where('type_id = \'' . $this->database()->escape($sType) . '\' AND item_id = ' . (int) $iItemId . ' AND user_id = ' . $iUserId)
            ->execute('getSlaveField');

        if ($iCheck)
        {
            return true;
        }

        //check permission when like an item
        if (empty($params['ignoreCheckPermission']) && Phpfox::isModule($sType) && Phpfox::hasCallback($sType, 'canLikeItem') && !Phpfox::callback($sType . '.canLikeItem', $iItemId))
        {
            return Phpfox_Error::set(_p('you_are_not_allowed_to_like_this_item'));
        }

        $iCnt = (int) $this->database()->select('COUNT(*)')
            ->from(Phpfox::getT('like_cache'))
            ->where('type_id = \'' . $this->database()->escape($sType) . '\' AND item_id = ' . (int) $iItemId . ' AND user_id = ' . (int) $iUserId)
            ->execute('getSlaveField');

        $data = [
            'type_id' => $sType,
            'item_id' => (int) $iItemId,
            'user_id' => $iUserId,
            'time_stamp' => PHPFOX_TIME
        ];

        if ($sType == 'app') {
            $data['feed_table'] = $sTablePrefix . 'feed';
        }
        $this->database()->insert(Phpfox::getT('like'), $data);
        //Update time_update of feed when like
        if (Phpfox::getParam('feed.top_stories_update') != 'comment') {
            $this->database()->update(Phpfox::getT($sTablePrefix . 'feed'), [
                'time_update' => PHPFOX_TIME
            ], [
                    'item_id' => (int)$iItemId,
                    'type_id' => $sType
                ]
            );

            if (!empty($sTablePrefix)) {
                $this->database()->update(Phpfox::getT('feed'), [
                    'time_update' => PHPFOX_TIME
                ], [
                        'item_id' => (int)$iItemId,
                        'type_id' => $sType
                    ]
                );
            }
        }
        if (!$iCnt)
        {
            $this->database()->insert(Phpfox::getT('like_cache'), array(
                    'type_id' => $sType,
                    'item_id' => (int) $iItemId,
                    'user_id' => $iUserId
                )
            );
        }

        Phpfox::getService('feed.process')->clearCache($sType, $iItemId);

        if ($sPlugin = Phpfox_Plugin::get('like.service_process_add__1')){eval($sPlugin);}

        if ($sType == 'app') {
            $app = app($app_id);

            if (isset($app->notifications) && isset($app->notifications->{'__like'})) {
                notify($app->id, '__like', $iItemId, $aFeed['user_id'], false);
            }

            return true;
        }

        Phpfox::callback($sType . '.addLike', $iItemId, ($iCnt ? true : false), ($bIsNotNull ? null : $iUserId));

        return true;
    }

    public function getForEdit($iMenuIcon) {
        $aRow = db()->select('*')
                ->from(Phpfox::getT('menu'))
                ->where('menu_id = ' . $iMenuIcon)
                ->executeRow();
        return $aRow;
    }

    public function updateMenuIcon($iMenuId) {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $sFileName = $this->_processImage();
            if (isset($sFileName)) {
                db()->update(Phpfox::getT('menu'), [
                    'image_path' => $sFileName,
                    'server_id' => \Phpfox_Request::instance()->getServer('PHPFOX_SERVER_ID')
                ], ['menu_id' => $iMenuId]);
                return true;
            }
        }
    }

    private function _processImage()
    {
        // upload image
        $oImage = \Phpfox_Image::instance();
        $oFile = \Phpfox_File::instance();
        $sDirImage = Phpfox::getParam('core.dir_pic') . 'yncfbclone/';
        $oFile->load('image', array('jpg', 'gif', 'png'), (Phpfox::getUserParam('photo.photo_max_upload_size') == 0 ? null : (Phpfox::getUserParam('photo.photo_max_upload_size') / 1024)));

        $sFileName = $oFile->upload('image', $sDirImage, '');
        $iFileSizes = filesize($sDirImage . sprintf($sFileName, ''));

        $iSize = 50;
        $oImage->createThumbnail($sDirImage . sprintf($sFileName, ''),
            $sDirImage . sprintf($sFileName, '_' . $iSize), $iSize, $iSize, false);
        $iFileSizes += filesize($sDirImage . sprintf($sFileName, '_' . $iSize));

        $iSize = 120;
        $oImage->createThumbnail($sDirImage . sprintf($sFileName, ''),
            $sDirImage . sprintf($sFileName, '_' . $iSize), $iSize, $iSize, false);
        $iFileSizes += filesize($sDirImage . sprintf($sFileName, '_' . $iSize));

        $iSize = 200;
        $oImage->createThumbnail($sDirImage . sprintf($sFileName, ''),
            $sDirImage . sprintf($sFileName, '_' . $iSize), $iSize, $iSize, false);
        $iFileSizes += filesize($sDirImage . sprintf($sFileName, '_' . $iSize));

        //Crop max width
        if (Phpfox::isModule('photo')) {
            Phpfox::getService('photo')->cropMaxWidth($sDirImage . sprintf($sFileName, ''));
        }
        // Update user space usage

        return $sFileName;
    }

    public function resetMenuIcon($iMenuId) {
        db()->update(Phpfox::getT('menu'), ['image_path' => '', 'server_id' => 0], ['menu_id' => $iMenuId]);
    }

    public function applySuggestedIcon($iMenuId, $sSuggestedIcon) {
        db()->update(Phpfox::getT('menu'), array(
            'server_id' => -1,
            'image_path' => $sSuggestedIcon,
        ), array('menu_id' => $iMenuId));
    }

    public function getYourPages() {
        if (Phpfox::isModule('pages')) {
            $aRows = $this->database()->select('p.*, pu.vanity_url, ' . Phpfox::getUserField())
                ->from(Phpfox::getT('pages'), 'p')
                ->join(Phpfox::getT('user'), 'u', 'u.profile_page_id = p.page_id')
                ->leftJoin(Phpfox::getT('pages_url'), 'pu', 'pu.page_id = p.page_id')
                ->where(array_merge([
                    'p.user_id' => Phpfox::getUserId(),
                    'p.item_type' => Phpfox::getService('pages')->getFacade()->getItemTypeId()
                ]))
                ->limit(3)
                ->order('RAND()')
                ->execute('getSlaveRows');

            foreach ($aRows as $iKey => $aRow) {
                $aRows[$iKey]['link'] = Phpfox::getService('pages')->getFacade()->getItems()->getUrl($aRow['page_id'], $aRow['title'],
                    $aRow['vanity_url']);
            }

            return $aRows;
        } else {
            return array();
        }
    }

    public function numberPages() {
        if (Phpfox::isModule('pages')) {
            return $this->database()->select('count(*)')->from(Phpfox::getT('pages'))
                ->where(array_merge([
                    'user_id' => Phpfox::getUserId(),
                    'item_type' => Phpfox::getService('pages')->getFacade()->getItemTypeId()
                ]))
                ->executeField();
        }
    }

    public function getFriendContact()
    {
        $aUsers = db()->select('f.user_id')
            ->from(Phpfox::getT('user'), 'u')
            ->join(Phpfox::getT('friend'), 'f', 'f.friend_user_id = u.user_id')
            ->where('f.is_page = 0 AND u.status_id = 0 AND u.view_id = 0 AND u.user_id = ' . Phpfox::getUserId())
            ->limit(15)
            ->order('u.last_activity DESC')
            ->executeRows();
        foreach ($aUsers as $iKey => $aUser) {
            $aUsers[$iKey] = db()->select('*')
                ->from(Phpfox::getT('user'), 'u')
                ->where('u.user_id='.$aUser['user_id'])
                ->executeRow();
            $this->processOnlineStatus($aUsers[$iKey]);
        }

        foreach ($aUsers as $key => $row)
        {
            $temp[$key] = $row['last_activity'];
        }
        array_multisort($temp, SORT_DESC, $aUsers);
        return $aUsers;
    }

    public function processOnlineStatus(&$aRow)
    {
        $iActiveSession = PHPFOX_TIME - (Phpfox::getParam('log.active_session') * 60);
        $sSessionTable = $this->getSessionTable();

        $aOnlineRow = $this->database()->select('*')
            ->from($sSessionTable)
            ->where($sSessionTable . '.user_id = ' . $aRow['user_id'] . ' AND last_activity > ' . $iActiveSession . ' AND im_hide = 0')
            ->executeRow();

        return $aRow['is_online'] = $aOnlineRow ? 1 : 0;
    }

    public function getSessionTable()
    {
        $sSessionTable = Phpfox::getParam('core.store_only_users_in_session') ? Phpfox::getT('session') : Phpfox::getT('log_session');
        return $sSessionTable;
    }

    public function getUsersFromCache($sUserSearch = false, $iLimit = 15)
    {
        if ($sUserSearch != false) {
            $aRows = db()->select('' . Phpfox::getUserField())
                ->from(Phpfox::getT('friend'), 'friend')
                ->join(Phpfox::getT('user'), 'u', 'u.user_id = friend.friend_user_id AND u.status_id = 0 AND u.view_id = 0')
                ->join(Phpfox::getT('user_field'), 'uf', 'u.user_id = uf.user_id')
                ->where('u.full_name LIKE "%' . Phpfox::getLib('parse.input')->clean($sUserSearch) . '%" AND friend.is_page = 0 AND friend.user_id =' . Phpfox::getUserId() )
                ->limit($iLimit)
                ->order('u.last_activity DESC')
                ->group('u.user_id')
                ->executeRows();
        } else {
            $aRows = db()->select(''. Phpfox::getUserField())
                ->from(Phpfox::getT('friend'), 'friend')
                ->join(Phpfox::getT('user'), 'u', 'u.user_id = friend.friend_user_id AND u.status_id = 0 AND u.view_id = 0')
                ->join(Phpfox::getT('user_field'), 'uf', 'u.user_id = uf.user_id')
                ->where('friend.is_page = 0 AND friend.user_id =' . Phpfox::getUserId() )
                ->limit($iLimit)
                ->order('u.last_activity DESC')
                ->group('u.user_id')
                ->executeRows();
        }

        foreach ($aRows as $iKey => $aRow) {
            $aRows[$iKey]['full_name'] = html_entity_decode(Phpfox::getLib('parse.output')->split($aRow['full_name'],
                20), null, 'UTF-8');
            $aRows[$iKey]['user_profile'] = ($aRow['profile_page_id'] ? Phpfox::getService('pages')->getUrl($aRow['profile_page_id'],
                '', $aRow['user_name']) : Phpfox::getLib('url')->makeUrl($aRow['user_name']));
            $aRows[$iKey]['is_page'] = ($aRow['profile_page_id'] ? true : false);
            $aRows[$iKey]['user_image'] = Phpfox::getLib('image.helper')->display(array(
                    'user' => $aRow,
                    'suffix' => '_50_square',
                    'max_height' => 50,
                    'max_width' => 50,
                    'return_url' => true
                )
            );
            $aRows[$iKey]['has_image'] = isset($aRow['user_image']) && $aRow['user_image'];
            $aRows[$iKey]['url_link'] = \Phpfox_Url::instance()->makeUrl($aRow['user_name']);
            $this->processOnlineStatus($aRows[$iKey]);
            if (Phpfox::isModule('mail') && Phpfox::getService('user.privacy')->hasAccess('' . $aRow['user_id'] . '', 'mail.send_message')) {
                $aRows[$iKey]['send_mess'] = 1;
            }else {
                $aRows[$iKey]['send_mess'] = 0;
            }
            $aRows[$iKey]['is_friend'] = Phpfox::getService('friend')->isFriend(Phpfox::getUserId(), $aRow['user_id']) ? 1 : 0;
            if ($aRows[$iKey]['is_friend'] == 0) {
                unset($aRows[$iKey]);
            }
        }

        return $aRows;
    }

    public function getUsersFriendFromCache($sUserSearch = false, $iLimit = 20, $iId)
    {
        if ($sUserSearch != false) {
            $aRows = db()->select('uf.total_friend, uf.dob_setting, friend.friend_id, friend.friend_user_id, friend.is_top_friend, friend.time_stamp, ' . Phpfox::getUserField())
                ->from(Phpfox::getT('friend'), 'friend')
                ->join(Phpfox::getT('user'), 'u', 'u.user_id = friend.friend_user_id AND u.status_id = 0 AND u.view_id = 0')
                ->join(Phpfox::getT('user_field'), 'uf', 'u.user_id = uf.user_id')
                ->where('u.full_name LIKE "%' . Phpfox::getLib('parse.input')->clean($sUserSearch) . '%" AND friend.is_page = 0 AND friend.user_id =' . $iId )
                ->limit($iLimit)
                ->order('u.last_activity DESC')
                ->group('u.user_id')
                ->executeRows();
        } else {
            $aRows = db()->select('uf.total_friend, uf.dob_setting, friend.friend_id, friend.friend_user_id, friend.is_top_friend, friend.time_stamp, ' . Phpfox::getUserField())
                ->from(Phpfox::getT('friend'), 'friend')
                ->join(Phpfox::getT('user'), 'u', 'u.user_id = friend.friend_user_id AND u.status_id = 0 AND u.view_id = 0')
                ->join(Phpfox::getT('user_field'), 'uf', 'u.user_id = uf.user_id')
                ->where('friend.is_page = 0 AND friend.user_id =' . $iId )
                ->limit($iLimit)
                ->order('u.last_activity DESC')
                ->group('u.user_id')
                ->executeRows();
        }

        foreach ($aRows as $iKey => $aRow) {
            $aRows[$iKey]['full_name'] = html_entity_decode(Phpfox::getLib('parse.output')->split($aRow['full_name'],
                20), null, 'UTF-8');
            $aRows[$iKey]['user_profile'] = ($aRow['profile_page_id'] ? Phpfox::getService('pages')->getUrl($aRow['profile_page_id'],
                '', $aRow['user_name']) : Phpfox::getLib('url')->makeUrl($aRow['user_name']));
            $aRows[$iKey]['is_page'] = ($aRow['profile_page_id'] ? true : false);
            $aRows[$iKey]['user_image'] = Phpfox::getLib('image.helper')->display(array(
                    'user' => $aRow,
                    'suffix' => '_120_square',
                    'max_height' => 120,
                    'max_width' => 120,
                    'return_url' => true
                )
            );
            $aRows[$iKey]['has_image'] = isset($aRow['user_image']) && $aRow['user_image'];
            $aRows[$iKey]['url_link'] = \Phpfox_Url::instance()->makeUrl($aRow['user_name']);
            $this->processOnlineStatus($aRows[$iKey]);
            if (Phpfox::isModule('mail') && Phpfox::getService('user.privacy')->hasAccess('' . $aRow['user_id'] . '', 'mail.send_message')) {
                $aRows[$iKey]['send_mess'] = 1;
            }else {
                $aRows[$iKey]['send_mess'] = 0;
            }
            $aRows[$iKey]['is_friend'] = Phpfox::getService('friend')->isFriend(Phpfox::getUserId(), $aRow['user_id']) ? 1 : 0;
            if (!$aRows[$iKey]['is_friend']) {
                $aRows[$iKey]['is_friend'] = (Phpfox::getService('friend.request')->isRequested(Phpfox::getUserId(), $aRow['user_id']) ? 2 : false);
            }
            if (Phpfox::isUser() && $aRow['user_id'] != Phpfox::getUserId()) {
                $aRows[$iKey]['show_dropdown'] = 1;
            }else {
                $aRows[$iKey]['show_dropdown'] = 0;
            }
            $aRows[$iKey]['request_id'] = db()->select('request_id')->from(Phpfox::getT('friend_request'))->where('user_id =' . $aRow['user_id'] .' AND friend_user_id='.Phpfox::getUserId())->executeField();
            $aRows[$iKey]['is_friend_request'] = db()->select('request_id')->from(Phpfox::getT('friend_request'))->where('user_id =' . Phpfox::getUserId() .' AND friend_user_id='.$aRow['user_id'])->executeField();
            $aRows[$iKey]['can_add_friend'] = Phpfox::getUserParam('friend.can_add_friends');

            if ($aRows[$iKey]['request_id'] > 0) {
                $aRows[$iKey]['request_link'] = \Phpfox_Url::instance()->makeUrl('friend.pending', ['id' => $aRows[$iKey]['request_id']]);
            }
        }

        return $aRows;
    }

    public function getUsersMutualFriendFromCache($sUserSearch = false, $iLimit = 20, $iUserId)
    {
        $sExtra1 = '';
        $sExtra2 = '';

        if ($sPlugin = Phpfox_Plugin::get('friend.service_friend_getmutualfriends'))
        {
            eval($sPlugin);
        }
        if ($sUserSearch != false) {
            $aRows = $this->database()->select('uf.total_friend, ' . Phpfox::getUserField())
                ->from(Phpfox::getT('friend'), 'f')
                ->join(Phpfox::getT('friend'), 'sf',
                    'sf.friend_user_id = f.friend_user_id AND sf.user_id = ' . (int)$iUserId . $sExtra1)
                ->join(Phpfox::getT('user'), 'u', 'u.user_id = f.friend_user_id')
                ->join(Phpfox::getT('user_field'), 'uf', 'u.user_id = uf.user_id')
                ->where('u.full_name LIKE "%' . Phpfox::getLib('parse.input')->clean($sUserSearch) . '%" AND f.is_page = 0 AND f.user_id = ' . Phpfox::getUserId() . $sExtra2)
                ->group('f.friend_user_id', true)
                ->order('f.time_stamp DESC')
                ->limit($iLimit)
                ->execute('getSlaveRows');
        }else {
            $aRows = $this->database()->select('uf.total_friend, ' . Phpfox::getUserField())
                ->from(Phpfox::getT('friend'), 'f')
                ->join(Phpfox::getT('friend'), 'sf',
                    'sf.friend_user_id = f.friend_user_id AND sf.user_id = ' . (int)$iUserId . $sExtra1)
                ->join(Phpfox::getT('user'), 'u', 'u.user_id = f.friend_user_id')
                ->join(Phpfox::getT('user_field'), 'uf', 'u.user_id = uf.user_id')
                ->where('f.is_page = 0 AND f.user_id = ' . Phpfox::getUserId() . $sExtra2)
                ->group('f.friend_user_id', true)
                ->order('f.time_stamp DESC')
                ->limit($iLimit)
                ->execute('getSlaveRows');
        }

        foreach ($aRows as $iKey => $aRow) {
            $aRows[$iKey]['full_name'] = html_entity_decode(Phpfox::getLib('parse.output')->split($aRow['full_name'],
                20), null, 'UTF-8');
            $aRows[$iKey]['user_profile'] = ($aRow['profile_page_id'] ? Phpfox::getService('pages')->getUrl($aRow['profile_page_id'],
                '', $aRow['user_name']) : Phpfox::getLib('url')->makeUrl($aRow['user_name']));
            $aRows[$iKey]['is_page'] = ($aRow['profile_page_id'] ? true : false);
            $aRows[$iKey]['user_image'] = Phpfox::getLib('image.helper')->display(array(
                    'user' => $aRow,
                    'suffix' => '_120_square',
                    'max_height' => 120,
                    'max_width' => 120,
                    'return_url' => true
                )
            );
            $aRows[$iKey]['has_image'] = isset($aRow['user_image']) && $aRow['user_image'];
            $aRows[$iKey]['url_link'] = \Phpfox_Url::instance()->makeUrl($aRow['user_name']);
            $this->processOnlineStatus($aRows[$iKey]);
            if (Phpfox::isModule('mail') && Phpfox::getService('user.privacy')->hasAccess('' . $aRow['user_id'] . '', 'mail.send_message')) {
                $aRows[$iKey]['send_mess'] = 1;
            }else {
                $aRows[$iKey]['send_mess'] = 0;
            }
            $aRows[$iKey]['is_friend'] = Phpfox::getService('friend')->isFriend(Phpfox::getUserId(), $aRow['user_id']) ? 1 : 0;
            if (!$aRows[$iKey]['is_friend']) {
                $aRows[$iKey]['is_friend'] = (Phpfox::getService('friend.request')->isRequested(Phpfox::getUserId(), $aRow['user_id']) ? 2 : false);
            }
            if (Phpfox::isUser() && $aRow['user_id'] != Phpfox::getUserId()) {
                $aRows[$iKey]['show_dropdown'] = 1;
            }else {
                $aRows[$iKey]['show_dropdown'] = 0;
            }
            $aRows[$iKey]['request_id'] = db()->select('request_id')->from(Phpfox::getT('friend_request'))->where('user_id =' . $aRow['user_id'] .' AND friend_user_id='.Phpfox::getUserId())->executeField();
            $aRows[$iKey]['is_friend_request'] = db()->select('request_id')->from(Phpfox::getT('friend_request'))->where('user_id =' . Phpfox::getUserId() .' AND friend_user_id='.$aRow['user_id'])->executeField();
            $aRows[$iKey]['can_add_friend'] = Phpfox::getUserParam('friend.can_add_friends');

            if ($aRows[$iKey]['request_id'] > 0) {
                $aRows[$iKey]['request_link'] = \Phpfox_Url::instance()->makeUrl('friend.pending', ['id' => $aRows[$iKey]['request_id']]);
            }
        }

        return $aRows;
    }
}