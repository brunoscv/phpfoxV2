<?php
defined('PHPFOX') or exit('NO DICE!');

if ($aFeed['type_id'] == 'groups_comment' && $aFeed['item_id']) {
    db()->delete(':pages_feed', ['type_id' => 'groups_comment', 'item_id' => $aFeed['item_id']]);
    db()->delete(':pages_feed_comment', ['feed_comment_id' => $aFeed['item_id']]);
}
