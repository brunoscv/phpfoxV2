<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */
namespace Apps\Socialconnect\Ajax;

defined('PHPFOX') or exit('NO DICE!');

use Phpfox;
use Phpfox_Ajax;
/**
 * Class Ajax
 * @package Apps\Core_Blogs\Ajax
 */
class Ajax extends Phpfox_Ajax
{
    public function updateActivity()
    {
        Phpfox::getService('socialconnect.data')->updateCategoryActivity($this->get('id'), $this->get('active'));
    }
}
