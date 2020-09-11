<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:03 pm */ ?>
<?php echo '
<style rel="stylesheet">
    .core-messages-admincp-conversations .last-message
    {
        color: #0f6755;
    }
    .core-messages-admincp-conversations .js_pager_buttons
    {
        text-align: center;
    }
    .core-messages-admincp-conversations .form-group
    {
        padding-left: 0;
        padding-right: 0;
    }
</style>
'; ?>

<div class="core-messages-admincp-conversations">
    <div class="search">
        <form id="js_form_search_conversation" method="get" action="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.mail.conversations'); ?>">
            <div class="form-group col-md-6">
                <label for="keyword"><?php echo _p('Keyword'); ?></label>
                <input type="text" class="form-control" name="search[keyword]" value="<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val')); echo (isset($aParams['keyword']) ? Phpfox::getLib('phpfox.parse.output')->clean($aParams['keyword']) : (isset($this->_aVars['aForms']['keyword']) ? Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aForms']['keyword']) : '')); ?>
">
            </div>
            <div class="form-group col-md-12">
                <button class="btn btn-primary"><?php echo _p('Search'); ?></button>
            </div>
        
</form>

    </div>
<?php if (count ( $this->_aVars['aConversations'] )): ?>
        <div class="panel panel-default table-responsive">
            <table class="table table-admin">
                <thead>
                <tr>
                    <th class="t_center w80"><?php echo _p('ID'); ?></th>
                    <th><?php echo _p('Conversation Title'); ?></th>
                    <th class="t_center w20"><?php echo _p('Settings'); ?></th>
                </tr>
                </thead>
                <tbody>
<?php if (count((array)$this->_aVars['aConversations'])):  foreach ((array) $this->_aVars['aConversations'] as $this->_aVars['iKey'] => $this->_aVars['aConversation']): ?>
                    <tr>
                        <td class="w80">#<?php echo $this->_aVars['aConversation']['thread_id']; ?></td>
                        <td><a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.mail.messages', array('id' => $this->_aVars['aConversation']['thread_id'],'search[keyword]' => $this->_aVars['aForms']['keyword'])); ?>"><?php echo $this->_aVars['aConversation']['thread_name']; ?></a></td>
                        <td class="t_center w20">
                            <a role="button" class="js_drop_down_link" title="<?php echo _p('manage'); ?>"></a>
                            <div class="link_menu">
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.mail.messages', array('id' => $this->_aVars['aConversation']['thread_id'],'search[keyword]' => $this->_aVars['aForms']['keyword'])); ?>" target="_blank"><?php echo _p('View Detail'); ?></a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
<?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
<?php if (!isset($this->_aVars['aPager'])): Phpfox::getLib('pager')->set(array('page' => Phpfox::getLib('request')->getInt('page'), 'size' => Phpfox::getLib('search')->getDisplay(), 'count' => Phpfox::getLib('search')->getCount())); endif;  $this->getLayout('pager'); ?>
<?php else: ?>
        <div class="alert alert-empty col-md-12">
<?php echo _p('Conversations not found'); ?>
        </div>
<?php endif; ?>
</div>

