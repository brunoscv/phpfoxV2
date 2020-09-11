<?php

namespace Apps\YNC_FbClone\Installation\Database;


use Core\App\Install\Database\Table as Table;

defined('PHPFOX') or exit('NO DICE!');

/**
 * Class Ync_Facebook_Shortcuts
 * @package Apps\YNC_FbClone\Installation\Database
 */
class Ync_Facebook_Icons extends Table
{
    protected function setTableName()
    {
        $this->_table_name = 'ync_facebook_icons';
    }

    protected function setFieldParams()
    {
        $this->_aFieldParams = [
            'icon_id' => [
                'type' => 'int',
                'type_value' => '10',
                'other' => 'UNSIGNED NOT NULL',
                'primary_key' => true,
                'auto_increment' => true,
            ],
            'keywords' => [
                'type' => 'varchar',
                'type_value' => '255',
                'other' => 'DEFAULT NULL',
            ],
            'icon' => [
                'type' => 'varchar',
                'type_value' => '255',
                'other' => 'DEFAULT NULL',
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