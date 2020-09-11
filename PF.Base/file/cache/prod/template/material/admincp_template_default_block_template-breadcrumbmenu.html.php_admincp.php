<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 4:57 pm */ ?>
<?php if (isset ( $this->_aVars['aAdmincpBreadCrumb'] ) && ! empty ( $this->_aVars['aAdmincpBreadCrumb'] )): ?>
<?php if (count((array)$this->_aVars['aAdmincpBreadCrumb'])):  foreach ((array) $this->_aVars['aAdmincpBreadCrumb'] as $this->_aVars['sUrl'] => $this->_aVars['sPhrase']): ?>
    <a class="child" href="<?php echo $this->_aVars['sUrl']; ?>"><?php echo $this->_aVars['sPhrase']; ?></a>
<?php endforeach; endif;  else: ?>
    <a class="child" href=""><?php echo $this->_aVars['sSectionTitle']; ?></a>
<?php endif; ?>
