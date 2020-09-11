<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:00 pm */ ?>
<?php 
/**
 * [PHPFOX_HEADER]
 * 
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		phpFox LLC
 * @package  		Module_Page
 * @version 		$Id: index.html.php 1194 2009-10-18 12:43:38Z phpFox LLC $
 */
 
 

 if (count ( $this->_aVars['aPages'] )): ?>
<form class="form" method="post" action="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.page'); ?>">
    <div class="table-responsive">
        <table class="table table-admin">
            <thead>
                <th class="w60">ID</th>
                <th><?php echo _p('title'); ?></th>
                <th class="w100"><?php echo _p('options'); ?></th>
            </thead>
            <tbody>
<?php if (count((array)$this->_aVars['aPages'])):  foreach ((array) $this->_aVars['aPages'] as $this->_aVars['iKey'] => $this->_aVars['aPage']): ?>
                <tr class="checkRow<?php if (is_int ( $this->_aVars['iKey'] / 2 )): ?> tr<?php else:  endif; ?>">
                    <td>
<?php echo $this->_aVars['aPage']['page_id']; ?>
                    </td>
                    <td><a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl($this->_aVars['aPage']['title_url']); ?>" class="targetBlank <?php if (! $this->_aVars['aPage']['is_active']): ?>inactive_page<?php endif; ?>" <?php if (! $this->_aVars['aPage']['is_active']): ?> title="<?php echo _p('inactive_page'); ?>"<?php endif; ?>><?php if ($this->_aVars['aPage']['is_phrase']):  echo _p($this->_aVars['aPage']['title']);  else:  echo $this->_aVars['aPage']['title'];  endif; ?></a></td>
                    <td>
                        <a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.page.add.', array('id' => $this->_aVars['aPage']['page_id'])); ?>" class="is_edit"><?php echo _p('edit'); ?></a>
                        &middot;
                        <a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.page.', array('delete' => $this->_aVars['aPage']['page_id'])); ?>" class="is_delete sJsConfirm" data-message="<?php echo _p('are_you_sure_you_want_to_delete_this_page_permanently'); ?>"><?php echo _p('delete'); ?></a>
                    </td>
                </tr>
<?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>

</form>

<?php else:  echo _p('no_pages_have_been_added');  endif; ?>
