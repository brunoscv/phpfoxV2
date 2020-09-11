<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */
namespace Apps\Socialconnect\Installation\Database;

use Core\App\Install\Database\Table as Table;

class Socialconnect extends Table
{
    protected function setTableName()
    {
        $this->_table_name = 'socialconnect';
    }

    protected function setFieldParams()
    {
        $this->_aFieldParams = [
            'connect_id' => [
                'type' => 'int',
                'type_value' => '11',
                'other' => 'UNSIGNED NOT NULL',
                'primary_key' => true,
                'auto_increment' => true,
            ],
            'adapter' => [
                'type' => 'text',
                'other' => 'NULL',
            ],
            'client' => [
                'type' => 'text',
                'other' => 'NULL',
            ],
            'secret' => [
                'type' => 'text',
                'other' => 'NULL',
            ],
            'client_key' => [
                'type' => 'text',
                'other' => 'NULL',
            ],
            'image_path' => [
                'type' => 'text',
                'other' => 'NULL',
            ],
            'is_enabled' => [
                'type' => 'int',
                'type_value' => '11',
                'other' => 'UNSIGNED NOT NULL DEFAULT \'0\'',
            ],
            'ordering' => [
                'type' => 'int',
                'type_value' => '11',
                'other' => 'UNSIGNED NOT NULL DEFAULT \'0\'',
            ],
        ];
    }
}
