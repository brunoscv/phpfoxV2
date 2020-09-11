<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:08 pm */ ?>
<?php

?>
<div id="js_compose_new_message" data-form="<?php echo $this->_aVars['sForm']; ?>">
    <div><input type="hidden" name="val[attachment]" class="js_attachment" value=""></div>
    <div class="compose-form">
<?php if (\Phpfox::getUserParam('mail.can_add_attachment_on_mail')): ?>
        	<div class="editor_holder"><?php echo Phpfox::getLib('phpfox.editor')->get('js_compose_message_textarea', array (
  'id' => 'js_compose_message_textarea',
  'enter' => 'true',
  'placeholder' => 'mail_send_your_reply',
));  Phpfox::getBlock('attachment.share', array('id'=> 'js_compose_message_textarea')); ?></div>
<?php else: ?>
        	<div class="editor_holder"><?php echo Phpfox::getLib('phpfox.editor')->get('js_compose_message_textarea', array (
  'id' => 'js_compose_message_textarea',
  'enter' => 'true',
  'can_attach_file' => 'false',
  'placeholder' => 'mail_send_your_reply',
));  Phpfox::getBlock('PHPfox_Twemoji_Awesome.share', array('id'=> 'js_compose_message_textarea')); ?></div>
<?php endif; ?>
        <button class="btn btn-primary button_not_active btn-compose" id="js_send_message_btn"><i class="ico ico-paperplane mr-1"></i><?php echo _p('send'); ?></button>
    </div>
</div>
<?php echo '
<script type="text/javascript">
    $Behavior.advanced_chat_textarea = function () {
        coreMessagesCustomAttachment.initAttachmentHolder();
    }
</script>
'; ?>

