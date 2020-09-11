<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:03 pm */ ?>
<?php 

?>

<?php if (! isset ( $this->_aVars['aForms'] )): ?>
<form method="post" action="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.user.group.add'); ?>" enctype="multipart/form-data">
<?php if (isset ( $this->_aVars['bHideApp'] )): ?>
    <div><input type="hidden" name="hide_app" value="<?php echo $this->_aVars['bHideApp']; ?>" /></div>
<?php endif; ?>
	<?php
						Phpfox::getLib('template')->getBuiltFile('user.block.admincp.entry');
						?>
	<div class="form-group">
		<label><?php echo _p('inherit'); ?></label>
        <select name="val[inherit_id]" class="form-control">
<?php if (count((array)$this->_aVars['aGroups'])):  foreach ((array) $this->_aVars['aGroups'] as $this->_aVars['iKey'] => $this->_aVars['aGroup']): ?>
            <option value="<?php echo $this->_aVars['aGroup']['user_group_id']; ?>" <?php if ($this->_aVars['aGroup']['user_group_id'] == 2): ?> selected="selected"<?php endif; ?>><?php echo Phpfox::getLib('locale')->convert($this->_aVars['aGroup']['title']); ?></option>
<?php endforeach; endif; ?>
        </select>
	</div>
	<div class="form-group">
		<input type="submit" value="<?php echo _p('add_user_group'); ?>" class="btn btn-primary" />
	</div>

</form>

<?php else:  if ($this->_aVars['aForms']['user_group_id'] == GUEST_USER_ID): ?>
<?php Phpfox::getBlock('help.info', array('phrase' => 'admincp.not_allowed_for_guests'));  endif;  if (! $this->_aVars['bEditSettings']): ?>
<form method="post" class="form" action="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.user.group.add', array('group_id' => $this->_aVars['aForms']['user_group_id'])); ?>" enctype="multipart/form-data">
	<div><input type="hidden" name="id" value="<?php echo $this->_aVars['aForms']['user_group_id']; ?>" /></div>
    <div><input type="hidden" name="hide_app" value="<?php echo $this->_aVars['bHideApp']; ?>" /></div>
	<?php
						Phpfox::getLib('template')->getBuiltFile('user.block.admincp.entry');
						?>
	<div class="form-group">
		<input type="submit" value="<?php echo _p('submit'); ?>" class="btn btn-primary" />
	</div>

</form>

<?php else: ?>
<form method="get" data-url="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.user.group.add'); ?>">
<input type="hidden" name="setting" value="1" />
<div><input type="hidden" name="hide_app" value="<?php echo $this->_aVars['bHideApp']; ?>" /></div>
<div class="panel panel-default">
    <div class="panel-body row">
<?php if (! $this->_aVars['bHideApp']): ?>
        <div class="form-group js_core_init_selectize_form_group col-sm-3">
            <label for="module_id"><?php echo _p('apps'); ?></label>
            <select name="module" class="form-control" id="module_id">
<?php if (count((array)$this->_aVars['aModules'])):  foreach ((array) $this->_aVars['aModules'] as $this->_aVars['aModule']): ?>
                <option <?php if ($this->_aVars['aModule']['module_id'] == $this->_aVars['sModule']): ?>selected<?php endif; ?> value="<?php echo $this->_aVars['aModule']['module_id']; ?>"><?php echo _p($this->_aVars['aModule']['title']); ?></option>
<?php endforeach; endif; ?>
            </select>
        </div>
<?php else: ?>
        <input type="hidden" name="module-id" value="<?php echo $this->_aVars['sModule']; ?>" />
        <input type="hidden" name="module" value="<?php echo $this->_aVars['sModule']; ?>" />
<?php endif; ?>
<?php if (isset ( $this->_aVars['sAppId'] )): ?>
        <input type="hidden" name="id" value="<?php echo $this->_aVars['sAppId']; ?>" />
<?php endif; ?>
        <div class="form-group col-sm-3">
            <label for="val_group_id"><?php echo _p('groups'); ?></label>
            <select name="group_id" class="form-control" id="val_group_id" onchange="onChangeUserGroupSettings(this)">
<?php if (count((array)$this->_aVars['aGroups'])):  foreach ((array) $this->_aVars['aGroups'] as $this->_aVars['aGroup']): ?>
                <option <?php if ($this->_aVars['aGroup']['user_group_id'] == $this->_aVars['iGroupId']): ?> selected <?php endif; ?> value="<?php echo $this->_aVars['aGroup']['user_group_id']; ?>"><?php echo $this->_aVars['aGroup']['title']; ?></option>
<?php endforeach; endif; ?>
            </select>
        </div>
    </div>
</div>

</form>


<form method="post" class="form user-group-settings">
	<input type="hidden" name="id" value="<?php echo $this->_aVars['aForms']['user_group_id']; ?>" />
    <div><input type="hidden" name="hide_app" value="<?php echo $this->_aVars['bHideApp']; ?>" /></div>
    <?php
						Phpfox::getLib('template')->getBuiltFile('user.block.admincp.setting');
						?>

</form>
	
<?php endif;  endif; ?>
