<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 4:57 pm */ ?>
<?php

 if (isset ( $this->_aVars['sMessage'] )): ?>
<div class="message"><?php echo $this->_aVars['sMessage']; ?></div>
<?php else: ?>

<form method="post" id="frmNewsletter" action="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.newsletter.add'); ?>" onsubmit="$(this).find('.btn_submit').prop('disabled', true);">
<?php if ($this->_aVars['bIsEdit']): ?>
    <input type="hidden" name="newsletter_id" value="<?php echo $this->_aVars['aForms']['newsletter_id']; ?>">
<?php endif; ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label for="archive"><?php echo _p('archive'); ?>:</label>
                <div class="item_is_active_holder">
                        <span class="js_item_active item_is_active">
                            <input class='form-control' type="radio" name="val[archive]" value="1" <?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val'));
if (isset($this->_aVars['aForms']) && is_numeric('archive') && in_array('archive', $this->_aVars['aForms']) ){echo ' checked="checked"';}
if ((isset($aParams['archive']) && $aParams['archive'] == '1'))
{echo ' checked="checked" ';}
else
{
 if (isset($this->_aVars['aForms']) && isset($this->_aVars['aForms']['archive']) && !isset($aParams['archive']) && $this->_aVars['aForms']['archive'] == '1')
 {
    echo ' checked="checked" ';}
 else
 {
 }
}
?> 
/> <?php echo _p('yes'); ?>
                        </span>
                    <span class="js_item_active item_is_not_active">
                            <input class='form-control' type="radio" name="val[archive]" value="0" <?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val'));
if (isset($this->_aVars['aForms']) && is_numeric('archive') && in_array('archive', $this->_aVars['aForms']) ){echo ' checked="checked"';}
if ((isset($aParams['archive']) && $aParams['archive'] == '0'))
{echo ' checked="checked" ';}
else
{
 if (isset($this->_aVars['aForms']) && isset($this->_aVars['aForms']['archive']) && !isset($aParams['archive']) && $this->_aVars['aForms']['archive'] == '0')
 {
    echo ' checked="checked" ';}
 else
 {
 if (!isset($this->_aVars['aForms']) || ((isset($this->_aVars['aForms']) && !isset($this->_aVars['aForms']['archive']) && !isset($aParams['archive']))))
{
 echo ' checked="checked"';
}
 }
}
?> 
/> <?php echo _p('no'); ?>
                        </span>
                </div>
                <div class="help-block"><?php echo _p('newsletter_archive_description'); ?></div>
            </div>
            <div class="form-group">
                <label for="archive"><?php echo _p('override_privacy'); ?>:</label>
                <div class="item_is_active_holder">
                        <span class="js_item_active item_is_active">
                            <input class='form-control' type="radio" name="val[privacy]" value="1" <?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val'));
if (isset($this->_aVars['aForms']) && is_numeric('privacy') && in_array('privacy', $this->_aVars['aForms']) ){echo ' checked="checked"';}
if ((isset($aParams['privacy']) && $aParams['privacy'] == '1'))
{echo ' checked="checked" ';}
else
{
 if (isset($this->_aVars['aForms']) && isset($this->_aVars['aForms']['privacy']) && !isset($aParams['privacy']) && $this->_aVars['aForms']['privacy'] == '1')
 {
    echo ' checked="checked" ';}
 else
 {
 }
}
?> 
/> <?php echo _p('yes'); ?>
                        </span>
                    <span class="js_item_active item_is_not_active">
                            <input class='form-control' type="radio" name="val[privacy]" value="0" <?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val'));
if (isset($this->_aVars['aForms']) && is_numeric('privacy') && in_array('privacy', $this->_aVars['aForms']) ){echo ' checked="checked"';}
if ((isset($aParams['privacy']) && $aParams['privacy'] == '0'))
{echo ' checked="checked" ';}
else
{
 if (isset($this->_aVars['aForms']) && isset($this->_aVars['aForms']['privacy']) && !isset($aParams['privacy']) && $this->_aVars['aForms']['privacy'] == '0')
 {
    echo ' checked="checked" ';}
 else
 {
 if (!isset($this->_aVars['aForms']) || ((isset($this->_aVars['aForms']) && !isset($this->_aVars['aForms']['privacy']) && !isset($aParams['privacy']))))
{
 echo ' checked="checked"';
}
 }
}
?> 
/> <?php echo _p('no'); ?>
                        </span>
                </div>
                <div class="help-block"><?php echo _p('newsletter_override_privacy_description'); ?></div>
            </div>
            <div class="form-group">
                <label for="archive"><?php echo _p('run_immediately'); ?>:</label>
                <div class="item_is_active_holder">
                        <span class="js_item_active item_is_active">
                            <input class='form-control' type="radio" name="val[run_now]" value="1" <?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val'));
if (isset($this->_aVars['aForms']) && is_numeric('run_now') && in_array('run_now', $this->_aVars['aForms']) ){echo ' checked="checked"';}
if ((isset($aParams['run_now']) && $aParams['run_now'] == '1'))
{echo ' checked="checked" ';}
else
{
 if (isset($this->_aVars['aForms']) && isset($this->_aVars['aForms']['run_now']) && !isset($aParams['run_now']) && $this->_aVars['aForms']['run_now'] == '1')
 {
    echo ' checked="checked" ';}
 else
 {
 if (!isset($this->_aVars['aForms']) || ((isset($this->_aVars['aForms']) && !isset($this->_aVars['aForms']['run_now']) && !isset($aParams['run_now']))))
{
 echo ' checked="checked"';
}
 }
}
?> 
/> <?php echo _p('yes'); ?>
                        </span>
                    <span class="js_item_active item_is_not_active">
                            <input class='form-control' type="radio" name="val[run_now]" value="0" <?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val'));
if (isset($this->_aVars['aForms']) && is_numeric('run_now') && in_array('run_now', $this->_aVars['aForms']) ){echo ' checked="checked"';}
if ((isset($aParams['run_now']) && $aParams['run_now'] == '0'))
{echo ' checked="checked" ';}
else
{
 if (isset($this->_aVars['aForms']) && isset($this->_aVars['aForms']['run_now']) && !isset($aParams['run_now']) && $this->_aVars['aForms']['run_now'] == '0')
 {
    echo ' checked="checked" ';}
 else
 {
 }
}
?> 
/> <?php echo _p('no'); ?>
                        </span>
                </div>
                <div class="help-block"><?php echo _p('newsletter_run_immediately_description'); ?></div>
            </div>

            <div class="form-group">
                <label for=""><?php echo _p('user_groups'); ?>:</label>
                <select class="form-control" name="val[is_user_group]" id="js_is_user_group">
                    <option value="1"<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val'));


if (isset($this->_aVars['aField']) && isset($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]) && !is_array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]))
							{
								$this->_aVars['aForms'][$this->_aVars['aField']['field_id']] = array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]);
							}

if (isset($this->_aVars['aForms'])
 && is_numeric('is_user_group') && in_array('is_user_group', $this->_aVars['aForms']))
							
{
								echo ' selected="selected" ';
							}

							if (isset($aParams['is_user_group'])
								&& $aParams['is_user_group'] == '1')

							{

								echo ' selected="selected" ';

							}

							else

							{

								if (isset($this->_aVars['aForms']['is_user_group'])
									&& !isset($aParams['is_user_group'])
									&& (($this->_aVars['aForms']['is_user_group'] == '1') || (is_array($this->_aVars['aForms']['is_user_group']) && in_array('1', $this->_aVars['aForms']['is_user_group']))))
								{
								 echo ' selected="selected" ';
								}
								else
								{
									echo "";
								}
							}
							?>
><?php echo _p('all_user_groups'); ?></option>
                    <option value="2"<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val'));


if (isset($this->_aVars['aField']) && isset($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]) && !is_array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]))
							{
								$this->_aVars['aForms'][$this->_aVars['aField']['field_id']] = array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]);
							}

if (isset($this->_aVars['aForms'])
 && is_numeric('is_user_group') && in_array('is_user_group', $this->_aVars['aForms']))
							
{
								echo ' selected="selected" ';
							}

							if (isset($aParams['is_user_group'])
								&& $aParams['is_user_group'] == '2')

							{

								echo ' selected="selected" ';

							}

							else

							{

								if (isset($this->_aVars['aForms']['is_user_group'])
									&& !isset($aParams['is_user_group'])
									&& (($this->_aVars['aForms']['is_user_group'] == '2') || (is_array($this->_aVars['aForms']['is_user_group']) && in_array('2', $this->_aVars['aForms']['is_user_group']))))
								{
								 echo ' selected="selected" ';
								}
								else
								{
									echo "";
								}
							}
							?>
<?php if (! empty ( $this->_aVars['aAccess'] )): ?>selected="true"<?php endif; ?>><?php echo _p('selected_user_groups'); ?></option>
                </select>
                <div class="p_4" style="display:none;" id="js_user_group">
<?php if (count((array)$this->_aVars['aUserGroups'])):  foreach ((array) $this->_aVars['aUserGroups'] as $this->_aVars['aUserGroup']): ?>
                    <div class="p_4">
                        <label><input type="checkbox" name="val[user_group][]" value="<?php echo $this->_aVars['aUserGroup']['user_group_id']; ?>"<?php if (isset ( $this->_aVars['aAccess'] ) && is_array ( $this->_aVars['aAccess'] )):  if (in_array ( $this->_aVars['aUserGroup']['user_group_id'] , $this->_aVars['aAccess'] )): ?> checked="checked" <?php endif;  else: ?> checked="checked" <?php endif; ?>/> <?php echo Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean(Phpfox::getLib('locale')->convert($this->_aVars['aUserGroup']['title']))); ?></label>
                    </div>
<?php endforeach; endif; ?>
                </div>
            </div>
            <div class="form-group">
                <label><?php echo _p('location'); ?>:</label>
                <?php Phpfox::getBlock('core.country-build', array('param'=> array (
  'value_title' => 'phrase var=core.any',
  'class' => 'form-control',
))); ?>
            </div>
            <div class="form-group">
                <label><?php echo _p('gender'); ?>:</label>
                <select class="form-control" name="val[gender]" id="gender">
		<option value="">Any</option>
			<option value="1"<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val'));


if (isset($this->_aVars['aField']) && isset($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]) && !is_array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]))
							{
								$this->_aVars['aForms'][$this->_aVars['aField']['field_id']] = array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]);
							}

if (isset($this->_aVars['aForms'])
 && is_numeric('gender') && in_array('gender', $this->_aVars['aForms']))
							
{
								echo ' selected="selected" ';
							}

							if (isset($aParams['gender'])
								&& $aParams['gender'] == '1')

							{

								echo ' selected="selected" ';

							}

							else

							{

								if (isset($this->_aVars['aForms']['gender'])
									&& !isset($aParams['gender'])
									&& (($this->_aVars['aForms']['gender'] == '1') || (is_array($this->_aVars['aForms']['gender']) && in_array('1', $this->_aVars['aForms']['gender']))))
								{
								 echo ' selected="selected" ';
								}
								else
								{
									echo "";
								}
							}
							?>
><?php echo _p('profile.male'); ?></option>
			<option value="2"<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val'));


if (isset($this->_aVars['aField']) && isset($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]) && !is_array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]))
							{
								$this->_aVars['aForms'][$this->_aVars['aField']['field_id']] = array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]);
							}

if (isset($this->_aVars['aForms'])
 && is_numeric('gender') && in_array('gender', $this->_aVars['aForms']))
							
{
								echo ' selected="selected" ';
							}

							if (isset($aParams['gender'])
								&& $aParams['gender'] == '2')

							{

								echo ' selected="selected" ';

							}

							else

							{

								if (isset($this->_aVars['aForms']['gender'])
									&& !isset($aParams['gender'])
									&& (($this->_aVars['aForms']['gender'] == '2') || (is_array($this->_aVars['aForms']['gender']) && in_array('2', $this->_aVars['aForms']['gender']))))
								{
								 echo ' selected="selected" ';
								}
								else
								{
									echo "";
								}
							}
							?>
><?php echo _p('profile.female'); ?></option>
		</select>
            </div>
            <div class="form-group">
                <label for="age_from"><?php echo _p('age_group_between'); ?>:</label>
                <div class="form-inline">
                    <div class="form-group">
                        <select class="form-control" name="val[age_from]" id="age_from">
                            <option value=""><?php echo _p('all'); ?></option>
<?php if (count((array)$this->_aVars['aAge'])):  foreach ((array) $this->_aVars['aAge'] as $this->_aVars['iAge']): ?>
                            <option value="<?php echo $this->_aVars['iAge']; ?>"<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val'));


if (isset($this->_aVars['aField']) && isset($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]) && !is_array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]))
							{
								$this->_aVars['aForms'][$this->_aVars['aField']['field_id']] = array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]);
							}

if (isset($this->_aVars['aForms'])
 && is_numeric('age_from') && in_array('age_from', $this->_aVars['aForms']))
							
{
								echo ' selected="selected" ';
							}

							if (isset($aParams['age_from'])
								&& $aParams['age_from'] == $this->_aVars['iAge'])

							{

								echo ' selected="selected" ';

							}

							else

							{

								if (isset($this->_aVars['aForms']['age_from'])
									&& !isset($aParams['age_from'])
									&& (($this->_aVars['aForms']['age_from'] == $this->_aVars['iAge']) || (is_array($this->_aVars['aForms']['age_from']) && in_array($this->_aVars['iAge'], $this->_aVars['aForms']['age_from']))))
								{
								 echo ' selected="selected" ';
								}
								else
								{
									echo "";
								}
							}
							?>
><?php echo $this->_aVars['iAge']; ?></option>
<?php endforeach; endif; ?>
                        </select>
                    </div>
                    <label><?php echo _p('and'); ?></label>
                    <div class="form-group">
                        <select class="form-control" name="val[age_to]" id="age_to">
                            <option value=""><?php echo _p('all'); ?></option>
<?php if (count((array)$this->_aVars['aAge'])):  foreach ((array) $this->_aVars['aAge'] as $this->_aVars['iAge']): ?>
                            <option value="<?php echo $this->_aVars['iAge']; ?>"<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val'));


if (isset($this->_aVars['aField']) && isset($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]) && !is_array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]))
							{
								$this->_aVars['aForms'][$this->_aVars['aField']['field_id']] = array($this->_aVars['aForms'][$this->_aVars['aField']['field_id']]);
							}

if (isset($this->_aVars['aForms'])
 && is_numeric('age_to') && in_array('age_to', $this->_aVars['aForms']))
							
{
								echo ' selected="selected" ';
							}

							if (isset($aParams['age_to'])
								&& $aParams['age_to'] == $this->_aVars['iAge'])

							{

								echo ' selected="selected" ';

							}

							else

							{

								if (isset($this->_aVars['aForms']['age_to'])
									&& !isset($aParams['age_to'])
									&& (($this->_aVars['aForms']['age_to'] == $this->_aVars['iAge']) || (is_array($this->_aVars['aForms']['age_to']) && in_array($this->_aVars['iAge'], $this->_aVars['aForms']['age_to']))))
								{
								 echo ' selected="selected" ';
								}
								else
								{
									echo "";
								}
							}
							?>
><?php echo $this->_aVars['iAge']; ?></option>
<?php endforeach; endif; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="total">*<?php echo _p('how_many_per_round'); ?>:</label>
                <input class="form-control" type="text" name="val[total]" value="<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val')); echo (isset($aParams['total']) ? Phpfox::getLib('phpfox.parse.output')->clean($aParams['total']) : (isset($this->_aVars['aForms']['total']) ? Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aForms']['total']) : '50')); ?>
" id="total" size="40" maxlength="150" />
            </div>

            <div class="form-group">
                <label for="subject">*<?php echo _p('subject'); ?>:</label>
                <input class="form-control" type="text" name="val[subject]" value="<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val')); echo (isset($aParams['subject']) ? Phpfox::getLib('phpfox.parse.output')->clean($aParams['subject']) : (isset($this->_aVars['aForms']['subject']) ? Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aForms']['subject']) : '')); ?>
" id="subject" size="40" maxlength="150" />
            </div>

            <div class="form-group">
                <label for="text">*<?php echo _p('html_text'); ?>:</label>
                <div class="editor_holder"><?php echo Phpfox::getLib('phpfox.editor')->get('text', array (
  'id' => 'text',
  'rows' => '15',
  'class' => 'form-control',
));  Phpfox::getBlock('attachment.share', array('id'=> 'text')); ?></div>
            </div>

            <div class="form-group">
                <label><?php echo _p('plain_text'); ?>:</label>
                <textarea class="form-control" name="val[txtPlain]" id="txtPlain" cols="50" rows="15"><?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val')); echo (isset($aParams['txtPlain']) ? Phpfox::getLib('phpfox.parse.output')->clean($aParams['txtPlain']) : (isset($this->_aVars['aForms']['txtPlain']) ? Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aForms']['txtPlain']) : '')); ?>
</textarea>
                <a href="javascript:void(0);" onclick="$Core.Newsletter.showPlain(); return false;"><?php echo _p('get_plain_text_from_html'); ?></a>
            </div>

            <div class="help-block">
<?php echo _p('keyword_substitutions'); ?>:
                <ul>
                    <li><?php echo _p('123_full_name_125_recipient_s_full_name'); ?></li>
                    <li><?php echo _p('123_user_name_125_recipient_s_user_name'); ?></li>
                    <li><?php echo _p('123_site_name_125_site_s_name'); ?></li>
                </ul>
            </div>
        </div>
        <div class="panel-footer">
            <input type="button" value="<?php if ($this->_aVars['bIsEdit']):  echo _p('edit_newsletter');  else:  echo _p('add_newsletter');  endif; ?>" class="btn btn-primary btn_submit" onclick="$Core.Newsletter.checkText();" />
        </div>
    </div>


</form>

<?php endif; ?>

