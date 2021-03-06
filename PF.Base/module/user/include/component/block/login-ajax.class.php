<?php
defined('PHPFOX') or exit('NO DICE!');

/**
 * Class User_Component_Block_Login_Ajax
 */
class User_Component_Block_Login_Ajax extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{		
		$aCheckArray = $this->request()->getArray('phpfox');
		$this->template()->assign(array(
				'sSiteName' => Phpfox::getParam('core.site_title'),
				'sSignUpPage' => $this->url()->makeUrl('user.register'),
				'bIsAJaxAdminCp' => ((PHPFOX_IS_AJAX && isset($aCheckArray['is_admincp'])) ? true : false),
			)
		);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('user.component_block_login_ajax_clean')) ? eval($sPlugin) : false);
	}
}
