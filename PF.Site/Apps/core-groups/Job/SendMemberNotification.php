<?php

namespace Apps\PHPfox_Groups\Job;

use Core\Queue\JobAbstract;
use Phpfox;

/**
 * Class SendMemberNotification
 *
 * @package Apps\PHPfox_Groups\Job
 */
class SendMemberNotification extends JobAbstract
{
    /**
     * @inheritdoc
     */
    public function perform()
    {
        $aParams = $this->getParams();

        if (empty($aParams['owner_id'])) {
            $this->delete();

            return;
        }

        $aOwner = Phpfox::getService('user')->getUser($aParams['owner_id']);
        $aGroupPerms = Phpfox::getService('groups')->getPermsForPage($aParams['page_id']);
        $iPerm = isset($aGroupPerms[$aParams['item_perm']]) ? $aGroupPerms[$aParams['item_perm']] : 0;
        $aGroup = Phpfox::getService('groups')->getPage($aParams['page_id']);
        $sGroupLink = Phpfox::getService('groups')->getUrl($aGroup['page_id'], $aGroup['title'], $aGroup['vanity_url']);

        if (!empty($aParams['item_type']) && Phpfox::hasCallback($aParams['item_type'], 'getLink')) {
            $params = [
                'item_id' => $aParams['item_id'],
            ];
            //Check special case when core-music use item_type only music instead of music_song
            if (in_array($aParams['item_type'], ['music'])) {
                $params['section'] = 'song';
            }
            $sItemLink = Phpfox::callback($aParams['item_type'] . '.getLink', $params);
        } else {
            $sItemLink = $sGroupLink;
            if (!empty($moduleArray = explode('_', $aParams['item_type'])) && !empty($moduleArray[0])) {
                $sItemLink = rtrim($sItemLink, '/') . '/' . $moduleArray[0];
            }
        }
        if ($iPerm == 2) {
            $aUsers = Phpfox::getService('groups')->getPageAdmins($aParams['page_id']);
        } else {
            list(, $aUsers) = Phpfox::getService('groups')->getMembers($aParams['page_id']);
        }

        foreach ($aUsers as $aUser) {
            // do not send notification to owner if owner upload photo
            if (isset($aParams['owner_id']) && ($aUser['user_id'] == $aParams['owner_id'])) {
                continue;
            }
            // send notification
            Phpfox::getService('notification.process')->add($aParams['item_type'] . '_newItem_groups',
                $aParams['item_id'], $aUser['user_id'], $aParams['owner_id']);
            // send email
            Phpfox::getLib('mail')->to($aUser['user_id'])
                ->subject(['full_name_post_some_items_on_your_group_title_replacement', [
                    'full_name' => $aOwner['full_name'],
                    'title' => $aGroup['title'],
                    'items' => $aParams['items_phrase']
                ]])
                ->message(['full_name_post_some_items_on_your_group_title_link_replacement', [
                    'full_name' => $aOwner['full_name'],
                    'link' => $sGroupLink,
                    'title' => $aGroup['title'],
                    'items' => $aParams['items_phrase'],
                    'item_link' => $sItemLink,
                ]])
                ->notification('comment.add_new_comment')
                ->send();
        }

        $this->delete();
    }
}
