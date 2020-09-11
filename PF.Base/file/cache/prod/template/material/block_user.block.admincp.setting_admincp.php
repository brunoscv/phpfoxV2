<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:03 pm */ ?>
<?php

?>

<?php if (! empty ( $this->_aVars['aSettings'] )): ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title"><?php echo _p('user_group_settings'); ?></div>
    </div>
    <div class="panel-body">
<?php if (count((array)$this->_aVars['aSettings'])):  foreach ((array) $this->_aVars['aSettings'] as $this->_aVars['aProduct']): ?>
<?php if (count((array)$this->_aVars['aProduct'])):  foreach ((array) $this->_aVars['aProduct'] as $this->_aVars['sKey'] => $this->_aVars['aSetting']): ?>
<?php if (count((array)$this->_aVars['aSetting'])):  $this->_aPhpfoxVars['iteration']['settings'] = 0;  foreach ((array) $this->_aVars['aSetting'] as $this->_aVars['aItem']):  $this->_aPhpfoxVars['iteration']['settings']++; ?>

                    <div id="iSettingId<?php echo $this->_aVars['aItem']['setting_id']; ?>" class="form-group <?php if (isset ( $this->_aVars['aItem']['error'] )): ?>has-error<?php endif; ?> lines <?php if ($this->_aVars['aItem']['is_admin_setting']): ?>has-warning<?php endif; ?> setting <?php if (( $this->_aVars['aItem']['type_id'] == 'boolean' || $this->_aVars['aItem']['type_id'] == 'input:radio' )): ?>boolean-setting<?php endif; ?>">
<?php if (( $this->_aVars['aItem']['type_id'] == 'boolean' || $this->_aVars['aItem']['type_id'] == 'input:radio' )): ?>
                        <div>
<?php endif; ?>
<?php if (PHPFOX_DEBUG): ?>
                            <div class="p_4">
                                <input readonly type="text" name="param[<?php echo $this->_aVars['aItem']['setting_id']; ?>]" value="<?php echo $this->_aVars['sKey']; ?>.<?php echo $this->_aVars['aItem']['name']; ?>" style="font-size:9pt; padding:0 3px;width:200px" onclick="this.select();" />
                            </div>
<?php endif; ?>
                        <span class="sr-only"><?php echo $this->_aVars['aItem']['name']; ?></span>
                        <label><?php echo $this->_aVars['aItem']['setting_name']; ?></label>
<?php if ($this->_aVars['aItem']['is_admin_setting']): ?>
                        <div class="alert alert-warning alert-labeled">
                            <div class="alert-labeled-row">
                                <p class="alert-body alert-body-right alert-labelled-cell">
                                    <strong><?php echo _p("Warning"); ?></strong>
<?php echo _p("This is an important setting. Select a wrong option here can break the site or affect some features. If you are at all unsure about which option to configure, use the default value or contact us for support"); ?>.
                                </p>
                            </div>
                        </div>
<?php endif; ?>

<?php if (( $this->_aVars['aItem']['type_id'] == 'boolean' || $this->_aVars['aItem']['type_id'] == 'input:radio' )): ?>
                            <p class="help-block"><?php echo $this->_aVars['aItem']['setting_info']; ?></p>
                        </div>
<?php endif; ?>

<?php if ($this->_aVars['aItem']['type_id'] === 'currency' || ( ! empty ( $this->_aVars['aCurrency'] ) && in_array ( $this->_aVars['aItem']['name'] , $this->_aVars['aCurrency'] ) == true ) || isset ( $this->_aVars['aItem']['isCurrency'] )): ?>
                            <input type="hidden" name="val[sponsor_setting_id_<?php echo $this->_aVars['aItem']['setting_id']; ?>]" value="<?php echo $this->_aVars['aItem']['setting_id']; ?>" />
<?php Phpfox::getBlock('core.currency', array('currency_field_name' => 'val[value_actual]['.$this->_aVars['aItem']['setting_id'].']','value_actual' => $this->_aVars['aItem']['value_actual'])); ?>
<?php elseif ($this->_aVars['aItem']['type_id'] == 'big_string'): ?>
                            <textarea class="form-control change_warning" rows="8" name="val[value_actual][<?php echo $this->_aVars['aItem']['setting_id']; ?>]"><?php echo $this->_aVars['aItem']['value_actual']; ?></textarea>
<?php elseif (( $this->_aVars['aItem']['type_id'] == 'integer' || $this->_aVars['aItem']['type_id'] == 'string' || $this->_aVars['aItem']['type_id'] == 'input:text' )): ?>
                            <input class="form-control change_warning" type="text" name="val[value_actual][<?php echo $this->_aVars['aItem']['setting_id']; ?>]" value="<?php echo $this->_aVars['aItem']['value_actual']; ?>" size="25" onclick="this.select();" />
<?php elseif (( $this->_aVars['aItem']['type_id'] == 'boolean' || $this->_aVars['aItem']['type_id'] == 'input:radio' )): ?>
                            <div class="item_is_active_holder">
                                <span class="js_item_active item_is_active hide">
                                    <input type="radio" class="radio_yes change_warning" name="val[value_actual][<?php echo $this->_aVars['aItem']['setting_id']; ?>]" value="1" <?php if ($this->_aVars['aItem']['value_actual'] == true || $this->_aVars['aItem']['value_actual'] == "1"): ?>data-it="1yes" checked="checked" <?php endif; ?>/>
                                </span>
                                <span class="js_item_active item_is_not_active hide">
                                    <input type="radio" class="radio_no change_warning" name="val[value_actual][<?php echo $this->_aVars['aItem']['setting_id']; ?>]" value="0" <?php if (! $this->_aVars['aItem']['value_actual']): ?>checked="checked" <?php endif; ?>/>
                                </span>
                            </div>
<?php elseif (( $this->_aVars['aItem']['type_id'] == 'multi_text' )): ?>
<?php if (count((array)$this->_aVars['aItem']['value_actual'])):  foreach ((array) $this->_aVars['aItem']['value_actual'] as $this->_aVars['mKey'] => $this->_aVars['sDropValue']): ?>
                            <div class="p_4">
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo $this->_aVars['mKey']; ?></span>
                                    <input class="form-control change_warning" type="text" name="val[value_actual][<?php echo $this->_aVars['aItem']['setting_id']; ?>][<?php echo $this->_aVars['mKey']; ?>]" value="<?php echo Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['sDropValue'])); ?>" />
                                </div>
                            </div>
<?php endforeach; endif; ?>
<?php elseif (( $this->_aVars['aItem']['type_id'] == 'multi_checkbox' )): ?>
                            <input type="hidden" name="val[value_actual][<?php echo $this->_aVars['aItem']['setting_id']; ?>][]" value="core_multi_checkbox_off">
<?php if (count((array)$this->_aVars['aItem']['values'])):  foreach ((array) $this->_aVars['aItem']['values'] as $this->_aVars['mKey'] => $this->_aVars['sDropValue']): ?>
                            <div class="custom-checkbox-wrapper">
                                <label>
                                    <input type="checkbox" name="val[value_actual][<?php echo $this->_aVars['aItem']['setting_id']; ?>][]" value="<?php echo $this->_aVars['mKey']; ?>" <?php if (is_array ( $this->_aVars['aItem']['value_actual'] ) && in_array ( $this->_aVars['mKey'] , $this->_aVars['aItem']['value_actual'] )): ?>checked<?php endif; ?> />
                                    <span class="custom-checkbox"></span>
<?php echo $this->_aVars['sDropValue']; ?>
                                </label>
                            </div>
<?php endforeach; endif; ?>
<?php elseif ($this->_aVars['aItem']['type_id'] == 'drop' || $this->_aVars['aItem']['type_id'] == 'drop_with_key' || $this->_aVars['aItem']['type_id'] == 'select'): ?>
                            <select name="val[value_actual][<?php echo $this->_aVars['aItem']['setting_id']; ?>]" class="form-control change_warning">
<?php if (count((array)$this->_aVars['aItem']['values'])):  foreach ((array) $this->_aVars['aItem']['values'] as $this->_aVars['mKey'] => $this->_aVars['sDropValue']): ?>
                                <option value="<?php echo $this->_aVars['mKey']; ?>" <?php if ($this->_aVars['aItem']['value_actual'] == $this->_aVars['mKey']): ?> selected="selected" <?php endif; ?>><?php echo $this->_aVars['sDropValue']; ?></option>
<?php endforeach; endif; ?>
                            </select>
<?php elseif (( $this->_aVars['aItem']['type_id'] == 'array' )): ?>
                            <div class="js_array_holder">
<?php if (is_array ( $this->_aVars['aItem']['value_actual'] )): ?>
<?php if (count((array)$this->_aVars['aItem']['value_actual'])):  foreach ((array) $this->_aVars['aItem']['value_actual'] as $this->_aVars['iKey'] => $this->_aVars['sValue']): ?>
                                <div class="p_4 js_array<?php echo $this->_aVars['iKey']; ?>">
                                    <div class="input-group">
                                        <input type="text" name="val[value_actual][<?php echo $this->_aVars['aItem']['setting_id']; ?>][]" value="<?php echo $this->_aVars['sValue']; ?>" size="120" class="form-control change_warning" />
                                        <span class="input-group-btn">
                                            <a class="btn btn-danger" data-cmd="admincp.site_setting_remove_input"><i class="fa fa-remove"></i></a>
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
                                        <input type="text" name="" placeholder="<?php echo _p('add_a_new_value', array('phpfox_squote' => true)); ?>" size="30" class="js_add_to_array form-control" />
                                        <span class="input-group-btn">
                                            <input type="button" value="<?php echo _p('add'); ?>" class="btn btn-primary" data-rel="val[value_actual][<?php echo $this->_aVars['aItem']['setting_id']; ?>][]" data-cmd="admincp.site_setting_add_input" />
                                        </span>
                                    </div>
                                </div>
                            </div>
<?php endif; ?>
<?php if (( $this->_aVars['aItem']['type_id'] != 'boolean' && $this->_aVars['aItem']['type_id'] != 'input:radio' )): ?>
                            <p class="help-block"><?php echo $this->_aVars['aItem']['setting_info']; ?></p>
<?php endif; ?>
                    </div>
<?php endforeach; endif; ?>
<?php endforeach; endif; ?>
<?php endforeach; endif; ?>
        <div class="form-group lines form-group-save-changes">
            <button type="submit" class="btn btn-primary" name="val[submit]"><?php echo _p('Save Changes'); ?></button>
        </div>
    </div>
</div>
<?php else: ?>
<div class="alert alert-empty">
<?php echo _p('there_are_no_settings'); ?>
</div>
<?php endif; ?>


