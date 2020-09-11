<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */
defined('PHPFOX') or exit('NO DICE!');
?>
<div class="block event-mini-block-container" style="position: relative">
    <div class="title">{_p var='Verified Social'}</div>
    <div class="content">
        <div class="event-mini-block-content">
            <?php
            /**
             * @copyright		[FOXEXPERT_COPYRIGHT]
             * @author  		Belan Ivan
             * @package  		App_Socialconnect
             */
            ?>
            {literal}
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
            {/literal}
            <div style="margin-bottom: 10px;">
                {_p var='This service is for allowing your login/import contacts and social publish using connected services'}.
            </div>
            {if !empty($aConnections)}
            <div class="table">
                {foreach from=$aConnections item=aConnection}
                    {if empty($aConnection.connected)}
                        <div class="table_tr">
                            <div class="table_cell">
                                {if !empty($aConnection.image_path)}
                                <img src="{$aConnection.image_path}" style="max-width: 32px;"/>
                                {else}
                                <img src="{$social_path}{$aConnection.adapter}.png" style="max-width: 32px;" />
                                {/if}
                            </div>
                            <div class="table_cell">
                                <h3>
                                    {$aConnection.adapter}
                                </h3>
                            </div>
                            <div class="table_cell">
                                {if !empty($aConnection.connected)}
                                <a href="{url link='socialconnect'}?disconnect={$aConnection.adapter}" class="button btn btn-primary btn-gradient">
                                    {_p var='Disconnect'}
                                </a>
                                {else}
                                <a  style="zoom:0.85;" href="{if $aConnection.adapter == 'Vkontakte' or $aConnection.adapter == 'LinkedIn' or $aConnection.adapter == 'Odnoklassniki'}{$indexUrl}{$aConnection.adapter|strtolower}{else}{url link='socialconnect'}{$aConnection.adapter|strtolower}{/if}" class="no_ajax button btn btn-primary btn-gradient">
                                    <i class="fa fa-plug"></i>
                                </a>
                                {/if}
                            </div>
                        </div>
                    {/if}
                {/foreach}
            </div>
            {else}
                {_p var='There are no available connections'}
            {/if}
        </div>
    </div>
</div>