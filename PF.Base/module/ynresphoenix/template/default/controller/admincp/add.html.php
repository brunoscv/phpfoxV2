<?php
/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:08
 */
defined('PHPFOX') or exit('NO DICE!');
?>

<div class="panel panel-default" id="ynresphoenix_manage_pages">
{if $sType == 'introduction'}
    {template file='ynresphoenix.block.add-item.introduction'}
{elseif $sType == 'member'}
    {template file='ynresphoenix.block.add-item.member'}
{elseif $sType == 'client'}
    {template file='ynresphoenix.block.add-item.client'}
{elseif $sType == 'statistic'}
    {template file='ynresphoenix.block.add-item.statistic'}
{elseif $sType == 'reason'}
    {template file='ynresphoenix.block.add-item.reason'}
{elseif $sType == 'testimonial'}
    {template file='ynresphoenix.block.add-item.testimonial'}
{elseif $sType == 'blog'}
    {template file='ynresphoenix.block.add-item.blog'}
{elseif $sType == 'photo'}
    {template file='ynresphoenix.block.add-item.photo'}
{elseif $sType == 'product'}
    {template file='ynresphoenix.block.add-item.product'}
{elseif $sType == 'contact'}
    {template file='ynresphoenix.block.add-item.contact'}
{/if}
</div>
