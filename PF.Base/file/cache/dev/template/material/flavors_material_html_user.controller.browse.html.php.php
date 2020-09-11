<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 6:22 pm */ ?>
<?php



 if (defined ( 'PHPFOX_IS_ADMIN_SEARCH' )): ?>

<?php if (! PHPFOX_IS_AJAX): 
						Phpfox::getLib('template')->getBuiltFile('user.block.user_filter_admin');
						?>

<div class="block_content">
	<?php echo '
	<script>
		function process_admincp_browse() {
			$(\'input.button\').hide();
			$(\'#table_hover_action_holder, .table_hover_action\').prepend(\'<div class="t_center admincp-browse-fa"><i class="fa fa-circle-o-notch fa-spin"></i></div>\');
		}

		function delete_users(response, form, data) {
			// p(form);
			$(\'.admincp-browse-fa\').remove();
			$(\'input.button\').show();
			for (var i in data) {
				var e = data[i];
					// p(\'is delete...\');
					form.find(\'input[type="checkbox"]\').each(function() {
						if ($(this).is(\':checked\')) {
							if (e.name == \'delete\') {
								$(\'#js_user_\' + $(this).val()).remove();
							}
							else {
								$(this).prop(\'checked\', false);
								var thisClass = $(\'#js_user_\' + $(this).val());
								thisClass.removeClass(\'is_checked\').addClass(\'is_processed\');
								setTimeout(function() {
									thisClass.removeClass(\'is_processed\');
								}, 600);
							}
						}
					});
			}
		};
	</script>
	'; ?>

	<form method="post" action="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.user.browse'); ?>" class="ajax_post" data-include-button="true" data-callback-start="process_admincp_browse" data-callback="delete_users">
<?php endif; ?>
<?php if ($this->_aVars['aUsers']): ?>
        <div class="table-responsive">
            <table class="table table-admin" <?php if (isset ( $this->_aVars['bShowFeatured'] ) && $this->_aVars['bShowFeatured'] == 1): ?> id="js_drag_drop"<?php endif; ?>>
            <thead>
                <tr>
                    <th class="w20">
<?php if (! PHPFOX_IS_AJAX): ?>
                        <div class="custom-checkbox-wrapper">
                            <label>
                                <input type="checkbox" name="val[id]" value="" id="js_check_box_all" class="main_checkbox" />
                                <span class="custom-checkbox"></span>
                            </label>
                        </div>
<?php endif; ?>
                    </th>
                    <th <?php echo Phpfox::getService('core.helper')->tableSort("w80 centered","u.user_id asc","u.user_id desc", '', "search[sort]", 'asc'); ?>>
<?php echo _p('id'); ?>
                    </th>
                    <th><?php echo _p('photo'); ?></th>
                    <th <?php echo Phpfox::getService('core.helper')->tableSort("centered","u.full_name asc","u.full_name desc", '', "search[sort]", 'asc'); ?>>
<?php echo _p('display_name'); ?>
                    </th>
                    <th><?php echo _p('email_address'); ?></th>
                    <th>
<?php echo _p('group'); ?>
                    </th>
                    <th <?php echo Phpfox::getService('core.helper')->tableSort("centered","u.last_activity asc","u.last_activity desc", '', "search[sort]", 'asc'); ?>>
<?php echo _p('last_activity'); ?>
                    </th>
                    <th><?php echo _p('ip_address'); ?></th>
                    <th class="w80 text-center"><?php echo _p('settings'); ?></th>
                </tr>
            </thead>
            <tbody>
<?php if (count((array)$this->_aVars['aUsers'])):  $this->_aPhpfoxVars['iteration']['users'] = 0;  foreach ((array) $this->_aVars['aUsers'] as $this->_aVars['iKey'] => $this->_aVars['aUser']):  $this->_aPhpfoxVars['iteration']['users']++; ?>

                    <?php
						Phpfox::getLib('template')->getBuiltFile('user.block.user_entry_admin');
						?>
<?php endforeach; endif; ?>
            </tbody>
            </table>
        </div>

<?php if (!isset($this->_aVars['aPager'])): Phpfox::getLib('pager')->set(array('page' => Phpfox::getLib('request')->getInt('page'), 'size' => Phpfox::getLib('search')->getDisplay(), 'count' => Phpfox::getLib('search')->getCount())); endif;  $this->getLayout('pager'); ?>
<?php else: ?>
            <div class="alert alert-empty">
<?php echo _p("no_members_found"); ?>.
            </div>
<?php endif; ?>

<?php endif; ?>
<?php if (! PHPFOX_IS_AJAX && defined ( 'PHPFOX_IS_ADMIN_SEARCH' )): ?>
	<div class="table_hover_action hidden">
        <input type="submit" name="approve" value="<?php echo _p('approve'); ?>" class="btn btn-default sJsCheckBoxButton disabled" disabled="disabled" />
        <input type="submit" name="ban" value="<?php echo _p('ban'); ?>" class="btn btn-default sJsCheckBoxButton disabled" disabled="disabled" data-confirm-message="<?php echo _p('are_you_sure_you_want_to_ban_selected_users'); ?>"/>
        <input type="submit" name="unban" value="<?php echo _p('un_ban'); ?>" class="btn btn-default sJsCheckBoxButton disabled" disabled="disabled" data-confirm-message="<?php echo _p('are_you_sure_you_want_to_un_ban_selected_users'); ?>"/>
        <input type="submit" name="verify" value="<?php echo _p('Verify'); ?>" class="btn btn-default sJsCheckBoxButton disabled" disabled="disabled"/>
        <input type="submit" name="resend-verify" value="<?php echo _p('resend_verification_mail'); ?>" class="btn btn-default sJsCheckBoxButton disabled" disabled="disabled" />
<?php if (Phpfox ::getUserParam('user.can_delete_others_account')): ?>
        <input type="submit" name="delete" value="<?php echo _p('delete'); ?>" class="btn btn-danger sJsCheckBoxButton disabled" disabled="disabled" data-confirm-message="<?php echo _p('are_you_sure_you_want_to_delete_selected_users'); ?>"/>
<?php endif; ?>
    </div>
	
</form>

</div>
<?php else: ?>
<?php if (! PHPFOX_IS_AJAX): ?>
<?php Phpfox::getBlock('user.search', array()); ?>
<?php endif; ?>
<?php if (isset ( $this->_aVars['highlightUsers'] ) && ! $this->_aVars['bOldWay']): ?>
<?php if (! Phpfox ::getParam('user.hide_recommended_user_block', false )): ?>
        <div class="friend_request_reload ajax" data-url="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('user.browse', array('recommend' => 1)); ?>"></div>
<?php endif; ?>
	<div class="friend_request_reload ajax" data-url="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('user.browse', array('featured' => 1)); ?>"></div>
<?php else: ?>
<?php if ($this->_aVars['aUsers']): ?>
<?php if (! PHPFOX_IS_AJAX): ?>
		<div class="item-container user-listing" id="collection-users">
<?php endif; ?>
<?php if (count((array)$this->_aVars['aUsers'])):  $this->_aPhpfoxVars['iteration']['users'] = 0;  foreach ((array) $this->_aVars['aUsers'] as $this->_aVars['aUser']):  $this->_aPhpfoxVars['iteration']['users']++; ?>

				<article class="user-item js_user_item_<?php echo $this->_aVars['aUser']['user_id']; ?>">
					<?php
						Phpfox::getLib('template')->getBuiltFile('user.block.rows_wide');
						?>
				</article>
<?php endforeach; endif; ?>
<?php if (!isset($this->_aVars['aPager'])): Phpfox::getLib('pager')->set(array('page' => Phpfox::getLib('request')->getInt('page'), 'size' => Phpfox::getLib('search')->getDisplay(), 'count' => Phpfox::getLib('search')->getCount())); endif;  $this->getLayout('pager'); ?>
<?php if (! PHPFOX_IS_AJAX): ?>
		</div>
<?php endif; ?>
<?php elseif (! PHPFOX_IS_AJAX): ?>
        <div class="alert alert-info">
<?php echo _p("no_members_found"); ?>.
        </div>
<?php endif; ?>
<?php endif;  endif; ?>

