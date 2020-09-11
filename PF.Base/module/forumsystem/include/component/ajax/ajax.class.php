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
 * @package  		Module_Forum
 * @version 		$Id: ajax.class.php 2471 2011-03-29 09:14:33Z Raymond_Benc $
 */
class Forumsystem_Component_Ajax_Ajax extends Phpfox_Ajax
{
	
	public function thanks()
	{
		Phpfox::isUser(true);
		Phpfox::getLib('database')->insert(Phpfox::getT('forum_thank'), array('user_id' => $this->get('user_id'), 'post_id' => $this->get('post_id')));  

	}
	
	public function removethanks()
	{
		Phpfox::isUser(true);
		Phpfox::getLib('phpfox.database')->delete(Phpfox::getT('forum_thank'), 'post_id = '.$this->get('post_id').' and user_id = '.$this->get('user_id')); 

		
	}
	
	

}

?>