<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */
namespace Apps\Socialconnect\Installation\Database;

use Core\App\Install\Database\Table as Table;

class Socialconnect_Data extends Table
{
    protected function setTableName()
    {
        $this->_table_name = 'socialconnect_data';
    }

    protected function setFieldParams()
    {
        $this->_aFieldParams = [
            'data_id' => [
                'type' => 'int',
                'type_value' => '11',
                'other' => 'UNSIGNED NOT NULL',
                'primary_key' => true,
                'auto_increment' => true,
            ],
            'access_token' => [
                'type' => 'text',
                'other' => 'NULL',
            ],
            'token_type' => [
                'type' => 'text',
                'other' => 'NULL',
            ],
            'expires_at' => [
                'type' => 'int',
                'type_value' => '11',
                'other' => 'UNSIGNED NOT NULL DEFAULT \'0\'',
            ],
            'identifier' => [
                'type' => 'text',
                'other' => 'NULL',
            ],
            'data' => [
                'type' => 'text',
                'other' => 'NULL',
            ],
            'user_id' => [
                'type' => 'int',
                'type_value' => '11',
                'other' => 'UNSIGNED NOT NULL DEFAULT \'0\'',
            ],
            'adapter' => [
                'type' => 'text',
                'other' => 'NULL',
            ],
            'time_stamp' => [
                'type' => 'int',
                'type_value' => '11',
                'other' => 'UNSIGNED NOT NULL DEFAULT \'0\'',
            ],
            'is_login' => [
                'type' => 'int',
                'type_value' => '11',
                'other' => 'UNSIGNED NOT NULL DEFAULT \'0\'',
            ],
            'email' => [
                'type' => 'text',
                'other' => 'NULL',
            ],
        ];
    }
}
