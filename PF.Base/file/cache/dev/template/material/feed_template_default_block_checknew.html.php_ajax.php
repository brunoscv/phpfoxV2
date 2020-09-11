<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:20 pm */ ?>
<?php

?>
<div id="feed_check_new_count" class="hide">
    <div class="btn-info">
    <div id="feed_check_new_count_link" onclick="loadNewFeeds()"><?php echo _p('you_have_number_updates', array('number' => $this->_aVars['iCnt'])); ?></div></div>
    <script>$Core.checkNewFeedAfter(<?php echo $this->_aVars['aFeedIds']; ?>);</script>
</div>
