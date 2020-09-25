<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 25, 2020, 7:50 pm */ ?>
<?php
    
?>
<a role="button" title="<?php if ($this->_aVars['aLike']['like_is_liked']):  echo _p('unlike');  else:  echo _p('like');  endif; ?>"
   data-toggle="like_toggle_cmd"
   data-label1="<?php echo _p('like'); ?>"
   data-label2="<?php echo _p('unlike'); ?>"
   data-liked="<?php if ($this->_aVars['aLike']['like_is_liked']): ?>1<?php else: ?>0<?php endif; ?>"
   data-type_id="<?php echo $this->_aVars['aLike']['like_type_id']; ?>"
   data-item_id="<?php echo $this->_aVars['aLike']['like_item_id']; ?>"
   data-feed_id="<?php if (isset ( $this->_aVars['aFeed']['feed_id'] )):  echo $this->_aVars['aFeed']['feed_id'];  else: ?>0<?php endif; ?>"
   data-is_custom="<?php if ($this->_aVars['aLike']['like_is_custom']): ?>1<?php else: ?>0<?php endif; ?>"
   data-table_prefix="<?php if (isset ( $this->_aVars['aFeed']['feed_table_prefix'] )):  echo $this->_aVars['aFeed']['feed_table_prefix'];  elseif (defined ( 'PHPFOX_IS_PAGES_VIEW' ) && defined ( 'PHPFOX_PAGES_ITEM_TYPE' )): ?>pages_<?php endif; ?>"
   class="js_like_link_toggle <?php if ($this->_aVars['aLike']['like_is_liked']): ?>liked<?php else: ?>unlike<?php endif; ?>">
<?php if ($this->_aVars['aLike']['like_is_liked']): ?>
        <span><?php echo _p('unlike'); ?></span>
<?php else: ?>
        <span><?php echo _p('like'); ?></span>
<?php endif; ?>
</a>

