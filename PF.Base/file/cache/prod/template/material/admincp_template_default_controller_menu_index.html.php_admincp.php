<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 4:53 pm */ ?>
<?php 

?>

<form method="post" action="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.menu', array('parent' => $this->_aVars['iParentId'])); ?>" class="form">
<?php if ($this->_aVars['iParentId'] === 0): ?>

<?php if (count((array)$this->_aVars['aMenus'])):  foreach ((array) $this->_aVars['aMenus'] as $this->_aVars['sType'] => $this->_aVars['aMenusSub']): ?>
    <div class="panel panel-default">
        <div class="panel-heading">Menu: <strong><?php echo $this->_aVars['sType']; ?></strong></div>
        <div class="table-responsive">
            <table class="table table-bordered table-admin" id="js_drag_drop_<?php echo $this->_aVars['sType']; ?>">
                <thead>
                <tr>
                    <th></th>
                    <th><?php echo _p("name"); ?></th>
                    <th><?php echo _p("url"); ?></th>
                    <th>
<?php echo _p("active"); ?>
                    </th>
                    <th class="t_center"><?php echo _p('settings'); ?></th>
                </tr>
                </thead>
                <tbody>
<?php if (count((array)$this->_aVars['aMenusSub'])):  foreach ((array) $this->_aVars['aMenusSub'] as $this->_aVars['iKey'] => $this->_aVars['aMenu']): ?>
                <?php
						Phpfox::getLib('template')->getBuiltFile('admincp.block.menu.entry');
						?>
<?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endforeach; endif; ?>
<?php endif; ?>

</form>

