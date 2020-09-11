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
 * @package  		Module_Core
 * @version 		$Id: ajax.class.php 2025 2010-11-01 15:52:31Z Raymond_Benc $
 */
class profilebadge_Component_Ajax_Ajax extends Phpfox_Ajax
{	

	
public function style1()
	{
		Phpfox::getBlock('profilebadge.style1');
		$this->html('#pagesshow', $this->getContent(false));
	}

public function style2()
	{

		Phpfox::getBlock('profilebadge.style2');
		$this->html('#pagesshow', $this->getContent(false));
	}



}

?>