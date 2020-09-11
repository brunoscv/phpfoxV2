<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[MYPHPFOXMOD_COPYRIGHT]
 * @author  		cespiritual
 * @package  		Like System
 */
class profilebadge_Component_Block_show extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{

$oRequest = Phpfox::getLib('request');
$aUser  = $oRequest->get('req1');
$aMe = Phpfox::getUserBy('user_name');

if ($aUser == $aMe) {

		$this->template()->assign(array(
'sHeader' => Phpfox::getPhrase('profilebadge.module_profilebadge'),

)
);

return 'block';	

}
	}
}

?>
