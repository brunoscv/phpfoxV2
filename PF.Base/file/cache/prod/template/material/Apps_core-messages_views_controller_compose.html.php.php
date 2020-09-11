<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:08 pm */ ?>
<?php
	
 echo $this->_aVars['sCreateJs']; ?>

<script type="text/javascript">
    oTranslations['mail_number_of_members_over_limitation'] = "<?php echo $this->_aVars['numberOfMembersOverLimitation']; ?>";
</script>

<div id="js_ajax_compose_error_message"></div>
<div id="js_core_messages_compose_message" class="core-messages__addmember">
    <span id="back-to-list-js" class="back-to-list hidden"><i class="ico ico-arrow-left-circle-o" aria-hidden="true"></i></span>
    <input type="hidden" id="js_check_numbers_member_for_group" value="<?php echo $this->_aVars['iGroupMemberMaximum']; ?>">
    <input type="hidden" id="js_compose_message_friend_title" value="<?php echo $this->_aVars['sFriendPhrase']; ?>">
    <input type="hidden" id="js_compose_message_custom_list_title" value="<?php echo $this->_aVars['sCustomlistPhrase']; ?>">
	<form class="form js_ajax_compose_message" method="post" action="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('mail.compose'); ?>" id="js_form_mail" data-type="<?php if (! empty ( $this->_aVars['iPageId'] )): ?>claim-page<?php endif; ?>">
        <input type="hidden" value="<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val')); echo (isset($aParams['message']) ? Phpfox::getLib('phpfox.parse.output')->clean($aParams['message']) : (isset($this->_aVars['aForms']['message']) ? Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aForms']['message']) : '')); ?>
" id="message" name="val[message]">
<?php if (isset ( $this->_aVars['iPageId'] )): ?>
            <div><input type="hidden" name="val[page_id]" value="<?php echo $this->_aVars['iPageId']; ?>"></div>
            <div><input type="hidden" name="val[sending_message]" value="<?php echo $this->_aVars['iPageId']; ?>"></div>
<?php endif; ?>
                <div><input type="hidden" name="val[attachment]" class="js_attachment" value="<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val')); echo (isset($aParams['attachment']) ? Phpfox::getLib('phpfox.parse.output')->clean($aParams['attachment']) : (isset($this->_aVars['aForms']['attachment']) ? Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aForms']['attachment']) : '')); ?>
" /></div>
<?php if (PHPFOX_IS_AJAX && isset ( $this->_aVars['aUser']['user_id'] )): ?>
        <div><input type="hidden" name="id" value="<?php echo $this->_aVars['aUser']['user_id']; ?>" /></div>
        <div><input type="hidden" name="val[to][]" value="<?php echo $this->_aVars['aUser']['user_id']; ?>" /></div>
        <div class="form-group mb-0">
            <?php
						Phpfox::getLib('template')->getBuiltFile('mail.block.message-footer');
						?>
        </div>

<?php else: ?>
            <div class="core-messages-advanced-compose">
                <div class="search-friend-component mb-1">
                    <p class="mb-0 pb-0 text-gray-dark mr-1"><?php echo _p('To'); ?>:</p>
                    <span id="js_core_messages_custom_search_friend_placement">
<?php if (! empty ( $this->_aVars['sSelectedCustomlist'] )): ?>
<?php echo $this->_aVars['sSelectedCustomlist']; ?>
<?php endif; ?>
                    </span>
<?php if (empty ( $this->_aVars['aCustomlist'] )): ?>
                    <div id="js_core_messages_custom_search_friend">
                        <input type="text" id="js_core_messages_search" class="search_friend_input" placeholder="<?php echo _p('mail_search_friends_custom_list_by_name'); ?>" autocomplete="off" onfocus="coreMessages.search.buildList();" onkeyup="coreMessages.search.getSearch(this);" style="width:100%;" class="form-control" >
                        <div class="js_core_messages_search_list search-friend-list" style="display: none;"></div>
                    </div>
<?php endif; ?>
                </div>
            </div>
<?php if (! empty ( $this->_aVars['bIsAjaxPopup'] )): ?>
            <div class="form-group">
                <?php
						Phpfox::getLib('template')->getBuiltFile('mail.block.message-footer');
						?>
            </div>
<?php endif; ?>
<?php endif; ?>
<?php if (Phpfox ::isModule('captcha') && Phpfox ::getUserParam('mail.enable_captcha_on_mail')): ?>
<?php Phpfox::getBlock('captcha.form', array('sType' => 'mail')); ?>
<?php endif; ?>
	
</form>

</div>

<?php if (isset ( $this->_aVars['sMessageClaim'] )):  $this->_aVars['sMessageClaim'] = html_entity_decode($this->_aVars['sMessageClaim'], ENT_QUOTES); ?>
	<script type="text/javascript">
		$('#js_compose_new_message #js_compose_message_textarea').val('<?php echo $this->_aVars['sMessageClaim']; ?>');
	</script>
<?php endif; ?>

<?php if (PHPFOX_IS_AJAX):  echo '
<script>

</script>
'; ?>

<?php endif; ?>

<?php echo '
<script type="text/javascript">
    $Behavior.core_messages_compose_message = function () {
        if ($Core.hasPushState()) {
            window.addEventListener("popstate", function (e) {
                if($(\'#js_core_messages_compose_message\').closest(\'.js_box_content\').length)
                {
                    var oDomObj = $(\'#js_core_messages_compose_message\').get(0);
                    js_box_remove(oDomObj);
                }
            });
        }
    }
</script>
'; ?>

