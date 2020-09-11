<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:02 pm */ ?>
<?php

 if (! empty ( $this->_aVars['bShowCategories'] )): ?>
<?php if (count ( $this->_aVars['aCategories'] )): ?>
<?php if (count((array)$this->_aVars['aCategories'])):  foreach ((array) $this->_aVars['aCategories'] as $this->_aVars['aCategory']): ?>
<?php if ($this->_aVars['aCategory']['pages']): ?>
                <div class="block_clear">
                    <div class="item-group-title-block">
                        <a class="item-title" href="<?php echo $this->_aVars['aCategory']['link']; ?>">
<?php echo _p($this->_aVars['aCategory']['name']); ?>
                        </a>
                        <a href="#item-collapse-group-grid-<?php echo $this->_aVars['aCategory']['type_id']; ?>" data-toggle="collapse" class="item-collapse-icon"><span class="ico ico-angle-right"></span></a>
                    </div>
                    <div class="content clearfix">
                        <div class="group-listing item-container group-home collapse in" id="item-collapse-group-grid-<?php echo $this->_aVars['aCategory']['type_id']; ?>">
<?php if (count((array)$this->_aVars['aCategory']['pages'])):  foreach ((array) $this->_aVars['aCategory']['pages'] as $this->_aVars['aPage']): ?>
                                <article class="group-item" data-url="<?php echo $this->_aVars['aPage']['link']; ?>" data-uid="groups_<?php echo $this->_aVars['aPage']['page_id']; ?>" id="groups_<?php echo $this->_aVars['aPage']['page_id']; ?>">
                                    <div class="item-outer">
<?php if (! empty ( $this->_aVars['bShowModeration'] )): ?>
                                            <div class="moderation_row">
                                                <label class="item-checkbox">
                                                    <input type="checkbox" class="js_global_item_moderate" name="item_moderate[]" value="<?php echo $this->_aVars['aPage']['page_id']; ?>" id="check<?php echo $this->_aVars['aPage']['page_id']; ?>" />
                                                    <i class="ico ico-square-o"></i>
                                                </label>
                                            </div>
<?php endif; ?>
                                        <div class="group-photo">
                                            <a href="<?php echo $this->_aVars['aPage']['link']; ?>">
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('server_id' => $this->_aVars['aPage']['profile_server_id'],'title' => $this->_aVars['aPage']['title'],'path' => 'pages.url_image','file' => $this->_aVars['aPage']['image_path'],'suffix' => '_200_square','max_width' => '200','max_height' => '200','is_page_image' => true)); ?>
                                            </a>
                                            <div class="item-icon">
                                                <div class="item-icon-joined btn-default" title="<?php echo _p('joined'); ?>" <?php if (empty ( $this->_aVars['aPage']['is_liked'] )): ?>style="display:none"<?php endif; ?>>
                                                    <span class="ico ico-check"></span>
                                                </div>
                                                <div class="item-icon-joined btn-default" <?php if (! empty ( $this->_aVars['aPage']['is_liked'] ) || ! $this->_aVars['aPage']['joinRequested']): ?>style="display:none"<?php endif; ?>>
                                                    <span class="ico ico-sandclock-goingon-o"></span>
                                                </div>
                                                <div class="item-icon-join btn-primary btn-gradient" role="button" data-app="core_groups" data-id="<?php echo $this->_aVars['aPage']['page_id']; ?>" data-action="join_group" data-is-closed="<?php echo $this->_aVars['aPage']['reg_method']; ?>" data-action-type="click" <?php if (! empty ( $this->_aVars['aPage']['is_liked'] ) || $this->_aVars['aPage']['joinRequested']): ?>style="display:none"<?php endif; ?>>
                                                    <span class="ico ico-plus"></span>
                                                </div>
                                            </div>
                                            <!-- desc grid view mode -->
                                            <a href="<?php echo $this->_aVars['aPage']['link']; ?>" class="item-desc">
                                                <div class="item-desc-main"><?php echo Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean(Phpfox::getLib('phpfox.parse.bbcode')->stripCode(strip_tags($this->_aVars['aPage']['text_parsed'])))); ?></div>
                                            </a>
                                        </div>

                                        <div class="item-icon">
<?php if ($this->_aVars['aPage']['is_sponsor']): ?>
                                                <div class="sticky-label-icon sticky-sponsored-icon">
                                                    <span class="flag-style-arrow"></span>
                                                    <i class="ico ico-sponsor"></i>
                                                </div>
<?php endif; ?>
<?php if ($this->_aVars['aPage']['is_featured']): ?>
                                                <div class="sticky-label-icon sticky-featured-icon">
                                                    <span class="flag-style-arrow"></span>
                                                    <i class="ico ico-diamond"></i>
                                                </div>
<?php endif; ?>
<?php if (( $this->_aVars['sView'] == 'my' && $this->_aVars['aPage']['view_id'] == 1 )): ?>
                                                <div class="sticky-label-icon sticky-pending-icon">
                                                    <span class="flag-style-arrow"></span>
                                                    <i class="ico ico-clock-o"></i>
                                                </div>
<?php endif; ?>
                                        </div>
                                        <div class="item-inner">
                                            <div class="item-title">
                                                <span class="user_profile_link_span" id="js_user_name_link_<?php if (! empty ( $this->_aVars['aPage']['profile_user_id'] )):  echo $this->_aVars['aPage']['profile_user_id'];  endif; ?>">
                                                    <a href="<?php echo $this->_aVars['aPage']['link']; ?>" class="link pages_title "><?php echo Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aPage']['title'])); ?></a>
                                                </span>
                                            </div>

                                            <div class="item-number-member">
<?php if ($this->_aVars['aPage']['total_like'] != 1): ?>
<?php echo _p('groups_total_members', array('total' => $this->_aVars['aPage']['total_like'])); ?>
<?php else: ?>
<?php echo _p('groups_total_member', array('total' => $this->_aVars['aPage']['total_like'])); ?>
<?php endif; ?>
                                            </div>
<?php if ($this->_aVars['aPage']['bShowItemActions']): ?>
                                            <!-- please condition when show -->
                                            <div class="item-option group-button-option">
                                                <div class="dropdown">
                                                    <a class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        <i class="ico ico-gear-o"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-right" id="js_group_entry_options_<?php echo $this->_aVars['aPage']['page_id']; ?>">
                                                        <?php
						Phpfox::getLib('template')->getBuiltFile('groups.block.link');
						?>
                                                    </ul>
                                                </div>
                                            </div>
<?php endif; ?>
                                        </div>
                                    </div>
                                </article>
<?php endforeach; endif; ?>
<?php if (isset ( $this->_aVars['aCategory']['remain_pages'] ) && $this->_aVars['aCategory']['remain_pages']): ?>
                                <article class="group-item">
                                    <a class="remain_groups" href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('groups.category');  echo $this->_aVars['aCategory']['type_id']; ?>/<?php echo _p($this->_aVars['aCategory']['name']); ?>/<?php if ($this->_aVars['sView']): ?>view_<?php echo $this->_aVars['sView'];  endif; ?>" title="<?php echo _p($this->_aVars['aCategory']['name']); ?>">
                                        <span class="group-item-viewall"
<?php if (! empty ( $this->_aVars['aCategory']['image_path'] )): ?>
                                                  style="background: url(<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('server_id' => $this->_aVars['aCategory']['image_server_id'],'path' => 'core.path_actual','file' => $this->_aVars['aCategory']['image_path'],'suffix' => '_200','return_url' => true)); ?>)"
<?php else: ?>
                                                  style="background-image: url('<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('path' => 'core.path_actual','file' => 'PF.Site/Apps/core-groups/assets/img/default-category/default_category.png','return_url' => true)); ?>')"
<?php endif; ?>>
<?php if ($this->_aVars['aCategory']['image_path']): ?>
                                            <div class="overlay"></div>
<?php endif; ?>
                                            <span class="group-item-view-all"><?php echo _p('view_all'); ?></span>
                                            <span class="group-item-remain-number">+<?php echo $this->_aVars['aCategory']['remain_pages']; ?></span>
                                        </span>
                                    </a>
                                </article>
<?php endif; ?>
                        </div>
                    </div>
                </div>
<?php endif; ?>
<?php endforeach; endif; ?>
<?php endif; ?>
<?php if (! empty ( $this->_aVars['bShowModeration'] )): ?>
<?php Phpfox::getBlock('core.moderation'); ?>
<?php endif; ?>
<?php if ($this->_aVars['iCountPage'] == 0): ?>
        <div class="extra_info">
<?php echo _p('no_groups_found'); ?>
        </div>
<?php endif;  else: ?>
<?php if (count ( $this->_aVars['aPages'] )): ?>
<?php if ($this->_aVars['sView'] == 'my' && Phpfox ::getUserBy('profile_page_id')): ?>
            <div class="message">
<?php echo _p('Note that Groups displayed here are groups created by the Group ({{ global_full_name }}) and not by the parent user ({{ profile_full_name }}).', array('global_full_name' => Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['sGlobalUserFullName'])),'profile_full_name' => Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aGlobalProfilePageLogin']['full_name'])))); ?>
            </div>
<?php endif; ?>
<?php if (! PHPFOX_IS_AJAX): ?>
        <div class="item-container groups-items group-listing group-result">
<?php endif; ?>
<?php if (count((array)$this->_aVars['aPages'])):  foreach ((array) $this->_aVars['aPages'] as $this->_aVars['aPage']): ?>
            <article class="group-item" data-url="<?php echo $this->_aVars['aPage']['link']; ?>" data-uid="groups_<?php echo $this->_aVars['aPage']['page_id']; ?>" id="groups_<?php echo $this->_aVars['aPage']['page_id']; ?>">
                <div class="item-outer">
<?php if (! empty ( $this->_aVars['bShowModeration'] )): ?>
                    <div class="moderation_row">
                        <label class="item-checkbox">
                            <input type="checkbox" class="js_global_item_moderate" name="item_moderate[]" value="<?php echo $this->_aVars['aPage']['page_id']; ?>" id="check<?php echo $this->_aVars['aPage']['page_id']; ?>" />
                            <i class="ico ico-square-o"></i>
                        </label>
                    </div>
<?php endif; ?>
                    <a class="group-photo" href="<?php echo $this->_aVars['aPage']['link']; ?>">
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('server_id' => $this->_aVars['aPage']['profile_server_id'],'title' => $this->_aVars['aPage']['title'],'path' => 'pages.url_image','file' => $this->_aVars['aPage']['image_path'],'suffix' => '_200_square','max_width' => '200','max_height' => '200','is_page_image' => true)); ?>
                        <div class="item-icon">
<?php if ($this->_aVars['aPage']['is_sponsor']): ?>
                            <div class="sticky-label-icon sticky-sponsored-icon">
                                <span class="flag-style-arrow"></span>
                                <i class="ico ico-sponsor"></i>
                            </div>
<?php endif; ?>
<?php if ($this->_aVars['aPage']['is_featured']): ?>
                            <div class="sticky-label-icon sticky-featured-icon">
                                <span class="flag-style-arrow"></span>
                                <i class="ico ico-diamond"></i>
                            </div>
<?php endif; ?>
<?php if (( $this->_aVars['sView'] == 'my' && $this->_aVars['aPage']['view_id'] == 1 )): ?>
                                <div class="sticky-label-icon sticky-pending-icon">
                                    <span class="flag-style-arrow"></span>
                                    <i class="ico ico-clock-o"></i>
                                </div>
<?php endif; ?>
                        </div>
                    </a>
                    <div class="item-inner">
                        <div class="item-title">
                            <span class="user_profile_link_span" id="js_user_name_link_<?php if (! empty ( $this->_aVars['aPage']['profile_user_id'] )):  echo $this->_aVars['aPage']['profile_user_id'];  endif; ?>">
                                <a href="<?php echo $this->_aVars['aPage']['link']; ?>" class="link pages_title "><?php echo Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aPage']['title'])); ?></a>
                            </span>
                        </div>
                        <div class="item-info">
                            <span class="item-number-member"><?php if ($this->_aVars['aPage']['total_like'] != 1):  echo _p('groups_total_members', array('total' => $this->_aVars['aPage']['total_like']));  else:  echo _p('groups_total_member', array('total' => $this->_aVars['aPage']['total_like']));  endif; ?></span>
<?php if ($this->_aVars['aPage']['category_name']): ?>
                                <a href="<?php echo $this->_aVars['aPage']['category_link']; ?>" class="item-category"><?php echo _p($this->_aVars['aPage']['category_name']); ?></a>
<?php else: ?>
                                <a href="<?php echo $this->_aVars['aPage']['type_link']; ?>" class="item-category"><?php echo _p($this->_aVars['aPage']['type_name']); ?></a>
<?php endif; ?>
                        </div>
                        <div class="item-desc">
                            <div class="item-desc-main"><?php echo Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean(Phpfox::getLib('phpfox.parse.bbcode')->stripCode(strip_tags($this->_aVars['aPage']['text_parsed'])))); ?></div>
                        </div>
<?php if ($this->_aVars['aPage']['bShowItemActions']): ?>
                        <div class="item-option group-button-option">
                            <div class="dropdown">
                                <a class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="ico ico-gear-o"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right" id="js_page_entry_options_<?php echo $this->_aVars['aPage']['page_id']; ?>">
                                    <?php
						Phpfox::getLib('template')->getBuiltFile('groups.block.link');
						?>
                                </ul>
                            </div>
                        </div>
<?php endif; ?>
                        <div class="item-group-icon-users">
                            <div class="item-icon">
<?php if (! empty ( $this->_aVars['aPage']['is_liked'] )): ?>
                                <a data-toggle="dropdown" class="btn btn-default btn-icon item-icon-joined">
                                    <span class="ico ico-check"></span>
<?php echo _p('joined'); ?>
                                    <span class="ml-1 ico ico-caret-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a role="button" onclick="$.ajaxCall('like.delete', 'type_id=groups&item_id=<?php echo $this->_aVars['aPage']['page_id']; ?>&reload=1');">
                                            <span class="ico ico-close"></span>
<?php echo _p('unjoin'); ?>
                                        </a>
                                    </li>
                                </ul>
<?php else: ?>
<?php if (! $this->_aVars['aPage']['joinRequested']): ?>
                                    <button class="btn btn-primary btn-gradient btn-icon item-icon-join" onclick="$(this).remove(); <?php if ($this->_aVars['aPage']['reg_method'] == '1' && ! isset ( $this->_aVars['aPage']['is_invited'] )): ?> $.ajaxCall('groups.signup', 'page_id=<?php echo $this->_aVars['aPage']['page_id']; ?>'); <?php else: ?>$.ajaxCall('like.add', 'type_id=groups&amp;item_id=<?php echo $this->_aVars['aPage']['page_id']; ?>&amp;reload=1');<?php endif; ?> return false;">
                                        <span class="ico ico-plus"></span><?php echo _p('join'); ?>
                                    </button>
<?php else: ?>
                                    <span class="ico ico-sandclock-goingon-o"></span>
<?php endif; ?>
<?php endif; ?>
                            </div>
                            <!-- please show avatar user like page -->
<?php if ($this->_aVars['aPage']['total_members'] > 0): ?>
                                <div class="item-members">
<?php if (( $this->_aVars['aPage']['total_members'] - 4 ) > 0): ?>
<?php if (count((array)$this->_aVars['aPage']['members'])):  foreach ((array) $this->_aVars['aPage']['members'] as $this->_aVars['iKey'] => $this->_aVars['aMember']): ?>
<?php if ($this->_aVars['iKey'] < 3): ?>
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('user' => $this->_aVars['aMember'],'suffix' => '_50_square')); ?>
<?php endif; ?>
<?php endforeach; endif; ?>
                                        <a href="<?php echo $this->_aVars['aPage']['link']; ?>members" class="item-members-viewall"><span>+<?php echo $this->_aVars['aPage']['remain_members']; ?></span></a>
<?php else: ?>
<?php if (count((array)$this->_aVars['aPage']['members'])):  foreach ((array) $this->_aVars['aPage']['members'] as $this->_aVars['aMember']): ?>
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('user' => $this->_aVars['aMember'],'suffix' => '_50_square')); ?>
<?php endforeach; endif; ?>
<?php endif; ?>
                                </div>
<?php endif; ?>
                        </div>
                    </div>
                </div>
            </article>
<?php endforeach; endif; ?>
<?php if (!isset($this->_aVars['aPager'])): Phpfox::getLib('pager')->set(array('page' => Phpfox::getLib('request')->getInt('page'), 'size' => Phpfox::getLib('search')->getDisplay(), 'count' => Phpfox::getLib('search')->getCount())); endif;  $this->getLayout('pager'); ?>
<?php if (! PHPFOX_IS_AJAX): ?>
        </div>
<?php endif; ?>
<?php if (! empty ( $this->_aVars['bShowModeration'] )): ?>
<?php Phpfox::getBlock('core.moderation'); ?>
<?php endif; ?>
<?php else: ?>
<?php if (! PHPFOX_IS_AJAX): ?>
            <div class="extra_info">
<?php echo _p('no_groups_found'); ?>
            </div>
<?php endif; ?>
<?php endif;  endif; ?>
