<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 4:54 pm */ ?>
<?php 

?>
<form class="form" enctype="multipart/form-data" method="post" action="<?php if ($this->_aVars['bIsEdit']):  echo Phpfox::getLib('phpfox.url')->makeUrl("admincp.menu.add", array('id' => $this->_aVars['aForms']['menu_id']));  else:  echo Phpfox::getLib('phpfox.url')->makeUrl("admincp.menu.add");  endif; ?>">
<div class="panel panel-default">
    <div class="panel-body">
            <input type="hidden" name="send_path" value="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.menu'); ?>" />
<?php if ($this->_aVars['bIsEdit']): ?>
            <input type="hidden" name="menu_id" value="<?php echo $this->_aVars['aForms']['menu_id']; ?>" />
<?php endif; ?>
<?php if ($this->_aVars['bIsPage']): ?>
            <input type="hidden" name="val[page_id]" value="<?php echo $this->_aVars['aPage']['page_id']; ?>" />
            <input type="hidden" name="val[product_id]" value="<?php echo $this->_aVars['aPage']['product_id']; ?>" />
            <input type="hidden" name="val[module_id]" value="<?php echo $this->_aVars['sModuleValue']; ?>" />
            <input type="hidden" name="val[url_value]" value="<?php echo $this->_aVars['aPage']['title_url']; ?>" />
            <input type="hidden" name="val[is_page]" value="true" />
<?php endif; ?>
<?php if (! $this->_aVars['bIsPage']): ?>
<?php if (Phpfox ::getUserParam('admincp.can_view_product_options')): ?>
                    <div class="form-group"<?php if (! PHPFOX_IS_TECHIE): ?> style="display:none;"<?php endif; ?>>
                        <label for="product_id"><?php echo _p('product'); ?></label>
                        <select id="product_id" name="val[product_id]" class="form-control">
<?php if (count((array)$this->_aVars['aProducts'])):  foreach ((array) $this->_aVars['aProducts'] as $this->_aVars['aProduct']): ?>
                                <option value="<?php echo $this->_aVars['aProduct']['product_id']; ?>"<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val'));


if (isset($this->_aVars['aField']) && isset($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]) && !is_array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]))
							{
								$this->_aVars['aForms'][$this->_aVars['aField']['field_id']] = array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]);
							}

if (isset($this->_aVars['aForms'])
 && is_numeric('product_id') && in_array('product_id', $this->_aVars['aForms']))
							
{
								echo ' selected="selected" ';
							}

							if (isset($aParams['product_id'])
								&& $aParams['product_id'] == $this->_aVars['aProduct']['product_id'])

							{

								echo ' selected="selected" ';

							}

							else

							{

								if (isset($this->_aVars['aForms']['product_id'])
									&& !isset($aParams['product_id'])
									&& (($this->_aVars['aForms']['product_id'] == $this->_aVars['aProduct']['product_id']) || (is_array($this->_aVars['aForms']['product_id']) && in_array($this->_aVars['aProduct']['product_id'], $this->_aVars['aForms']['product_id']))))
								{
								 echo ' selected="selected" ';
								}
								else
								{
									echo "";
								}
							}
							?>
><?php echo $this->_aVars['aProduct']['title']; ?></option>
<?php endforeach; endif; ?>
                        </select>
<?php Phpfox::getBlock('help.popup', array('phrase' => 'admincp.menu_add_product')); ?>
                    </div>
<?php endif; ?>
                <div class="form-group js_core_init_selectize_form_group"<?php if (! PHPFOX_IS_TECHIE): ?> style="display:none;"<?php endif; ?>>
                    <label for="module_id"><?php echo _p('module'); ?></label>
                    <select id="module_id" name="val[module_id]" class="form-control">
                        <option value=""><?php echo _p('select'); ?>:</option>
<?php if (count((array)$this->_aVars['aModules'])):  foreach ((array) $this->_aVars['aModules'] as $this->_aVars['sModule'] => $this->_aVars['iModuleId']): ?>
                        <option value="<?php echo $this->_aVars['iModuleId']; ?>|<?php echo $this->_aVars['sModule']; ?>"<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val'));


if (isset($this->_aVars['aField']) && isset($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]) && !is_array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]))
							{
								$this->_aVars['aForms'][$this->_aVars['aField']['field_id']] = array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]);
							}

if (isset($this->_aVars['aForms'])
 && is_numeric('module_id') && in_array('module_id', $this->_aVars['aForms']))
							
{
								echo ' selected="selected" ';
							}

							if (isset($aParams['module_id'])
								&& $aParams['module_id'] == $this->_aVars['iModuleId'])

							{

								echo ' selected="selected" ';

							}

							else

							{

								if (isset($this->_aVars['aForms']['module_id'])
									&& !isset($aParams['module_id'])
									&& (($this->_aVars['aForms']['module_id'] == $this->_aVars['iModuleId']) || (is_array($this->_aVars['aForms']['module_id']) && in_array($this->_aVars['iModuleId'], $this->_aVars['aForms']['module_id']))))
								{
								 echo ' selected="selected" ';
								}
								else
								{
									echo "";
								}
							}
							?>
><?php echo Phpfox::getLib('phpfox.locale')->translate($this->_aVars['sModule'], 'module'); ?></option>
<?php endforeach; endif; ?>
                    </select>
<?php Phpfox::getBlock('help.popup', array('phrase' => 'admincp.menu_add_module')); ?>
                </div>
<?php endif; ?>
            <div class="form-group">
                <label for="m_connection" class="required"><?php echo _p('placement'); ?></label>
                <select id="m_connection" name="val[m_connection]" class="form-control">
                    <option value=""><?php echo _p('select'); ?>:</option>
                    <optgroup label="<?php echo _p('menu_block'); ?>">
<?php if (count((array)$this->_aVars['aTypes'])):  foreach ((array) $this->_aVars['aTypes'] as $this->_aVars['sType']): ?>
                        <option value="<?php echo $this->_aVars['sType']; ?>"<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val'));


if (isset($this->_aVars['aField']) && isset($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]) && !is_array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]))
							{
								$this->_aVars['aForms'][$this->_aVars['aField']['field_id']] = array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]);
							}

if (isset($this->_aVars['aForms'])
 && is_numeric('m_connection') && in_array('m_connection', $this->_aVars['aForms']))
							
{
								echo ' selected="selected" ';
							}

							if (isset($aParams['m_connection'])
								&& $aParams['m_connection'] == $this->_aVars['sType'])

							{

								echo ' selected="selected" ';

							}

							else

							{

								if (isset($this->_aVars['aForms']['m_connection'])
									&& !isset($aParams['m_connection'])
									&& (($this->_aVars['aForms']['m_connection'] == $this->_aVars['sType']) || (is_array($this->_aVars['aForms']['m_connection']) && in_array($this->_aVars['sType'], $this->_aVars['aForms']['m_connection']))))
								{
								 echo ' selected="selected" ';
								}
								else
								{
									echo "";
								}
							}
							?>
><?php echo $this->_aVars['sType']; ?></option>
<?php endforeach; endif; ?>
                    </optgroup>
                </select>
<?php Phpfox::getBlock('help.popup', array('phrase' => 'admincp.menu_add_connection')); ?>
            </div>
<?php if (! $this->_aVars['bIsPage']): ?>
            <div class="form-group">
                <label><?php echo _p('url'); ?></label>
                <input type="text" name="val[url_value]" id="url_value" value="<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val')); echo (isset($aParams['url_value']) ? Phpfox::getLib('phpfox.parse.output')->clean($aParams['url_value']) : (isset($this->_aVars['aForms']['url_value']) ? Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aForms']['url_value']) : '')); ?>
" size="40" maxlength="250" class="form-control" />
<?php if (! $this->_aVars['bIsEdit'] && count ( $this->_aVars['aPages'] )): ?>
                <div class="p_4" style="display:none;">
<?php echo _p('or_select_a_page'); ?>
                    <select name="val[url_value_page]" onchange="$('#url_value').val(this.value);" class="form-control">
                        <option value=""><?php echo _p('select'); ?>:</option>
<?php if (count((array)$this->_aVars['aPages'])):  foreach ((array) $this->_aVars['aPages'] as $this->_aVars['sPage'] => $this->_aVars['iId']): ?>
                        <option value="<?php echo $this->_aVars['sPage']; ?>"<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val'));


if (isset($this->_aVars['aField']) && isset($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]) && !is_array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]))
							{
								$this->_aVars['aForms'][$this->_aVars['aField']['field_id']] = array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]);
							}

if (isset($this->_aVars['aForms'])
 && is_numeric('m_connection') && in_array('m_connection', $this->_aVars['aForms']))
							
{
								echo ' selected="selected" ';
							}

							if (isset($aParams['m_connection'])
								&& $aParams['m_connection'] == $this->_aVars['sType'])

							{

								echo ' selected="selected" ';

							}

							else

							{

								if (isset($this->_aVars['aForms']['m_connection'])
									&& !isset($aParams['m_connection'])
									&& (($this->_aVars['aForms']['m_connection'] == $this->_aVars['sType']) || (is_array($this->_aVars['aForms']['m_connection']) && in_array($this->_aVars['sType'], $this->_aVars['aForms']['m_connection']))))
								{
								 echo ' selected="selected" ';
								}
								else
								{
									echo "";
								}
							}
							?>
><?php echo $this->_aVars['sPage']; ?></option>
<?php endforeach; endif; ?>
                    </select>
                </div>
<?php endif; ?>
<?php Phpfox::getBlock('help.popup', array('phrase' => 'admincp.menu_add_url')); ?>
            </div>
<?php endif; ?>

            <div class="form-group">
                <label for="mobile_icon"><?php echo _p('font_awesome_icon'); ?></label>
                <input id="mobile_icon" type="text" name="val[mobile_icon]" value="<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val')); echo (isset($aParams['mobile_icon']) ? Phpfox::getLib('phpfox.parse.output')->clean($aParams['mobile_icon']) : (isset($this->_aVars['aForms']['mobile_icon']) ? Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aForms']['mobile_icon']) : '')); ?>
" class="form-control"/>
            </div>
            <div class="form-group">
                <label class="required"><?php echo _p('menu'); ?></label>
<?php if (count((array)$this->_aVars['aLanguages'])):  foreach ((array) $this->_aVars['aLanguages'] as $this->_aVars['aLanguage']): ?>
                <div class="form-group">
                    <label><?php echo $this->_aVars['aLanguage']['title']; ?></label>
                    <div class="lang_value">
                        <textarea class="form-control" cols="50" rows="5" name="val[text][<?php echo $this->_aVars['aLanguage']['language_id']; ?>]"><?php if (isset ( $this->_aVars['aLanguage']['text'] )):  echo Phpfox::getLib('parse.output')->htmlspecialchars($this->_aVars['aLanguage']['text']);  endif; ?></textarea>
                    </div>
                </div>
<?php endforeach; endif; ?>
            </div>

            <div class="form-group">
                <label><?php echo _p('allow_access'); ?></label>
<?php if (count((array)$this->_aVars['aUserGroups'])):  foreach ((array) $this->_aVars['aUserGroups'] as $this->_aVars['aUserGroup']): ?>
                <div class="custom-checkbox-wrapper">
                    <label>
                        <input type="checkbox" name="val[allow_access][]" value="<?php echo $this->_aVars['aUserGroup']['user_group_id']; ?>"<?php if (isset ( $this->_aVars['aAccess'] ) && is_array ( $this->_aVars['aAccess'] )):  if (! in_array ( $this->_aVars['aUserGroup']['user_group_id'] , $this->_aVars['aAccess'] )): ?> checked="checked" <?php endif;  else: ?> checked="checked" <?php endif; ?>/>
                        <span class="custom-checkbox"></span>
<?php echo Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean(Phpfox::getLib('locale')->convert($this->_aVars['aUserGroup']['title']))); ?>
                    </label>
                </div>
<?php endforeach; endif; ?>
<?php Phpfox::getBlock('help.popup', array('phrase' => 'admincp.menu_add_access')); ?>
            </div>
        </div>
        <div class="panel-footer">
<?php if ($this->_aVars['bIsEdit']): ?>
            <button type="submit" name="_submit" class="btn btn-primary" value="_save"><?php echo _p("save"); ?></button>
<?php else: ?>
            <button type="submit" name="_submit" class="btn btn-primary" value="_save"><?php echo _p("save"); ?></button>
<?php endif; ?>
        </div>
    </div>

</form>



