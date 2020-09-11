<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:06 pm */ ?>
<?php

 if ($this->_aVars['useEnvFile']): ?>
<div class="alert alert-warning">
<?php echo _p('this_configuration_is_set_in_a_configuration_file'); ?>
</div>
<?php endif; ?>
<div class="table-responsive">
    <table class="table table-admin">
        <thead>
        <th class="w50"><?php echo _p('id'); ?></th>
        <th><?php echo _p('name'); ?></th>
        <th><?php echo _p('type'); ?></th>
<?php if (! $this->_aVars['useEnvFile']): ?>
        <th class="w120 text-center"><?php echo _p('is_active'); ?></th>
        <th class="w80 text-center"><?php echo _p('settings'); ?></th>
<?php endif; ?>
        </thead>
        <tbody>
<?php if (count((array)$this->_aVars['aItems'])):  foreach ((array) $this->_aVars['aItems'] as $this->_aVars['aItem']): ?>
        <tr>
            <td>
<?php echo $this->_aVars['aItem']['queue_id']; ?>
            </td>
            <td>
<?php echo $this->_aVars['aItem']['queue_name']; ?>
            </td>
            <td>
<?php echo _p($this->_aVars['aItem']['service_phrase_name']); ?>
            </td>
<?php if (! $this->_aVars['useEnvFile']): ?>
            <td class="text-center">
<?php if ($this->_aVars['aItem']['is_active']):  echo _p('core.yes');  else:  echo _p('core.no');  endif; ?>
            </td>
            <td class="text-center">
                <a role="button" class="js_drop_down_link" title="Manage">
                </a>
                <div class="link_menu">
                    <ul class="dropdown-menu dropdown-menu-right">
<?php if ($this->_aVars['aItem']['edit_link']): ?>
                        <li>
                            <a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl($this->_aVars['aItem']['edit_link']); ?>?queue_id=<?php echo $this->_aVars['aItem']['queue_id']; ?>"><?php echo _p('core.edit'); ?></a>
                        </li>
<?php endif; ?>
                        <li>
                            <a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.setting.queue.transfer'); ?>?queue_id=<?php echo $this->_aVars['aItem']['queue_id']; ?>">
<?php echo _p('change_queue_type'); ?>
                            </a>
                        </li>
<?php if ($this->_aVars['aItem']['queue_id'] != 1): ?>
                        <li class="text-danger">
                            <a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl($this->_aVars['aItem']['edit_link']); ?>?queue_id=<?php echo $this->_aVars['aItem']['storage_id']; ?>">
<?php echo _p('core.delete'); ?>
                            </a>
                        </li>
<?php endif; ?>
                    </ul>
                </div>
            </td>
<?php endif; ?>
        </tr>
<?php endforeach; endif; ?>
        </tbody>
    </table>
</div>
