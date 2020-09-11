<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[PHPFOX_COPYRIGHT]
 * @author  		Raymond Benc
 * @package  		Module_Mail
 * @version 		$Id: index.class.php 1968 2010-10-27 19:42:36Z Raymond_Benc $
 */
class Forumsystem_Component_Block_show extends Phpfox_Component
{
	/**
	 * Class process method wnich is used to execute this component.
	 */
	public function process()
	{
		
$this->template()->assign(array(
'sHeader' => '<div style="padding:20px">'.Phpfox::getPhrase('forumsystem.forums').'</div>',

)
);

return 'block';	

	}
}

?>
