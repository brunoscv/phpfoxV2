<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 4:57 pm */ ?>
<?php

 if (count ( $this->_aVars['aNewsletters'] )): ?>
<div class="panel panel-default">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="w20"></th>
                    <th><?php echo _p('subject'); ?></th>
                    <th><?php echo _p('user'); ?></th>
                    <th><?php echo _p('added'); ?></th>
                    <th><?php echo _p('process__l'); ?></th>
                    <th class="w120"><?php echo _p('status__l'); ?></th>
                </tr>
            </thead>
            <tbody>
<?php if (count((array)$this->_aVars['aNewsletters'])):  $this->_aPhpfoxVars['iteration']['newsletters'] = 0;  foreach ((array) $this->_aVars['aNewsletters'] as $this->_aVars['iKey'] => $this->_aVars['aNewsletter']):  $this->_aPhpfoxVars['iteration']['newsletters']++; ?>

            <tr id="js_newsletter_<?php echo $this->_aVars['aNewsletter']['newsletter_id']; ?>">
            <td class="t_center">
                <a class="js_drop_down_link" title="Manage"></a>
                <div class="link_menu">
                    <ul class="dropdown-menu">
<?php if ($this->_aVars['aNewsletter']['state'] == CORE_NEWSLETTER_STATUS_DRAFT): ?>
                            <li><a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.newsletter.add', array('newsletter_id' => $this->_aVars['aNewsletter']['newsletter_id'])); ?>"><?php echo _p('edit_newsletter'); ?></a></li>
                            <li><a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.newsletter.add', array('job' => $this->_aVars['aNewsletter']['newsletter_id'])); ?>" title="<?php echo _p('process_newsletter'); ?>"><?php echo _p('process_newsletter'); ?></a></li>
<?php endif; ?>
<?php if ($this->_aVars['aNewsletter']['state'] == CORE_NEWSLETTER_STATUS_COMPLETED): ?>
                            <li><a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.newsletter.add', array('job' => $this->_aVars['aNewsletter']['newsletter_id'])); ?>" title="<?php echo _p('resend_newsletter'); ?>"><?php echo _p('resend_newsletter'); ?></a></li>
<?php endif; ?>
                            <li><a class="popup" href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.newsletter.view', array('id' => $this->_aVars['aNewsletter']['newsletter_id'])); ?>" title="<?php echo _p('view_newsletter'); ?>"><?php echo _p('view_newsletter'); ?></a></li>
<?php if ($this->_aVars['aNewsletter']['state'] != CORE_NEWSLETTER_STATUS_IN_PROGRESS): ?>
                            <li><a class="sJsConfirm" data-message="<?php echo _p('are_you_sure_you_want_to_delete_this_newsletter_permanently', array('phpfox_squote' => true)); ?>" href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.newsletter', array('delete' => $this->_aVars['aNewsletter']['newsletter_id'])); ?>" title="<?php echo _p('delete_newsletter_subject', array('subject' => Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aNewsletter']['subject'])))); ?>"><?php echo _p('delete_newsletter'); ?></a></li>
<?php else: ?>
                            <li><a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.newsletter.add', array('job' => $this->_aVars['aNewsletter']['newsletter_id'])); ?>" title="<?php echo _p('reprocess_newsletter'); ?>"><?php echo _p('reprocess_newsletter'); ?></a></li>
                            <li><a class="sJsConfirm" data-message="<?php echo _p('are_you_sure_you_want_to_stop_this_newsletter_now', array('phpfox_squote' => true)); ?>" href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('admincp.newsletter', array('stop' => $this->_aVars['aNewsletter']['newsletter_id'])); ?>" title="<?php echo _p('stop_newsletter_subject', array('subject' => Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aNewsletter']['subject'])))); ?>"><?php echo _p('stop_newsletter'); ?></a></li>
<?php endif; ?>
                    </ul>
                </div>
            </td>
            <td><?php echo $this->_aVars['aNewsletter']['subject']; ?></td>
            <td><?php echo '<span class="user_profile_link_span" id="js_user_name_link_' . Phpfox::getService('user')->getUserName($this->_aVars['aNewsletter']['user_id'], $this->_aVars['aNewsletter']['user_name']) . '">' . (Phpfox::getService('user.block')->isBlocked(null, $this->_aVars['aNewsletter']['user_id']) ? '' : '<a href="' . Phpfox::getLib('phpfox.url')->makeUrl('profile', array($this->_aVars['aNewsletter']['user_name'], ((empty($this->_aVars['aNewsletter']['user_name']) && isset($this->_aVars['aNewsletter']['profile_page_id'])) ? $this->_aVars['aNewsletter']['profile_page_id'] : null))) . '">') . '' . Phpfox::getLib('phpfox.parse.output')->shorten(Phpfox::getLib('parse.output')->clean(Phpfox::getService('user')->getCurrentName($this->_aVars['aNewsletter']['user_id'], $this->_aVars['aNewsletter']['full_name'])), 0) . '' . (Phpfox::getService('user.block')->isBlocked(null, $this->_aVars['aNewsletter']['user_id']) ? '' : '</a>') . '</span>'; ?></td>
            <td><?php echo Phpfox::getTime(Phpfox::getParam('core.global_update_time'), $this->_aVars['aNewsletter']['time_stamp']); ?></td>
            <td><?php if ($this->_aVars['aNewsletter']['state'] == CORE_NEWSLETTER_STATUS_DRAFT):  echo _p('none');  else:  echo $this->_aVars['aNewsletter']['total_sent']; ?>/<?php echo $this->_aVars['aNewsletter']['total_users']; ?> <?php echo _p('sent_emails');  endif; ?></td>
            <td>
<?php if ($this->_aVars['aNewsletter']['state'] == CORE_NEWSLETTER_STATUS_DRAFT): ?>
                    <span class="label label-info"><?php echo _p('not_started'); ?></span>
<?php elseif ($this->_aVars['aNewsletter']['state'] == CORE_NEWSLETTER_STATUS_IN_PROGRESS): ?>
                    <span class="label label-warning"><?php echo _p('sending'); ?></span>
<?php else: ?>
                    <span class="label label-success"><?php echo _p('completed'); ?></span>
<?php endif; ?>
            </td>
            </tr>
<?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
    <div class="alert alert-danger">
<?php echo _p('no_newsletters_to_show'); ?>
    </div>
<?php endif; ?>

