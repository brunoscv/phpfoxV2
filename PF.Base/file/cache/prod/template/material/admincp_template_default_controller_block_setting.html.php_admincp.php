<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:12 pm */ ?>
<?php

?>

<?php if (count ( $this->_aVars['aSettings'] )): ?>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="cmd" value="_save"/>
<div class="panel panel-default">
    <div class="panel-body">
<?php if (count((array)$this->_aVars['aSettings'])):  foreach ((array) $this->_aVars['aSettings'] as $this->_aVars['aSetting']): ?>
    <div class="form-group <?php if (isset ( $this->_aVars['aSetting']['error'] )): ?>has-error<?php endif; ?> lines">
<?php if (PHPFOX_DEBUG): ?>
        <div class="pull-right">
            <input type="text" readonly value="<?php echo $this->_aVars['aSetting']['var_name']; ?>" class="input_xs_readonly" onclick="this.select()" />
        </div>
<?php endif; ?>
        <label><?php echo $this->_aVars['aSetting']['info']; ?></label>
<?php if ($this->_aVars['aSetting']['type'] == 'multi_text'): ?>
<?php if (count((array)$this->_aVars['aSetting']['value'])):  foreach ((array) $this->_aVars['aSetting']['value'] as $this->_aVars['mKey'] => $this->_aVars['sDropValue']): ?>
        <div class="p_4">
            <div class="input-group">
                <span class="input-group-addon"><?php echo $this->_aVars['mKey']; ?></span>
                <input class="form-control" type="text" name="val[value][<?php echo $this->_aVars['aSetting']['var_name']; ?>][<?php echo $this->_aVars['mKey']; ?>]" value="<?php echo Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['sDropValue'])); ?>" size="8" />
            </div>
        </div>
<?php endforeach; endif; ?>
<?php elseif ($this->_aVars['aSetting']['type'] == 'currency'): ?>
<?php Phpfox::getBlock('core.currency', array('currency_field_name' => 'val[value]['.$this->_aVars['aSetting']['var_name'].']','value_actual' => $this->_aVars['aSetting']['value'])); ?>
<?php elseif ($this->_aVars['aSetting']['type'] == 'multi_checkbox'): ?>
<?php if (count((array)$this->_aVars['aSetting']['options'])):  foreach ((array) $this->_aVars['aSetting']['options'] as $this->_aVars['mKey'] => $this->_aVars['sDropValue']): ?>
        <div class="custom-checkbox-wrapper">
            <label>
                <input type="checkbox" name="val[value][<?php echo $this->_aVars['aSetting']['var_name']; ?>][]" value="<?php echo $this->_aVars['mKey']; ?>" <?php if (is_array ( $this->_aVars['aSetting']['value'] ) && in_array ( $this->_aVars['mKey'] , $this->_aVars['aSetting']['value'] )): ?>checked<?php endif; ?> />
                <span class="custom-checkbox"></span>
<?php echo $this->_aVars['sDropValue']; ?>
            </label>
        </div>
<?php endforeach; endif; ?>
<?php elseif ($this->_aVars['aSetting']['type'] == 'large_string'): ?>
        <textarea cols="60" rows="8" class="form-control" name="val[value][<?php echo $this->_aVars['aSetting']['var_name']; ?>]"><?php echo Phpfox::getLib('parse.output')->htmlspecialchars($this->_aVars['aSetting']['value']); ?></textarea>
<?php elseif (( $this->_aVars['aSetting']['type'] == 'string' )): ?>
        <input type="text" class="form-control" name="val[value][<?php echo $this->_aVars['aSetting']['var_name']; ?>]" value="<?php echo Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aSetting']['value'])); ?>" size="40" />
<?php elseif (( $this->_aVars['aSetting']['type'] == 'password' )): ?>
        <input class="form-control" type="password" name="val[value][<?php echo $this->_aVars['aSetting']['var_name']; ?>]" value="<?php echo $this->_aVars['aSetting']['value']; ?>" size="40" autocomplete="off" />
<?php elseif (( $this->_aVars['aSetting']['type'] == 'select' )): ?>
        <select name="val[value][<?php echo $this->_aVars['aSetting']['var_name']; ?>]" class="form-control">
<?php if (count((array)$this->_aVars['aSetting']['options'])):  foreach ((array) $this->_aVars['aSetting']['options'] as $this->_aVars['mKey'] => $this->_aVars['sDropValue']): ?>
            <option value="<?php echo $this->_aVars['mKey']; ?>" <?php if ($this->_aVars['aSetting']['value'] == $this->_aVars['mKey']): ?>selected="selected"<?php endif; ?>><?php echo $this->_aVars['sDropValue']; ?></option>
<?php endforeach; endif; ?>
        </select>
<?php elseif (( $this->_aVars['aSetting']['type'] == 'integer' )): ?>
        <input class="form-control" type="text" name="val[value][<?php echo $this->_aVars['aSetting']['var_name']; ?>]" value="<?php echo $this->_aVars['aSetting']['value']; ?>" size="40" onclick="this.select();" />
<?php elseif (( $this->_aVars['aSetting']['type'] == 'boolean' )): ?>
        <div class="item_is_active_holder">
			<span class="js_item_active item_is_active">
				<input type="radio" value="1" name="val[value][<?php echo $this->_aVars['aSetting']['var_name']; ?>]"<?php if ($this->_aVars['aSetting']['value'] == 1): ?> checked="checked"<?php endif; ?>>
			</span>
            <span class="js_item_active item_is_not_active">
				<input type="radio" value="0" name="val[value][<?php echo $this->_aVars['aSetting']['var_name']; ?>]"<?php if ($this->_aVars['aSetting']['value'] != 1): ?> checked="checked"<?php endif; ?>>
			</span>
        </div>
<?php elseif (( $this->_aVars['aSetting']['type'] == 'array' )): ?>
        <div class="js_array_holder">
<?php if (is_array ( $this->_aVars['aSetting']['value'] )): ?>
<?php if (count((array)$this->_aVars['aSetting']['value'])):  foreach ((array) $this->_aVars['aSetting']['value'] as $this->_aVars['iKey'] => $this->_aVars['sValue']): ?>
            <div class="p_4" class="js_array<?php echo $this->_aVars['iKey']; ?>">
                <div class="input-group">
                    <input type="text" name="val[value][<?php echo $this->_aVars['aSetting']['var_name']; ?>][]" value="<?php echo $this->_aVars['sValue']; ?>" size="120" class="form-control" />
                    <span class="input-group-btn">
                        <a class="btn btn-danger" data-cmd="admincp.site_setting_remove_input"><i class="fa fa-remove"></i> </a>
                    </span>
                </div>
            </div>
<?php endforeach; endif; ?>
<?php endif; ?>
            <div class="js_array_data"></div>
            <div class="js_array_count" style="display:none;"><?php if (isset ( $this->_aVars['iKey'] )):  echo $this->_aVars['iKey'];  endif; ?></div>
            <br />
            <div class="p_4">
                <div class="input-group">
                    <input type="text" name="" placeholder="<?php echo _p('add_a_new_value'); ?>" size="30" class="js_add_to_array form-control" />
                    <span class="input-group-btn">
                        <input type="button" value="<?php echo _p('add'); ?>" class="btn btn-primary" data-rel="val[value][<?php echo $this->_aVars['aSetting']['var_name']; ?>][]" data-cmd="admincp.site_setting_add_input" />
                    </span>
                </div>
            </div>
        </div>
<?php endif; ?>
<?php if (isset ( $this->_aVars['aSetting']['description'] )): ?>
        <div class="help-block"><?php echo $this->_aVars['aSetting']['description']; ?></div>
<?php endif; ?>
    </div>
<?php endforeach; endif; ?>
    </div>
    <div class="panel-footer">
        <button type="submit" class="btn btn-danger"><?php echo _p('Save Changes'); ?></button>
        <a class="btn btn-link" href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.block', array('m_connection' => $this->_aVars['sConnection'])); ?>"><?php echo _p('cancel'); ?></a>
    </div>
    </div>

</form>

<?php else: ?>
<div class="alert alert-empty"><?php echo _p('there_are_no_settings'); ?></div>
<?php endif; ?>
