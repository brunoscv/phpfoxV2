<?php

namespace Apps\YNC_FbClone\Installation\Database;


use Core\App\Install\Database\Table as Table;

defined('PHPFOX') or exit('NO DICE!');

/**
 * Class Ync_Facebook_Shortcuts
 * @package Apps\YNC_FbClone\Installation\Database
 */
class Ync_Facebook_Shortcuts extends Table
{
    protected function setTableName()
    {
        $this->_table_name = 'ync_facebook_shortcuts';
    }

    protected function setFieldParams()
    {
        $this->_aFieldParams = [
            'item_id' => [
                'type' => 'int',
                'type_value' => '10',
                'other' => 'UNSIGNED NOT NULL',
                'primary_key' => true,
                'auto_increment' => true,
            ],
            'page_id' => [
                'type' => 'int',
                'type_value' => '10',
                'other' => 'UNSIGNED NOT NULL',
            ],
            'owner_id' => [
                'type' => 'int',
                'type_value' => '10',
                'other' => 'UNSIGNED NOT NULL',
            ],
            'is_pin' => [
                'type' => 'tinyint',
                'type_value' => '1',
                'other' => 'NOT NULL DEFAULT \'0\''
            ],
            'is_hidden' => [
                'type' => 'tinyint',
                'type_value' => '1',
                'other' => 'NOT NULL DEFAULT \'0\''
            ],
            'ordering' => [
                'type' => 'int',
                'type_value' => '11',
                'other' => 'NOT NULL DEFAULT \'0\''
            ],
        ];
    }

    /**
     * Set keys of table
     */
    protected function setKeys()
    {
        $this->_key = [

        ];
    }
}