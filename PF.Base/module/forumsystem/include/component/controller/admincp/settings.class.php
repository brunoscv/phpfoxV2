<?php
defined('PHPFOX') or exit('NO APPLES!');
class forumsystem_Component_Controller_Admincp_Settings extends Phpfox_Component
{
	/**
	 * Class process method which is used to execute this component.
	 */
	public function process()
	{
		$this->url()->send('admincp.setting.edit', array('module-id'=>'forumsystem'));
		$this->template()
			->setTitle('Forum System')
			->setBreadcrumb('Settings');
	}
}
?>