<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:53 pm */ ?>
<?php

?>
  <div id="store_app_verify_status" style="max-height:150px; overflow:auto; background:#fff; margin-bottom:15px;">
<?php if (count ( $this->_aVars['newFiles'] )): ?>
    <div class="table new_file">
      <div class="table_left">
<?php echo _p('new_files'); ?>:
      </div>
      <div class="table_right">
<?php if (count((array)$this->_aVars['newFiles'])):  foreach ((array) $this->_aVars['newFiles'] as $this->_aVars['file']): ?>
        <div><?php echo $this->_aVars['file']; ?></div>
<?php endforeach; endif; ?>
      </div>
    </div>
<?php endif; ?>

<?php if (count ( $this->_aVars['removeFiles'] )): ?>
    <div class="table remove_file">
      <div class="table_left">
<?php echo _p('remove_files'); ?>:
      </div>
      <div class="table_right">
<?php if (count((array)$this->_aVars['removeFiles'])):  foreach ((array) $this->_aVars['removeFiles'] as $this->_aVars['file']): ?>
        <div><?php echo $this->_aVars['file']; ?></div>
<?php endforeach; endif; ?>
      </div>
    </div>
<?php endif; ?>

<?php if (count ( $this->_aVars['overrideFiles'] )): ?>
    <div class="table override_file">
      <div class="table_left">
<?php echo _p('override_files'); ?>:
      </div>
      <div class="table_right">
<?php if (count((array)$this->_aVars['overrideFiles'])):  foreach ((array) $this->_aVars['overrideFiles'] as $this->_aVars['file']): ?>
        <div><?php echo $this->_aVars['file']; ?></div>
<?php endforeach; endif; ?>
      </div>
    </div>
<?php endif; ?>
</div>
<div class="table_clear">
  <input class="button" type="button" value="Continue" onclick="window.location.href='<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.store.ftp', array('productName' => $this->_aVars['productName'],'type' => $this->_aVars['type'],'productId' => $this->_aVars['productId'],'extra_info' => $this->_aVars['extra_info'],'targetDirectory' => $this->_aVars['targetDirectory'])); ?>'">
</div>

