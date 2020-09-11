<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 5:02 pm */ ?>
<?php 

 if ($this->_aVars['bShowCategories']): ?>
<?php if (count ( $this->_aVars['aCategories'] )): ?>
<?php if (count((array)$this->_aVars['aCategories'])):  foreach ((array) $this->_aVars['aCategories'] as $this->_aVars['aCategory']): ?>
<?php if ($this->_aVars['aCategory']['pages']): ?>
            <div class="block_clear">
                <div class="item-page-title-block">
                    <a class="item-title" href="<?php echo $this->_aVars['aCategory']['link']; ?>">
<?php if (Phpfox ::isPhrase($this->_aVars['aCategory']['name'])): ?>
<?php echo _p($this->_aVars['aCategory']['name']); ?>
<?php else: ?>
<?php echo Phpfox::getLib('locale')->convert($this->_aVars['aCategory']['name']); ?>
<?php endif; ?>
                    </a>
                    <a href="#item-collapse-page-grid-<?php echo $this->_aVars['aCategory']['type_id']; ?>" data-toggle="collapse" class="item-collapse-icon"><span class="ico ico-angle-right"></span></a>
                </div>
                <div class="content clearfix">
                    <div class="item-container page-listing page-home collapse in" id="item-collapse-page-grid-<?php echo $this->_aVars['aCategory']['type_id']; ?>">
<?php if (count((array)$this->_aVars['aCategory']['pages'])):  foreach ((array) $this->_aVars['aCategory']['pages'] as $this->_aVars['aPage']): ?>
                        <article class="page-item" data-url="<?php echo $this->_aVars['aPage']['link']; ?>" data-uid="pages_<?php echo $this->_aVars['aPage']['page_id']; ?>" id="pages_<?php echo $this->_aVars['aPage']['page_id']; ?>">
                            <div class="item-outer">
<?php if ($this->_aVars['bIsModerator']): ?>
                                    <div class="moderation_row">
                                        <label class="item-checkbox">
                                            <input type="checkbox" class="js_global_item_moderate" name="item_moderate[]" value="<?php echo $this->_aVars['aPage']['page_id']; ?>" id="check<?php echo $this->_aVars['aPage']['page_id']; ?>" />
                                            <i class="ico ico-square-o"></i>
                                        </label>
                                    </div>
<?php endif; ?>
                                <div class="page-photo">
                                    <a href="<?php echo $this->_aVars['aPage']['link']; ?>">
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('server_id' => $this->_aVars['aPage']['profile_server_id'],'title' => $this->_aVars['aPage']['title'],'path' => 'pages.url_image','file' => $this->_aVars['aPage']['image_path'],'suffix' => '_200_square','max_width' => '200','max_height' => '200','is_page_image' => true)); ?>
                                    </a>
                                    <div class="item-icon">
                                        <div class="item-icon-liked btn-default" title="<?php echo _p('liked'); ?>" <?php if (empty ( $this->_aVars['aPage']['is_liked'] )): ?>style="display:none"<?php endif; ?>>
                                            <span class="ico ico-check"></span>
                                        </div>
                                        <div class="item-icon-like btn-primary btn-gradient" role="button" data-app="core_pages" data-action-type="click" data-action="like_page" data-id="<?php echo $this->_aVars['aPage']['page_id']; ?>" <?php if (! empty ( $this->_aVars['aPage']['is_liked'] )): ?>style="display:none"<?php endif; ?>>
                                            <span class="ico ico-plus"></span>
                                        </div>
                                    </div>
                                    <!-- desc grid view mode -->
                                    <a class="item-desc" href="<?php echo $this->_aVars['aPage']['link']; ?>">
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
                                            <a href="<?php echo $this->_aVars['aPage']['link']; ?>" class="link pages_title"><?php echo Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aPage']['title'])); ?></a>
                                        </span>
                                    </div>

                                    <div class="item-number-like">
<?php if ($this->_aVars['aPage']['total_like'] != 1): ?>
<?php echo _p('pages_total_likes', array('total' => $this->_aVars['aPage']['total_like'])); ?>
<?php else: ?>
<?php echo _p('pages_total_like', array('total' => $this->_aVars['aPage']['total_like'])); ?>
<?php endif; ?>
                                    </div>

<?php if ($this->_aVars['aPage']['showItemActions']): ?>
                                    <!-- please condition when show -->
                                    <div class="item-option page-button-option">
                                        <div class="dropdown">
                                            <a class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i class="ico ico-gear-o"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right" id="js_page_entry_options_<?php echo $this->_aVars['aPage']['page_id']; ?>">
                                                <?php
						Phpfox::getLib('template')->getBuiltFile('pages.block.link');
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
                        <article class="page-item">
                            <a class="remain_pages" href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('pages.category');  echo $this->_aVars['aCategory']['type_id']; ?>/<?php echo _p($this->_aVars['aCategory']['name']); ?>/<?php if ($this->_aVars['sView']): ?>view_<?php echo $this->_aVars['sView'];  endif; ?>" title="<?php echo _p($this->_aVars['aCategory']['name']); ?>">
                                <span class=" page-item-viewall "
<?php if (! empty ( $this->_aVars['aCategory']['image_path'] )): ?>
                                          style="background: url(<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('server_id' => $this->_aVars['aCategory']['image_server_id'],'path' => 'core.path_actual','file' => $this->_aVars['aCategory']['image_path'],'suffix' => '_200','return_url' => true)); ?>)"
<?php else: ?>
                                          style="background-image: url('<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('path' => 'core.path_actual','file' => 'PF.Site/Apps/core-pages/assets/img/default-category/default_category.png','return_url' => true)); ?>')"
<?php endif; ?>
                                >
<?php if ($this->_aVars['aCategory']['image_path']): ?>
                                    <div class="overlay"></div>
<?php endif; ?>
                                    <span class="page-item-view-all"><?php echo _p('view_all'); ?></span>
                                    <span class="page-item-remain-number">+<?php echo $this->_aVars['aCategory']['remain_pages']; ?></span>
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
<?php if ($this->_aVars['iCountPage'] == 0): ?>
    <p class="extra_info">
<?php echo _p('no_pages_found'); ?>
    </p>
<?php endif;  else: ?>

<?php if (count ( $this->_aVars['aPages'] )):  if ($this->_aVars['sView'] == 'my' && Phpfox ::getUserBy('profile_page_id')): ?>
<div class="message">
<?php echo _p('note_that_pages_displayed_here_are_pages_created_by_the_page', array('global_full_name' => Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['sGlobalUserFullName'])),'profile_full_name' => Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aGlobalProfilePageLogin']['full_name'])))); ?>
</div>
<?php endif;  if (! PHPFOX_IS_AJAX): ?>
<div class="item-container pages-items page-listing page-result">
<?php endif; ?>
<?php if (count((array)$this->_aVars['aPages'])):  foreach ((array) $this->_aVars['aPages'] as $this->_aVars['aPage']): ?>
    <article class="page-item" data-url="<?php echo $this->_aVars['aPage']['url']; ?>" data-uid="pages_<?php echo $this->_aVars['aPage']['page_id']; ?>" id="pages_<?php echo $this->_aVars['aPage']['page_id']; ?>">
        <div class="item-outer">
<?php if ($this->_aVars['bIsModerator']): ?>
                <div class="moderation_row">
                    <label class="item-checkbox">
                        <input type="checkbox" class="js_global_item_moderate" name="item_moderate[]" value="<?php echo $this->_aVars['aPage']['page_id']; ?>" id="check<?php echo $this->_aVars['aPage']['page_id']; ?>" />
                        <i class="ico ico-square-o"></i>
                    </label>
                </div>
<?php endif; ?>
            <a class="page-photo" href="<?php echo $this->_aVars['aPage']['url']; ?>">
<?php echo Phpfox::getLib('phpfox.image.helper')->display(array('server_id' => $this->_aVars['aPage']['profile_server_id'],'title' => $this->_aVars['aPage']['title'],'path' => 'pages.url_image','file' => $this->_aVars['aPage']['image_path'],'suffix' => '_200_square','fallback_suffix' => '_200','max_width' => '200','max_height' => '200','is_page_image' => true)); ?>
               
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
                        <a href="<?php echo $this->_aVars['aPage']['url']; ?>" class="link pages_title "><?php echo Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean($this->_aVars['aPage']['title'])); ?></a>
                    </span>
                </div>
                <div class="item-info">
                    <span class="item-number-like"><?php if ($this->_aVars['aPage']['total_like'] != 1):  echo _p('pages_total_likes', array('total' => $this->_aVars['aPage']['total_like']));  else:  echo _p('pages_total_like', array('total' => $this->_aVars['aPage']['total_like']));  endif; ?></span>
<?php if ($this->_aVars['aPage']['category_name']): ?>
                        <a href="<?php echo $this->_aVars['aPage']['category_link']; ?>" class="item-category">
<?php echo _p($this->_aVars['aPage']['category_name']); ?>
                        </a>
<?php else: ?>
                        <a href="<?php echo $this->_aVars['aPage']['type_link']; ?>" class="item-category">
<?php echo _p($this->_aVars['aPage']['type_name']); ?>
                        </a>
<?php endif; ?>
                </div>
                
                <div class="item-desc">
                    <div class="item-desc-main"><?php echo Phpfox::getLib('phpfox.parse.output')->cleanPhrases(Phpfox::getLib('phpfox.parse.output')->clean(Phpfox::getLib('phpfox.parse.bbcode')->stripCode(strip_tags($this->_aVars['aPage']['text_parsed'])))); ?></div>
                </div>
<?php if ($this->_aVars['aPage']['showItemActions']): ?>
                    <div class="item-option page-button-option">
                        <div class="dropdown">
                            <a class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="ico ico-gear-o"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" id="js_page_entry_options_<?php echo $this->_aVars['aPage']['page_id']; ?>">
                                <?php
						Phpfox::getLib('template')->getBuiltFile('pages.block.link');
						?>
                            </ul>
                        </div>
                    </div>
<?php endif; ?>
                <div class="item-group-icon-users">
                    <div class="item-icon">
<?php if (! empty ( $this->_aVars['aPage']['is_liked'] )): ?>
                        <a role="button" class="btn btn-default btn-icon item-icon-liked" data-toggle="dropdown">
                            <span class="ico ico-thumbup"></span><?php echo _p('liked'); ?><span class="ml-1 ico ico-caret-down"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a role="button" onclick="$.ajaxCall('like.delete', 'type_id=pages&item_id=<?php echo $this->_aVars['aPage']['page_id']; ?>&reload=1');">
                                    <span class="mr-1 ico ico-thumbdown"></span><?php echo _p('unlike'); ?>
                                </a>
                            </li>
                        </ul>
<?php else: ?>
                        <button class="btn btn-primary btn-gradient btn-icon item-icon-like" onclick="$.ajaxCall('like.add', 'type_id=pages&item_id=<?php echo $this->_aVars['aPage']['page_id']; ?>&reload=1');">
                            <span class="ico ico-thumbup-o"></span><?php echo _p('like'); ?>
                        </button>
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
                                <a href="<?php echo $this->_aVars['aPage']['url']; ?>members" class="item-members-viewall"><span>+<?php echo $this->_aVars['aPage']['remain_members']; ?></span></a>
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
<?php if (!isset($this->_aVars['aPager'])): Phpfox::getLib('pager')->set(array('page' => Phpfox::getLib('request')->getInt('page'), 'size' => Phpfox::getLib('search')->getDisplay(), 'count' => Phpfox::getLib('search')->getCount())); endif;  $this->getLayout('pager');  if (! PHPFOX_IS_AJAX): ?>
</div>
<?php endif; ?>

<?php else:  if (! PHPFOX_IS_AJAX): ?>
<p class="extra_info">
<?php echo _p('no_pages_found'); ?>
</p>
<?php endif;  endif;  endif;  if ($this->_aVars['bIsModerator']):  Phpfox::getBlock('core.moderation');  endif; ?>

