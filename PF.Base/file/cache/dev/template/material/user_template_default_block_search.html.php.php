<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 6:22 pm */ ?>
<?php

?>

<?php if (! isset ( $this->_aVars['sHidden'] )):  $this->assign('sHidden', '');  endif; ?>

<?php if (( isset ( $this->_aVars['sHeader'] ) && ( ! PHPFOX_IS_AJAX || isset ( $this->_aVars['bPassOverAjaxCall'] ) || isset ( $this->_aVars['bIsAjaxLoader'] ) ) ) || ( defined ( "PHPFOX_IN_DESIGN_MODE" ) && PHPFOX_IN_DESIGN_MODE )): ?>

<div class="<?php echo $this->_aVars['sHidden']; ?> block<?php if (( defined ( 'PHPFOX_IN_DESIGN_MODE' ) ) && ( ! isset ( $this->_aVars['bCanMove'] ) || ( isset ( $this->_aVars['bCanMove'] ) && $this->_aVars['bCanMove'] == true ) )): ?> js_sortable<?php endif;  if (isset ( $this->_aVars['sCustomClassName'] )): ?> <?php echo $this->_aVars['sCustomClassName'];  endif; ?>"<?php if (isset ( $this->_aVars['sBlockBorderJsId'] )): ?> id="js_block_border_<?php echo $this->_aVars['sBlockBorderJsId']; ?>"<?php endif;  if (defined ( 'PHPFOX_IN_DESIGN_MODE' ) && Phpfox_Module ::instance()->blockIsHidden('js_block_border_' . $this->_aVars['sBlockBorderJsId'] . '' )): ?> style="display:none;"<?php endif; ?> data-toggle="<?php echo $this->_aVars['sToggleWidth']; ?>">
<?php if (! empty ( $this->_aVars['sHeader'] ) || ( defined ( "PHPFOX_IN_DESIGN_MODE" ) && PHPFOX_IN_DESIGN_MODE )): ?>
		<div class="title <?php if (defined ( 'PHPFOX_IN_DESIGN_MODE' )): ?>js_sortable_header<?php endif; ?>">
<?php if (isset ( $this->_aVars['sBlockTitleBar'] )): ?>
<?php echo $this->_aVars['sBlockTitleBar']; ?>
<?php endif; ?>
<?php if (( isset ( $this->_aVars['aEditBar'] ) && Phpfox ::isUser())): ?>
			<div class="js_edit_header_bar">
				<a href="#" title="<?php echo _p('edit_this_block'); ?>" onclick="$.ajaxCall('<?php echo $this->_aVars['aEditBar']['ajax_call']; ?>', 'block_id=<?php echo $this->_aVars['sBlockBorderJsId'];  if (isset ( $this->_aVars['aEditBar']['params'] )):  echo $this->_aVars['aEditBar']['params'];  endif; ?>'); return false;">
					<span class="ico ico-pencilline-o"></span>
				</a>
			</div>
<?php endif; ?>
<?php if (empty ( $this->_aVars['sHeader'] )): ?>
<?php echo $this->_aVars['sBlockShowName']; ?>
<?php else: ?>
<?php echo $this->_aVars['sHeader']; ?>
<?php endif; ?>
		</div>
<?php endif; ?>
<?php if (isset ( $this->_aVars['aEditBar'] )): ?>
	<div id="js_edit_block_<?php echo $this->_aVars['sBlockBorderJsId']; ?>" class="edit_bar hidden"></div>
<?php endif; ?>
<?php if (isset ( $this->_aVars['aMenu'] ) && count ( $this->_aVars['aMenu'] )): ?>
<?php unset($this->_aVars['aMenu']); ?>
<?php endif; ?>
	<div class="content"<?php if (isset ( $this->_aVars['sBlockJsId'] )): ?> id="js_block_content_<?php echo $this->_aVars['sBlockJsId']; ?>"<?php endif; ?>>
<?php endif; ?>
		<?php

?>
<div class="hide" id="js_search_user_browse_content">
    <div id="js_search_user_browse_wrapper" class="" >
        <div id="js_user_browse_search_result" class="item_is_active_holder item_selection_active advance_search_button">
            <a id="js_user_browse_enable_adv_search_btn" href="javascript:void(0)" onclick="advSearchUserBrowse.enableAdvSearch();return false;">
                <i class="ico ico-dottedmore-o"></i>
            </a>
        </div>
    </div>
    <div id="js_user_browse_adv_search_wrapper" class="advance_search_form init member_advance_search_form" style="display: none;">
            <div class="member-search-inline-wrapper js_core_init_selectize_form_group">
<?php if (Phpfox ::getUserParam('user.can_search_user_age')): ?>
                    <div class="form-group item-age ">
                        <label><?php echo _p('age'); ?> (<?php echo _p('from'); ?>)</label>
<?php echo $this->_aVars['aFilters']['from']; ?>
                    </div>
                    <div class="form-group item-age">
                        <label><?php echo _p('age'); ?> (<?php echo _p('to'); ?>)</label>
<?php echo $this->_aVars['aFilters']['to']; ?>
                    </div>
<?php endif; ?>

                <div class="form-group item-location">
                    <label><?php echo _p('country'); ?></label>
<?php echo $this->_aVars['aFilters']['country']; ?>
<?php Phpfox::getBlock('core.country-child', array('country_child_filter' => true,'country_child_type' => 'browse')); ?>
                </div>

                <div class="form-group item-location">
                    <label><?php echo _p('city'); ?></label>
<?php echo $this->_aVars['aFilters']['city']; ?>
                </div>

<?php if (Phpfox ::getUserParam('user.can_search_by_zip')): ?>
                    <div class="form-group item-zip-post">
                        <label><?php echo _p('zip_postal_code'); ?></label>
<?php echo $this->_aVars['aFilters']['zip']; ?>
                    </div>
<?php endif; ?>
            </div>

            <div class="form-group">
                <label><?php echo _p('about_info'); ?></label>
                <input id="js_adv_search_about_me" type="text" class="form-control" placeholder="<?php echo _p('some_text_about_keyword'); ?>" name="custom[<?php echo $this->_aVars['aAboutMeCustomField']['field_id']; ?>]" value="<?php $aParams = (isset($aParams) ? $aParams : Phpfox::getLib('phpfox.request')->getArray('val')); echo (isset($aParams[''.$this->_aVars['aAboutMeCustomField']['field_id'].'']) ? Phpfox::getLib('phpfox.parse.output')->clean($aParams[''.$this->_aVars['aAboutMeCustomField']['field_id'].'']) : (isset($this->_aVars['aForms'][''.$this->_aVars['aAboutMeCustomField']['field_id'].'']) ? Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aForms'][''.$this->_aVars['aAboutMeCustomField']['field_id'].'']) : '')); ?>
">
            </div>

<?php if (Phpfox ::getUserParam('user.can_search_user_gender')): ?>
                <div class="form-group item-gender-search">
                    <label><?php echo _p('browser_for'); ?></label>
                    <div class="item-group-gender">
<?php if (count((array)$this->_aVars['aGenders'])):  foreach ((array) $this->_aVars['aGenders'] as $this->_aVars['iGenderId'] => $this->_aVars['sGenderName']): ?>
                            <div class="item-gender radio core-radio-custom">
                                <label >
                                    <input type="radio" name="search[gender]" value="<?php echo $this->_aVars['iGenderId']; ?>" <?php if (! empty ( $this->_aVars['aForms']['gender'] ) && $this->_aVars['aForms']['gender'] == $this->_aVars['iGenderId']): ?>checked<?php endif; ?>>
                                    <i class="custom-icon"></i>
                                    <span><?php echo _p($this->_aVars['sGenderName']); ?></span>
                                </label>
                            </div>
<?php endforeach; endif; ?>
                        <div class="item-gender radio core-radio-custom">
                            <label >
                                    <input type="radio" name="search[gender]" value="" <?php if (empty ( $this->_aVars['aForms']['gender'] )): ?>checked<?php endif; ?>>
                                    <i class="custom-icon"></i>
                                <span><?php echo _p('any'); ?></span>
                            </label>
                        </div>
                    </div>
                </div>
<?php endif; ?>

            <div class="form-group">
                <label ><?php echo _p('sort_results_by'); ?></label>
<?php echo $this->_aVars['aFilters']['sort']; ?>
            </div>

            <div id="js_user_browse_advanced">
                <div class="user_browse_content">
                    <div id="browse_custom_fields_popup_holder" class="js_core_init_selectize_form_group">
<?php if (count((array)$this->_aVars['aCustomFields'])):  $this->_aPhpfoxVars['iteration']['customfield'] = 0;  foreach ((array) $this->_aVars['aCustomFields'] as $this->_aVars['aCustomField']):  $this->_aPhpfoxVars['iteration']['customfield']++; ?>

<?php if (isset ( $this->_aVars['aCustomField']['fields'] )): ?>
                                <?php
						Phpfox::getLib('template')->getBuiltFile('custom.block.foreachcustom');
						?>
<?php endif; ?>
<?php endforeach; endif; ?>
                    </div>
                </div>
            </div>

            <div class="form-group clearfix advance_search_form_button">
                <div class="pull-left">
                    <span class="advance_search_dismiss" onclick="advSearchUserBrowse.enableAdvSearch();return false;">
                        <i class="ico ico-close"></i>
                    </span>
                </div>
                <div class="pull-right">
                    <a class="btn btn-default btn-sm" href="javascript:void(0);" onclick="advSearchUserBrowse.resetForm(); return false;"><?php echo _p('reset'); ?></a>
                    <button name="search[submit]" class="btn btn-primary ml-1 btn-sm"><i class="ico ico-search-o mr-1"></i><?php echo _p('submit'); ?></button>
                </div>
            </div>

<?php if (isset ( $this->_aVars['sCountryISO'] )): ?>
                <script type="text/javascript">
                    $Behavior.loadStatesAfterBrowse = function()
                    {
                    sCountryISO = "<?php echo $this->_aVars['sCountryISO']; ?>";
                    if(sCountryISO != "")
                    {
                    sCountryChildId = "<?php echo $this->_aVars['sCountryChildId']; ?>";
                    $.ajaxCall('core.getChildren', 'country_child_filter=true&country_child_type=browse&country_iso=' + sCountryISO + '&country_child_id=' + sCountryChildId);
                    }
                    }
                </script>
<?php endif; ?>
    </div>
</div>




<?php if (( isset ( $this->_aVars['sHeader'] ) && ( ! PHPFOX_IS_AJAX || isset ( $this->_aVars['bPassOverAjaxCall'] ) || isset ( $this->_aVars['bIsAjaxLoader'] ) ) ) || ( defined ( "PHPFOX_IN_DESIGN_MODE" ) && PHPFOX_IN_DESIGN_MODE )): ?>
	</div>
<?php if (isset ( $this->_aVars['aFooter'] ) && count ( $this->_aVars['aFooter'] )): ?>
	<div class="bottom">
<?php if (count ( $this->_aVars['aFooter'] ) == 1): ?>
<?php if (count((array)$this->_aVars['aFooter'])):  $this->_aPhpfoxVars['iteration']['block'] = 0;  foreach ((array) $this->_aVars['aFooter'] as $this->_aVars['sPhrase'] => $this->_aVars['sLink']):  $this->_aPhpfoxVars['iteration']['block']++; ?>

<?php if ($this->_aVars['sLink'] == '#'): ?>
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('theme' => 'ajax/add.gif','class' => 'ajax_image')); ?>
<?php endif; ?>
<?php if (is_array ( $this->_aVars['sLink'] )): ?>
            <a class="btn btn-block <?php if (! empty ( $this->_aVars['sLink']['class'] )): ?> <?php echo $this->_aVars['sLink']['class'];  endif; ?>" href="<?php if (! empty ( $this->_aVars['sLink']['link'] )):  echo $this->_aVars['sLink']['link'];  else: ?>#<?php endif; ?>" <?php if (! empty ( $this->_aVars['sLink']['attr'] )):  echo $this->_aVars['sLink']['attr'];  endif; ?> id="js_block_bottom_link_<?php echo $this->_aPhpfoxVars['iteration']['block']; ?>"><?php echo $this->_aVars['sPhrase']; ?></a>
<?php else: ?>
            <a class="btn btn-block" href="<?php echo $this->_aVars['sLink']; ?>" id="js_block_bottom_link_<?php echo $this->_aPhpfoxVars['iteration']['block']; ?>"><?php echo $this->_aVars['sPhrase']; ?></a>
<?php endif; ?>
<?php endforeach; endif; ?>
<?php else: ?>
		<ul>
<?php if (count((array)$this->_aVars['aFooter'])):  $this->_aPhpfoxVars['iteration']['block'] = 0;  foreach ((array) $this->_aVars['aFooter'] as $this->_aVars['sPhrase'] => $this->_aVars['sLink']):  $this->_aPhpfoxVars['iteration']['block']++; ?>

				<li id="js_block_bottom_<?php echo $this->_aPhpfoxVars['iteration']['block']; ?>"<?php if ($this->_aPhpfoxVars['iteration']['block'] == 1): ?> class="first"<?php endif; ?>>
<?php if ($this->_aVars['sLink'] == '#'): ?>
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('theme' => 'ajax/add.gif','class' => 'ajax_image')); ?>
<?php endif; ?>
					<a href="<?php echo $this->_aVars['sLink']; ?>" id="js_block_bottom_link_<?php echo $this->_aPhpfoxVars['iteration']['block']; ?>"><?php echo $this->_aVars['sPhrase']; ?></a>
				</li>
<?php endforeach; endif; ?>
		</ul>
<?php endif; ?>
	</div>
<?php endif; ?>
</div>
<?php endif;  unset($this->_aVars['sHeader'], $this->_aVars['sComponent'], $this->_aVars['aFooter'], $this->_aVars['sBlockBorderJsId'], $this->_aVars['bBlockDisableSort'], $this->_aVars['bBlockCanMove'], $this->_aVars['aEditBar'], $this->_aVars['sDeleteBlock'], $this->_aVars['sBlockTitleBar'], $this->_aVars['sBlockJsId'], $this->_aVars['sCustomClassName'], $this->_aVars['aMenu']); ?>
