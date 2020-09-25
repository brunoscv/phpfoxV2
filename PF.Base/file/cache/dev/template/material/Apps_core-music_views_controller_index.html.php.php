<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 25, 2020, 7:47 pm */ ?>
<?php 
    
?>

<?php if (! PHPFOX_IS_AJAX && isset ( $this->_aVars['bSpecialMenu'] ) && $this->_aVars['bSpecialMenu'] == true): ?>
    <?php
						Phpfox::getLib('template')->getBuiltFile('music.block.specialmenu');
						?>
<?php endif; ?>
<?php if (count ( $this->_aVars['aSongs'] )): ?>
<?php if (! PHPFOX_IS_AJAX): ?><div class="item-container music-listing"><?php endif; ?>
<?php if (count((array)$this->_aVars['aSongs'])):  $this->_aPhpfoxVars['iteration']['songs'] = 0;  foreach ((array) $this->_aVars['aSongs'] as $this->_aVars['aSong']):  $this->_aPhpfoxVars['iteration']['songs']++; ?>

            <?php
						Phpfox::getLib('template')->getBuiltFile('music.block.rows');
						?>
<?php endforeach; endif; ?>
<?php if ($this->_aVars['bShowModerator']): ?>
<?php Phpfox::getBlock('core.moderation'); ?>
<?php endif; ?>
<?php if (!isset($this->_aVars['aPager'])): Phpfox::getLib('pager')->set(array('page' => Phpfox::getLib('request')->getInt('page'), 'size' => Phpfox::getLib('search')->getDisplay(), 'count' => Phpfox::getLib('search')->getCount())); endif;  $this->getLayout('pager'); ?>
<?php if (! PHPFOX_IS_AJAX): ?></div><?php endif; ?>
<?php else: ?>
<?php if (! PHPFOX_IS_AJAX): ?>
        <div class="extra_info">
<?php echo _p('no_songs_found'); ?>
        </div>
<?php endif; ?>
<?php endif; ?>

