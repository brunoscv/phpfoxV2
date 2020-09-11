<?php
if(Phpfox::getLib('request')->getRequests() == [
    'req1' => 'admincp',
    'req2' => 'app',
    'id' => '__module_ynresphoenix'
]) {
    Phpfox::getLib('url')->send('admincp.ynresphoenix');
}
?>
