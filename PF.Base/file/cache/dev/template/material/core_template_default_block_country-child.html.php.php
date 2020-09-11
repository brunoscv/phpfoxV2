<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:50 pm */ ?>
<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		phpFox LLC
 * @package 		Phpfox
 * @version 		$Id: country-child.html.php 982 2009-09-16 08:11:36Z phpFox LLC $
 */
 
 

 if (! PHPFOX_IS_AJAX || $this->_aVars['bForceDiv']): ?>
<?php if ($this->_aVars['mCountryChildFilter'] !== null): ?>
    <div><input type="hidden" name="null" id="js_country_child_is_search" value="1" /></div>
<?php endif; ?>
<?php if ($this->_aVars['bAdminSearch']): ?>
    <div style=""  class="">
        <label style="margin-top:14px"><?php echo _p('state_province'); ?></label>
        <div id="js_country_child_id">
<?php else: ?>
    <div style="padding: 5px 0px 0px;" id="js_country_child_id" class="form-inline">
<?php endif;  endif;  if (count ( $this->_aVars['aCountryChildren'] ) || $this->_aVars['bAdminSearch']): ?>
	<select name="<?php if ($this->_aVars['mCountryChildFilter'] === null): ?>val<?php else: ?>search<?php endif; ?>[country_child_id]" id="js_country_child_id_value" class="form-control">
		<option value="0"><?php echo _p('state_province'); ?>:</option>
<?php if (count((array)$this->_aVars['aCountryChildren'])):  foreach ((array) $this->_aVars['aCountryChildren'] as $this->_aVars['iChildId'] => $this->_aVars['sChildValue']): ?>
		<option value="<?php echo $this->_aVars['iChildId']; ?>"<?php if ($this->_aVars['iCountryChildId'] == $this->_aVars['iChildId']): ?> selected="selected"<?php endif; ?>><?php echo $this->_aVars['sChildValue']; ?></option>
<?php endforeach; endif; ?>
	</select>
<?php else:  if (PHPFOX_IS_AJAX && $this->_aVars['iCountryChildId'] > 0): ?>
<div><input type="hidden" name="val[country_child_id]" id="js_country_child_id_value" value="<?php echo $this->_aVars['iCountryChildId']; ?>" /></div>
<?php endif;  endif; ?>

<?php if (! PHPFOX_IS_AJAX || $this->_aVars['bForceDiv']): ?>
<?php if ($this->_aVars['bAdminSearch']): ?>
    </div>
    </div>
<?php else: ?>
    </div>
<?php endif; ?>

<?php endif; ?>
