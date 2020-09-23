<?php defined('PHPFOX') or exit('NO DICE!'); ?>
<?php /* Cached: September 11, 2020, 7:53 pm */ ?>
<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */

?>
<div class="block event-mini-block-container" style="position: relative">
    <div class="title"><?php echo _p('Verified Social'); ?></div>
    <div class="content">
        <div class="event-mini-block-content">
            <?php
            /**
             * @copyright		[FOXEXPERT_COPYRIGHT]
             * @author  		Belan Ivan
             * @package  		App_Socialconnect
             */
            ?>
            <?php echo '
            <style>
                #page_core_index-member .table_cell{
                    display: block;
                }
                #page_core_index-member .table_cell h3{
                   font-size: 14px;
                    border-bottom: 1px solid #2681d5;
                    padding-bottom: 7px;
                }
                #page_core_index-member .table{
                    display: table;
                    width: 100%;
                    margin-bottom: 0;
                }
                #page_core_index-member  .table_tr{
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }
                @media (max-width: 780px)  {
                    #page_core_index-member .table{
                        display: block;
                    }
                    #page_core_index-member .table_cell{
                        display: block;
                        overflow: hidden;
                    }
                }
            </style>
            '; ?>

            <div style="margin-bottom: 10px;">
<?php echo _p('This service is for allowing your login/import contacts and social publish using connected services'); ?>.
            </div>
<?php if (! empty ( $this->_aVars['aConnections'] )): ?>
            <div class="table">
<?php if (count((array)$this->_aVars['aConnections'])):  foreach ((array) $this->_aVars['aConnections'] as $this->_aVars['aConnection']): ?>
<?php if (empty ( $this->_aVars['aConnection']['connected'] )): ?>
                        <div class="table_tr">
                            <div class="table_cell">
<?php if (! empty ( $this->_aVars['aConnection']['image_path'] )): ?>
                                <img src="<?php echo $this->_aVars['aConnection']['image_path']; ?>" style="max-width: 32px;"/>
<?php else: ?>
                                <img src="<?php echo $this->_aVars['social_path'];  echo $this->_aVars['aConnection']['adapter']; ?>.png" style="max-width: 32px;" />
<?php endif; ?>
                            </div>
                            <div class="table_cell">
                                <h3>
<?php echo $this->_aVars['aConnection']['adapter']; ?>
                                </h3>
                            </div>
                            <div class="table_cell">
<?php if (! empty ( $this->_aVars['aConnection']['connected'] )): ?>
                                <a href="<?php echo Phpfox::getLib('phpfox.url')->makeUrl('socialconnect'); ?>?disconnect=<?php echo $this->_aVars['aConnection']['adapter']; ?>" class="button btn btn-primary btn-gradient">
<?php echo _p('Disconnect'); ?>
                                </a>
<?php else: ?>
                                <a  style="zoom:0.85;" href="<?php if ($this->_aVars['aConnection']['adapter'] == 'Vkontakte' || $this->_aVars['aConnection']['adapter'] == 'LinkedIn' || $this->_aVars['aConnection']['adapter'] == 'Odnoklassniki'):  echo $this->_aVars['indexUrl'];  echo strtolower($this->_aVars['aConnection']['adapter']);  else:  echo Phpfox::getLib('phpfox.url')->makeUrl('socialconnect');  echo strtolower($this->_aVars['aConnection']['adapter']);  endif; ?>" class="no_ajax button btn btn-primary btn-gradient">
                                    <i class="fa fa-plug"></i>
                                </a>
<?php endif; ?>
                            </div>
                        </div>
<?php endif; ?>
<?php endforeach; endif; ?>
            </div>
<?php else: ?>
<?php echo _p('There are no available connections'); ?>
<?php endif; ?>
        </div>
    </div>
</div>
