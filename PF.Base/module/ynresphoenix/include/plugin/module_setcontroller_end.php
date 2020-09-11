<?php
if (Phpfox::isModule('ynresphoenix') && flavor()->active->id == 'ynresphoenix') {
    if ($this->_sModule == 'core' && ($this->_sController == 'index-visitor' || $this->_sController == 'index-member') && Phpfox::getLib('request') -> get('req1') != 'hashtag') {
        $this->_sModule = 'ynresphoenix';
        $this->_sController = 'landing';
    }
}
?>