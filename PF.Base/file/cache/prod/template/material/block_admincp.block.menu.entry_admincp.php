<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 4:53 pm */ ?>
<tr>
	<td class="drag_handle w30">
		<input type="hidden" name="val[<?php echo $this->_aVars['aMenu']['menu_id']; ?>][ordering]" value="<?php echo $this->_aVars['aMenu']['ordering']; ?>" size="3" class="t_center" />
	</td>
	<td class="w200"><?php echo $this->_aVars['aMenu']['name']; ?></td>
	<td><?php echo $this->_aVars['aMenu']['url_value']; ?></td>
    <td class="on_off w30">
        <div class="js_item_is_active <?php if (! $this->_aVars['aMenu']['is_active']): ?>hide<?php endif; ?>">
            <a href="#?call=admincp.updateMenuActivity&amp;id=<?php echo $this->_aVars['aMenu']['menu_id']; ?>&amp;active=0" class="js_item_active_link" title="<?php echo _p('deactivate'); ?>"></a>
        </div>
        <div class="js_item_is_not_active <?php if ($this->_aVars['aMenu']['is_active']): ?>hide<?php endif; ?>">
            <a href="#?call=admincp.updateMenuActivity&amp;id=<?php echo $this->_aVars['aMenu']['menu_id']; ?>&amp;active=1" class="js_item_active_link" title="<?php echo _p('activate'); ?>"></a>
        </div>
    </td>
    <td class="w80 t_center">
        <a class="js_drop_down_link" role="button"></a>
        <div class="link_menu">
            <ul class="dropdown-menu text-left dropdown-menu-right">
                <li><a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.menu.add.', array('id' => $this->_aVars['aMenu']['menu_id'])); ?>" class="popup"><?php echo _p('edit'); ?></a></li>
                <li><a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.menu.', array('delete' => $this->_aVars['aMenu']['menu_id'])); ?>" class="sJsConfirm"><?php echo _p('delete'); ?></a></li>
            </ul>
        </div>
    </td>
</tr>
