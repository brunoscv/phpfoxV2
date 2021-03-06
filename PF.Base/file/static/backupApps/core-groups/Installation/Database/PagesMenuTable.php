<?php

namespace Apps\PHPfox_Groups\Installation\Database;

use Core\App\Install\Database\Field;
use Core\App\Install\Database\Table;

class PagesMenuTable extends Table
{
    /**
     * Set name of this table, can't missing
     */
    protected function setTableName()
    {
        $this->_table_name = 'pages_menu';
    }

    /**
     * Set all fields of table
     */
    protected function setFieldParams()
    {
        $this->_aFieldParams = [
            'menu_id' => [
                'primary_key' => true,
                'auto_increment' => true,
                'type' => Field::TYPE_INT,
                'type_value' => 10,
                'other' => 'UNSIGNED NOT NULL'
            ],
            'menu_name' => [
                'type' => Field::TYPE_VARCHAR,
                'type_value' => 200,
                'other' => 'NOT NULL'
            ],
            'page_id' => [
                'type' => Field::TYPE_INT,
                'type_value' => 10,
                'other' => 'UNSIGNED NOT NULL DEFAULT 0'
            ],
            'is_active' => [
                'type' => Field::TYPE_TINYINT,
                'type_value' => 1,
                'other' => 'NOT NULL DEFAULT 1'
            ],
            'ordering' => [
                'type' => Field::TYPE_INT,
                'type_value' => 10,
                'other' => 'UNSIGNED NOT NULL DEFAULT 1'
            ],
        ];
    }

    /**
     * Set keys of table
     */
    protected function setKeys()
    {
        $this->_key = [
            'page_id' => ['page_id']
        ];
    }
}
