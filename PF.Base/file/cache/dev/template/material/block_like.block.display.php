<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 25, 2020, 7:50 pm */ ?>
<?php
    
?>

<?php if (isset ( $this->_aVars['ajaxLoadLike'] ) && $this->_aVars['ajaxLoadLike']): ?>
<div id="js_like_body_<?php echo $this->_aVars['aFeed']['feed_id']; ?>">
<?php endif; ?>
<?php if (! empty ( $this->_aVars['aFeed']['feed_like_phrase'] )): ?>
        <div class="activity_like_holder" id="activity_like_holder_<?php echo $this->_aVars['aFeed']['feed_id']; ?>">
<?php echo $this->_aVars['aFeed']['feed_like_phrase']; ?>
        </div>
<?php else: ?>
        <div class="activity_like_holder activity_not_like">
<?php echo _p('when_not_like'); ?>
        </div>
<?php endif; ?>
<?php if (isset ( $this->_aVars['ajaxLoadLike'] ) && $this->_aVars['ajaxLoadLike']): ?>
</div>
<?php endif; ?>

