<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:07 pm */ ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title"><?php echo _p('export_data_to_chat_plus'); ?></div>
    </div>
    <div class="panel-body">
<?php if (isset ( $this->_aVars['bNoChatPlus'] ) && $this->_aVars['bNoChatPlus']): ?>
            <div class="alert alert-danger">
<?php echo _p('chat_plus_is_not_enabled'); ?>
            </div>
<?php elseif (isset ( $this->_aVars['bImported'] ) && $this->_aVars['bImported']): ?>
            <div class="alert alert-success">
<?php echo _p('exported_data_to_chat_plus'); ?>
            </div>
<?php else: ?>
            <form method="post" action="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.mail.export-data-chat-plus'); ?>">
                <p class="help-block"><?php echo _p('export_data_from_messages_to_chat_plus_instruction'); ?></p>
                <button name="export" value="1" class="btn btn-primary"><?php echo _p('submit'); ?></button>
            
</form>

<?php endif; ?>
    </div>
</div>
