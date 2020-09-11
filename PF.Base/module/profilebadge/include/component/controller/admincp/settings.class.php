<?php
defined('PHPFOX') or exit('NO APPLES!');
class onlinemembersblock_Component_Controller_Admincp_Settings extends Phpfox_Component
{
	/**
	 * Class process method which is used to execute this component.
	 */
	public function process()
	{
		$this->url()->send('admincp.setting.edit', array('module-id'=>'onlinemembersblock'));
		$this->template()
			->setTitle('Online Members Block')
			->setBreadcrumb('Online Members Block');
	}
}

?>