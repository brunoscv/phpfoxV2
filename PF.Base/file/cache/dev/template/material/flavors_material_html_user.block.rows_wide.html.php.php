<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:50 pm */ ?>
<?php

?>
<div class="item-outer">
    <div class="item-inner">
        <div class="item-media">
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('user' => $this->_aVars['aUser'],'suffix' => '_200_square','max_width' => 200,'max_height' => 200)); ?>
        </div>
        <div class="user-info">
            <div class="user-title">
<?php echo '<span class="user_profile_link_span" id="js_user_name_link_' . Phpfox::getService('user')->getUserName($this->_aVars['aUser']['user_id'], $this->_aVars['aUser']['user_name']) . '">' . (Phpfox::getService('user.block')->isBlocked(null, $this->_aVars['aUser']['user_id']) ? '' : '<a href="' . Phpfox::getLib('phpfox.url')->makeUrl('profile', array($this->_aVars['aUser']['user_name'], ((empty($this->_aVars['aUser']['user_name']) && isset($this->_aVars['aUser']['profile_page_id'])) ? $this->_aVars['aUser']['profile_page_id'] : null))) . '">') . '' . Phpfox::getLib('phpfox.parse.output')->shorten(Phpfox::getLib('parse.output')->clean(Phpfox::getService('user')->getCurrentName($this->_aVars['aUser']['user_id'], $this->_aVars['aUser']['full_name'])), 0) . '' . (Phpfox::getService('user.block')->isBlocked(null, $this->_aVars['aUser']['user_id']) ? '' : '</a>') . '</span>'; ?>
            </div>
<?php Phpfox::getBlock('user.friendship', array('friend_user_id' => $this->_aVars['aUser']['user_id'],'type' => 'icon','extra_info' => true,'no_button' => true,'mutual_list' => true)); ?>
<?php Phpfox::getBlock('user.info', array('friend_user_id' => $this->_aVars['aUser']['user_id'],'number_of_info' => '2')); ?>

<?php if (Phpfox ::getUserParam('user.can_feature')): ?>
            <div class="dropdown admin-actions">
                <a href="" data-toggle="dropdown" class="btn btn-sm s-4">
                    <span class="ico ico-gear-o"></span>
                </a>

                <ul class="dropdown-menu dropdown-menu-right">
                    <li <?php if (! isset ( $this->_aVars['aUser']['is_featured'] ) || ( isset ( $this->_aVars['aUser']['is_featured'] ) && ! $this->_aVars['aUser']['is_featured'] )): ?> style="display:none;" <?php endif; ?> class="user_unfeature_member">
                    <a href="#" title="<?php echo _p('un_feature_this_member'); ?>" onclick="$(this).parent().hide(); $(this).parents('.dropdown-menu').find('.user_feature_member:first').show(); $.ajaxCall('user.feature', 'user_id=<?php echo $this->_aVars['aUser']['user_id']; ?>&amp;feature=0&amp;type=1&reload=1'); return false;"><span class="ico ico-diamond-o mr-1"></span><?php echo _p('unfeature'); ?></a>
                    </li>
                    <li <?php if (isset ( $this->_aVars['aUser']['is_featured'] ) && $this->_aVars['aUser']['is_featured']): ?> style="display:none;" <?php endif; ?> class="user_feature_member">
                    <a href="#" title="<?php echo _p('feature_this_member'); ?>" onclick="$(this).parent().hide(); $(this).parents('.dropdown-menu').find('.user_unfeature_member:first').show(); $.ajaxCall('user.feature', 'user_id=<?php echo $this->_aVars['aUser']['user_id']; ?>&amp;feature=1&amp;type=1&reload=1'); return false;"><span class="ico ico-diamond-o mr-1"></span><?php echo _p('feature'); ?></a>
                    </li>
                </ul>
            </div>
<?php endif; ?>
        </div>
<?php if (Phpfox ::isUser() && $this->_aVars['aUser']['user_id'] != Phpfox ::getUserId()): ?>
        <div class="dropup friend-actions js_friend_actions_<?php echo $this->_aVars['aUser']['user_id']; ?>">
            <?php
						Phpfox::getLib('template')->getBuiltFile('user.block.friend-action');
						?>
        </div>
<?php endif; ?>
    </div>
<?php if (isset ( $this->_aVars['aUser']['is_featured'] ) && $this->_aVars['aUser']['is_featured']): ?>
    <div class="item-featured" title="<?php echo _p('featured'); ?>">
        <span class="ico ico-diamond"></span>
    </div>
<?php endif; ?>
</div>
