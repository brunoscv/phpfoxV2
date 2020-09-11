<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */
?>
{literal}
<style>
    #page_socialconnect_index .table_cell{
        display: table-cell;
        vertical-align: middle;
        padding: 10px 20px 10px 20px;
        border-bottom: 1px solid #eee;
    }
    #page_socialconnect_index .table_cell h3{
        display: table;
        border-bottom: 1px solid #2681d5;
        padding-bottom: 7px;
    }
    #page_socialconnect_index .table{
        display: table;
        width: 100%;
    }
   #page_socialconnect_index  .table_tr{
        display: table-row;
    }
    @media (max-width: 780px)  {
        #page_socialconnect_index .table{
            display: block;
        }
       #page_socialconnect_index .table_cell{
            display: block;
           overflow: hidden;
        }
        #page_socialconnect_index .table_tr{
            display: block;
        }
    }
</style>
{/literal}
<div style="margin-bottom: 20px;">
    {_p var='This service is for allowing your login/import contacts and social publish using connected services'}.
</div>
{if !empty($aConnections)}
    <div class="table">
        {foreach from=$aConnections item=aConnection}
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
                    <div>
                        {if empty($aConnection.connected)}
                            {_p var='By connecting your account, you acknowledge and agree that the information to which you provide access will be uploaded to this service and can be viewed by the service or other users of the service.'}
                        {else}
                            {if !empty($aConnection.connected.data.photoURL)}
                                <img src="{$aConnection.connected.data.photoURL}" style="max-width: 80px;float: left;margin-right: 15px;"  />
                            {/if}
                            <div style="float:left;margin-top:10px;line-height: 20px;">
                                {_p var='Connected as'} {$aConnection.connected.data.displayName}
                                {if !empty($aConnection.connected.data.profileURL)}
                                   <p>
                                        <a href="{$aConnection.connected.data.profileURL}" class="no_ajax" target="_blank">
                                           {$aConnection.connected.data.profileURL}
                                        </a>
                                   </p>
                                {/if}
                            </div>
                            <div class="clear"></div>
                        {/if}
                    </div>
                </div>
                <div class="table_cell">
                    {if !empty($aConnection.connected)}
                        <a href="{url link='socialconnect'}?disconnect={$aConnection.adapter}" class="button btn btn-primary btn-gradient">
                            {_p var='Disconnect'}
                        </a>
                    {else}
                        <a href="{if $aConnection.adapter == 'Vkontakte' or $aConnection.adapter == 'LinkedIn' or $aConnection.adapter == 'Odnoklassniki'}{$indexUrl}{$aConnection.adapter|strtolower}{else}{url link='socialconnect'}{$aConnection.adapter|strtolower}{/if}" class="no_ajax button btn btn-primary btn-gradient">
                            {_p var='Connect'}
                        </a>
                    {/if}
                </div>
            </div>
        {/foreach}
    </div>
{else}
    {_p var='There are no available connections'}
{/if}