<?php
/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 12/1/16
 * Time: 16:08
 */
defined('PHPFOX') or exit('NO DICE!');
?>

{if $sType == 'introduction'}
    {template file='ynresphoenix.block.manage.introduction'}
{elseif $sType == 'member'}
    {template file='ynresphoenix.block.manage.member'}
{elseif $sType == 'client'}
    {template file='ynresphoenix.block.manage.client'}
{elseif $sType == 'statistic'}
    {template file='ynresphoenix.block.manage.statistic'}
{elseif $sType == 'reason'}
    {template file='ynresphoenix.block.manage.reason'}
{elseif $sType == 'testimonial'}
    {template file='ynresphoenix.block.manage.testimonial'}
{elseif $sType == 'blog'}
    {template file='ynresphoenix.block.manage.blog'}
{elseif $sType == 'photo'}
    {template file='ynresphoenix.block.manage.photo'}
{elseif $sType == 'product'}
    {template file='ynresphoenix.block.manage.product'}
{elseif $sType == 'contact'}
    {template file='ynresphoenix.block.manage.contact'}
{/if}
