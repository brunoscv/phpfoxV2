<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:02 pm */ ?>
<?php
/**
 * [PHPFOX_HEADER]
 *
 */



 if (! count ( $this->_aVars['aEvents'] )):  if (! PHPFOX_IS_AJAX): ?>
<div class="extra_info">
<?php echo _p('no_events_found'); ?>
</div>
<?php endif;  else:  if (! PHPFOX_IS_AJAX): ?>
<div class="event-container">
<?php endif;  if ($this->_aVars['bIsGroupByDate']): ?>
<?php if (count((array)$this->_aVars['aEvents'])):  foreach ((array) $this->_aVars['aEvents'] as $this->_aVars['sDate'] => $this->_aVars['aGroups']): ?>
<?php if (count((array)$this->_aVars['aGroups'])):  $this->_aPhpfoxVars['iteration']['events'] = 0;  foreach ((array) $this->_aVars['aGroups'] as $this->_aVars['aEvent']):  $this->_aPhpfoxVars['iteration']['events']++; ?>

            <?php
						Phpfox::getLib('template')->getBuiltFile('event.block.item');
						?>
<?php endforeach; endif; ?>
<?php endforeach; endif;  else: ?>
<?php if (count((array)$this->_aVars['aEvents'])):  $this->_aPhpfoxVars['iteration']['events'] = 0;  foreach ((array) $this->_aVars['aEvents'] as $this->_aVars['aEvent']):  $this->_aPhpfoxVars['iteration']['events']++; ?>

        <?php
						Phpfox::getLib('template')->getBuiltFile('event.block.item');
						?>
<?php endforeach; endif;  endif;  if (!isset($this->_aVars['aPager'])): Phpfox::getLib('pager')->set(array('page' => Phpfox::getLib('request')->getInt('page'), 'size' => Phpfox::getLib('search')->getDisplay(), 'count' => Phpfox::getLib('search')->getCount())); endif;  $this->getLayout('pager'); ?>
<!--		end foreach2-->
<?php if (! PHPFOX_IS_AJAX): ?>
</div>
<?php endif;  if ($this->_aVars['bShowModerator']): ?>
<?php Phpfox::getBlock('core.moderation');  endif; ?>

<?php endif; ?>

