<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 7:53 pm */ ?>
<?php

?>

<?php if (! isset ( $this->_aVars['sHidden'] )):  $this->assign('sHidden', '');  endif; ?>

<?php if (( isset ( $this->_aVars['sHeader'] ) && ( ! PHPFOX_IS_AJAX || isset ( $this->_aVars['bPassOverAjaxCall'] ) || isset ( $this->_aVars['bIsAjaxLoader'] ) ) ) || ( defined ( "PHPFOX_IN_DESIGN_MODE" ) && PHPFOX_IN_DESIGN_MODE )): ?>

<div class="<?php echo $this->_aVars['sHidden']; ?> block<?php if (( defined ( 'PHPFOX_IN_DESIGN_MODE' ) ) && ( ! isset ( $this->_aVars['bCanMove'] ) || ( isset ( $this->_aVars['bCanMove'] ) && $this->_aVars['bCanMove'] == true ) )): ?> js_sortable<?php endif;  if (isset ( $this->_aVars['sCustomClassName'] )): ?> <?php echo $this->_aVars['sCustomClassName'];  endif; ?>"<?php if (isset ( $this->_aVars['sBlockBorderJsId'] )): ?> id="js_block_border_<?php echo $this->_aVars['sBlockBorderJsId']; ?>"<?php endif;  if (defined ( 'PHPFOX_IN_DESIGN_MODE' ) && Phpfox_Module ::instance()->blockIsHidden('js_block_border_' . $this->_aVars['sBlockBorderJsId'] . '' )): ?> style="display:none;"<?php endif; ?> data-toggle="<?php echo $this->_aVars['sToggleWidth']; ?>">
<?php if (! empty ( $this->_aVars['sHeader'] ) || ( defined ( "PHPFOX_IN_DESIGN_MODE" ) && PHPFOX_IN_DESIGN_MODE )): ?>
		<div class="title <?php if (defined ( 'PHPFOX_IN_DESIGN_MODE' )): ?>js_sortable_header<?php endif; ?>">
<?php if (isset ( $this->_aVars['sBlockTitleBar'] )): ?>
<?php echo $this->_aVars['sBlockTitleBar']; ?>
<?php endif; ?>
<?php if (( isset ( $this->_aVars['aEditBar'] ) && Phpfox ::isUser())): ?>
			<div class="js_edit_header_bar">
				<a href="#" title="<?php echo _p('edit_this_block'); ?>" onclick="$.ajaxCall('<?php echo $this->_aVars['aEditBar']['ajax_call']; ?>', 'block_id=<?php echo $this->_aVars['sBlockBorderJsId'];  if (isset ( $this->_aVars['aEditBar']['params'] )):  echo $this->_aVars['aEditBar']['params'];  endif; ?>'); return false;">
					<span class="ico ico-pencilline-o"></span>
				</a>
			</div>
<?php endif; ?>
<?php if (empty ( $this->_aVars['sHeader'] )): ?>
<?php echo $this->_aVars['sBlockShowName']; ?>
<?php else: ?>
<?php echo $this->_aVars['sHeader']; ?>
<?php endif; ?>
		</div>
<?php endif; ?>
<?php if (isset ( $this->_aVars['aEditBar'] )): ?>
	<div id="js_edit_block_<?php echo $this->_aVars['sBlockBorderJsId']; ?>" class="edit_bar hidden"></div>
<?php endif; ?>
<?php if (isset ( $this->_aVars['aMenu'] ) && count ( $this->_aVars['aMenu'] )): ?>
<?php unset($this->_aVars['aMenu']); ?>
<?php endif; ?>
	<div class="content"<?php if (isset ( $this->_aVars['sBlockJsId'] )): ?> id="js_block_content_<?php echo $this->_aVars['sBlockJsId']; ?>"<?php endif; ?>>
<?php endif; ?>
		<?php

?>
<div class="yncfbclone-contact-list-container">
<div class="js_yncfbclone_search_user_list"></div>
<?php if (count ( $this->_aVars['aUsers'] )): ?>
<ul class="user_rows_mini core-friend-block friend-online-block js_yncfbclone_block_contact">
<?php if (count((array)$this->_aVars['aUsers'])):  $this->_aPhpfoxVars['iteration']['friend'] = 0;  foreach ((array) $this->_aVars['aUsers'] as $this->_aVars['aFriend']):  $this->_aPhpfoxVars['iteration']['friend']++; ?>

    <li class="user_rows">
        <div class="user_rows_image" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->_aVars['aFriend']['full_name']; ?>">
<?php if (Phpfox ::isModule('mail') && User_Service_Privacy_Privacy ::instance()->hasAccess('' . $this->_aVars['aFriend']['user_id'] . '' , 'mail.send_message' )): ?>
            <a href="#" onclick="$Core.composeMessage({user_id: <?php echo $this->_aVars['aFriend']['user_id']; ?>}); return false;">
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('user' => $this->_aVars['aFriend'],'suffix' => '_50_square','width' => 32,'height' => 32,'class' => "img-responsive",'title' => $this->_aVars['aFriend']['full_name'],'no_link' => true)); ?>
            </a>
<?php else: ?>
            <a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl($this->_aVars['aFriend']['user_name']); ?>" class="ajax_link">
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('user' => $this->_aVars['aFriend'],'suffix' => '_50_square','width' => 32,'height' => 32,'class' => "img-responsive",'title' => $this->_aVars['aFriend']['full_name'],'no_link' => true)); ?>
            </a>
<?php endif; ?>
        </div>
        <div class="user_rows_name" style="display: none;">
<?php if (Phpfox ::isModule('mail') && User_Service_Privacy_Privacy ::instance()->hasAccess('' . $this->_aVars['aFriend']['user_id'] . '' , 'mail.send_message' )): ?>
            <a href="#" onclick="$Core.composeMessage({user_id: <?php echo $this->_aVars['aFriend']['user_id']; ?>}); return false;">
<?php echo $this->_aVars['aFriend']['full_name']; ?>
            </a>
<?php else: ?>
            <a class="ajax_link" href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl($this->_aVars['aFriend']['user_name']); ?>"><?php echo $this->_aVars['aFriend']['full_name']; ?></a>
<?php endif; ?>
        </div>
<?php if ($this->_aVars['aFriend']['is_online'] == 1): ?>
            <span class="js_yncfbclone_friend_active"></span>
<?php endif; ?>
    </li>
<?php endforeach; endif; ?>
</ul>
<?php else: ?>
<div class="extra_info js_yncfbclone_extra">
<?php echo _p('no_friends_found'); ?>
</div>
<?php endif; ?>
</div>
<div class="input-group fbclone-contact-search-wrapper">
    <div class="input-group-addon">
        <button onclick="$Core.autoSuggestFriends.getUsersList($('.js_yncfbclone_search_user'));" class="btn btn-sm" aria-hidden="true">
            <span class="ico ico-search-o"></span>
        </button>
    </div>
    <input type="text" class="js_yncfbclone_search_user form-control input-sm" placeholder="<?php echo _p('Search'); ?>">
    <div class="input-group-addon">
<?php if (Phpfox ::getUserParam('mail.can_compose_message')): ?>
        <a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('mail.compose'); ?>" title="<?php echo _p('compose'); ?>" class="popup btn-compose">
            <i class="ico ico-compose"></i>
        </a>
<?php endif; ?>
    </div>
</div>

<?php echo '
<script>
    $Behavior.yncfbclone_init_search_friend = function () {
        $Core.autoSuggestFriends.init({
            \'sCurrentSearchId\': \'js_yncfbclone_search_user\',
            \'sCurrentUsersListId\': \'js_yncfbclone_search_user_list\'
        });
    }
</script>
'; ?>




<?php if (( isset ( $this->_aVars['sHeader'] ) && ( ! PHPFOX_IS_AJAX || isset ( $this->_aVars['bPassOverAjaxCall'] ) || isset ( $this->_aVars['bIsAjaxLoader'] ) ) ) || ( defined ( "PHPFOX_IN_DESIGN_MODE" ) && PHPFOX_IN_DESIGN_MODE )): ?>
	</div>
<?php if (isset ( $this->_aVars['aFooter'] ) && count ( $this->_aVars['aFooter'] )): ?>
	<div class="bottom">
<?php if (count ( $this->_aVars['aFooter'] ) == 1): ?>
<?php if (count((array)$this->_aVars['aFooter'])):  $this->_aPhpfoxVars['iteration']['block'] = 0;  foreach ((array) $this->_aVars['aFooter'] as $this->_aVars['sPhrase'] => $this->_aVars['sLink']):  $this->_aPhpfoxVars['iteration']['block']++; ?>

<?php if ($this->_aVars['sLink'] == '#'): ?>
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('theme' => 'ajax/add.gif','class' => 'ajax_image')); ?>
<?php endif; ?>
<?php if (is_array ( $this->_aVars['sLink'] )): ?>
            <a class="btn btn-block <?php if (! empty ( $this->_aVars['sLink']['class'] )): ?> <?php echo $this->_aVars['sLink']['class'];  endif; ?>" href="<?php if (! empty ( $this->_aVars['sLink']['link'] )):  echo $this->_aVars['sLink']['link'];  else: ?>#<?php endif; ?>" <?php if (! empty ( $this->_aVars['sLink']['attr'] )):  echo $this->_aVars['sLink']['attr'];  endif; ?> id="js_block_bottom_link_<?php echo $this->_aPhpfoxVars['iteration']['block']; ?>"><?php echo $this->_aVars['sPhrase']; ?></a>
<?php else: ?>
            <a class="btn btn-block" href="<?php echo $this->_aVars['sLink']; ?>" id="js_block_bottom_link_<?php echo $this->_aPhpfoxVars['iteration']['block']; ?>"><?php echo $this->_aVars['sPhrase']; ?></a>
<?php endif; ?>
<?php endforeach; endif; ?>
<?php else: ?>
		<ul>
<?php if (count((array)$this->_aVars['aFooter'])):  $this->_aPhpfoxVars['iteration']['block'] = 0;  foreach ((array) $this->_aVars['aFooter'] as $this->_aVars['sPhrase'] => $this->_aVars['sLink']):  $this->_aPhpfoxVars['iteration']['block']++; ?>

				<li id="js_block_bottom_<?php echo $this->_aPhpfoxVars['iteration']['block']; ?>"<?php if ($this->_aPhpfoxVars['iteration']['block'] == 1): ?> class="first"<?php endif; ?>>
<?php if ($this->_aVars['sLink'] == '#'): ?>
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('theme' => 'ajax/add.gif','class' => 'ajax_image')); ?>
<?php endif; ?>
					<a href="<?php echo $this->_aVars['sLink']; ?>" id="js_block_bottom_link_<?php echo $this->_aPhpfoxVars['iteration']['block']; ?>"><?php echo $this->_aVars['sPhrase']; ?></a>
				</li>
<?php endforeach; endif; ?>
		</ul>
<?php endif; ?>
	</div>
<?php endif; ?>
</div>
<?php endif;  unset($this->_aVars['sHeader'], $this->_aVars['sComponent'], $this->_aVars['aFooter'], $this->_aVars['sBlockBorderJsId'], $this->_aVars['bBlockDisableSort'], $this->_aVars['bBlockCanMove'], $this->_aVars['aEditBar'], $this->_aVars['sDeleteBlock'], $this->_aVars['sBlockTitleBar'], $this->_aVars['sBlockJsId'], $this->_aVars['sCustomClassName'], $this->_aVars['aMenu']); ?>
