<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 25, 2020, 7:50 pm */ ?>
<?php

?>

<?php if (count((array)$this->_aVars['aCustomMain'])):  foreach ((array) $this->_aVars['aCustomMain'] as $this->_aVars['aCustom']): ?>
<?php if ($this->_aVars['sTemplate'] == 'info'): ?>
<?php Phpfox::getBlock('custom.block', array('data' => $this->_aVars['aCustom'],'template' => $this->_aVars['sTemplate'],'edit_user_id' => $this->_aVars['aUser']['user_id'])); ?>
<?php else: ?>
<?php Phpfox::getBlock('custom.block', array('data' => $this->_aVars['aCustom'],'template' => $this->_aVars['sTemplate'],'edit_user_id' => $this->_aVars['aUser']['user_id'])); ?>
<?php endif; ?>
<?php endforeach; endif; ?>

