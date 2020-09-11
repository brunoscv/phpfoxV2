<?php
/**
 * Created by PhpStorm.
 * User: minhhai
 * Date: 2/10/17
 * Time: 15:51
 */

if ($this->_sController == 'landing' && $this->_sModule == 'ynresphoenix') {
    if (in_array($iId,[1,3,9,10])){
        return [];
    }
}