<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:08 pm */ ?>
<?php echo $this->_aVars['sScript'];  if ($this->_aVars['aMessages']): ?>
<ul class="panel-items" id="core-messages-conversation-item-panel">
<?php if (count((array)$this->_aVars['aMessages'])):  foreach ((array) $this->_aVars['aMessages'] as $this->_aVars['aMail']): ?>
        <li class="panel-item <?php if ($this->_aVars['aMail']['viewer_is_new']): ?> is_new<?php endif; ?>">
            <div class="panel-item-content">
                <div class="core-messages__list-photo in-dropdown <?php if ($this->_aVars['aMail']['is_group']): ?>has-<?php echo $this->_aVars['aMail']['total_avatar']; ?>-avt<?php endif; ?>  ">
<?php if ($this->_aVars['aMail']['is_group']): ?>
<?php if (count((array)$this->_aVars['aMail']['avatar_for_group'])):  foreach ((array) $this->_aVars['aMail']['avatar_for_group'] as $this->_aVars['aUserAvatar']): ?>
                            <div class="item-avatar">
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('user' => $this->_aVars['aUserAvatar'],'suffix' => '_50_square','max_width' => 50,'max_height' => 50)); ?>
                            </div>
<?php endforeach; endif; ?>
<?php else: ?>
<?php if ($this->_aVars['aMail']['user_id'] == Phpfox ::getUserId()): ?>
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('user' => $this->_aVars['aMail'],'suffix' => '_50_square','max_width' => 50,'max_height' => 50,'no_link' => true)); ?>
<?php else: ?>
<?php if (( isset ( $this->_aVars['aMail']['user_id'] ) && ! empty ( $this->_aVars['aMail']['user_id'] ) )): ?>
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('user' => $this->_aVars['aMail'],'suffix' => '_50_square','max_width' => 50,'max_height' => 50,'no_link' => true)); ?>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
                </div>
                <div class="notification-delete <?php if ($this->_aVars['aMail']['viewer_is_new']): ?> is_new<?php endif; ?>">
                    <a href="#" class="js_hover_title noToggle" onclick="$.ajaxCall('mail.delete', 'id=<?php echo $this->_aVars['aMail']['thread_id']; ?>', 'GET'); $(this).parents('li:first').slideUp(); return false;">
                        <span class="ico ico-inbox"></span>
                        <span class="js_hover_info">
<?php echo _p('archive'); ?>
                        </span>
                    </a>
                </div>
                <a data-custom-class="core-messages-conversation-popup" onclick="coreMessages.bContinueLoadMoreConversationContent = true;$(this).closest('.panel-item').removeClass('is_new').find('.message-unread:first').removeClass('is_new');$(this).closest('.panel-item').find('.notification-delete:first').removeClass('is_new');$(this).removeClass('is_new');" href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('mail.conversation-popup', array('id' => $this->_aVars['aMail']['thread_id'])); ?>" class="popup <?php if ($this->_aVars['aMail']['viewer_is_new']): ?> is_new<?php endif; ?> js_conversation_panel_item" data-id="<?php echo $this->_aVars['aMail']['thread_id']; ?>" rel="core-messages__conversation" data-url="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('mail', array('thread_id' => $this->_aVars['aMail']['thread_id'])); ?>" id="js_panel_item_<?php echo $this->_aVars['aMail']['thread_id']; ?>"></a>
                <div class="content">
                    <div class="fullname-time">
                        <div class="name fw-bold" title="<?php echo $this->_aVars['aMail']['thread_name']; ?>">
<?php echo Phpfox::getLib('phpfox.parse.output')->split(Phpfox::getLib('phpfox.parse.output')->shorten(Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aMail']['thread_name'])), 100, '...'), 25); ?>
                        </div>
                        <div class="time">
<?php echo Phpfox::getLib('date')->convertTime($this->_aVars['aMail']['time_stamp']); ?>
                            <span class="message-unread s-1 <?php if ($this->_aVars['aMail']['viewer_is_new']): ?> is_new<?php endif; ?>"></span>
                        </div>
                    </div>

<?php if (Phpfox ::getParam('mail.show_preview_message')): ?>
                    <div class="preview item_view_content">
<?php if (isset ( $this->_aVars['aMail']['last_user_id'] ) && $this->_aVars['aMail']['last_user_id'] == Phpfox ::getUserId()): ?><span class="ico ico-reply-o"></span> <?php endif; ?>
<?php if ($this->_aVars['aMail']['show_text_html']):  echo Phpfox::getLib('phpfox.parse.bbcode')->stripCode($this->_aVars['aMail']['preview']);  else:  echo Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean(Phpfox::getLib('phpfox.parse.bbcode')->cleanCode($this->_aVars['aMail']['preview'])));  endif; ?>
                    </div>
<?php endif; ?>
                </div>
            </div>
        </li>
<?php endforeach; endif; ?>
</ul>
<?php else: ?>
<div class="empty-message">
    <img src="<?php echo Phpfox::getParam('core.path_actual'); ?>PF.Site/flavors/material/assets/images/empty-message.svg" alt="">
<?php echo _p('you_have_no_messages'); ?>
</div>
<?php endif; ?>
<div class="panel-actions" id="core-messages-conversation-item-panel-actions">
<?php if (Phpfox ::getUserParam('mail.can_compose_message')): ?>
    <a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('mail.compose'); ?>" class="s-5 popup js_hover_title btn-compose">
        <span class="ico ico-comment-plus-o"></span>
        <span class="js_hover_info"><?php echo _p('compose'); ?></span>
    </a>
<?php endif; ?>
</div>

<?php echo '
<script type="text/javascript">
  $Behavior.panel_conversation_item = function () {
    if ($(\'#page_mail_index\').length) {
      $(\'.popup\', \'#core-messages-conversation-item-panel\').off(\'click\').click(function () {
        var iId = $(this).data(\'id\');
        var view = $(\'#js_search_view\').val();
        if (view !== \'\') {
          var url = $(this).data(\'url\')
          coreMessagesHelper.redirect(url);
        }
        else {
          $.ajaxCall("mail.loadThreadController", "thread_id=" + iId + "&view=" + view);
          $(\'#hd-message\').trigger(\'click\');
        }
        return false;
      });
      $(\'.popup\', \'#core-messages-conversation-item-panel-actions\').off(\'click\').click(function () {
        $.ajaxCall(\'mail.loadComposeController\');
        return false;
      });
    }
  }
</script>
'; ?>

