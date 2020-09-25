<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 25, 2020, 7:50 pm */ ?>
<?php 

?>
<?php if (! empty ( $this->_aVars['customFieldTypeId'] )): ?>
<?php Phpfox::getBlock('custom.display', array('type_id' => $this->_aVars['customFieldTypeId'],'item_id' => $this->_aVars['aUser']['user_id'],'template' => $this->_aVars['customFieldTemplate'],'ignored_fields' => $this->_aVars['ignoredFields'])); ?>
<?php endif; ?>
