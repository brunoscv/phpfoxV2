<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */

namespace Apps\Socialconnect\Controller;
include 'src/autoload.php';

use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;

use Phpfox;
use Phpfox_Component;
use Phpfox_Error;
use Phpfox_Plugin;

defined('PHPFOX') or exit('NO DICE!');

class FacebookController extends Phpfox_Component
{
    public function process()
    {
        $url = sprintf(
        "%s://%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],  $_SERVER['REQUEST_URI']);
        $baseUrl = \Phpfox_Url::instance()->makeUrl('socialconnect');
        $indexUrl = '';
        if (strpos($baseUrl, 'index.php') === false) {
            $indexUrl = str_replace('/socialconnect','/index.php/socialconnect',$baseUrl);
        }

        $adapterId = $this->request()->get('adapter') ? $this->request()->get('adapter') : 'Facebook';
        $adapter = Phpfox::getService('socialconnect.data')->getAdapter($adapterId);
        if ($adapter["adapter"] == 'Odnoklassniki') {
            $config = [
                'callback' => $url,
                'providers' => [
                    "$adapter" => [
                        'enabled' => true,
                        'keys'    => [ 'id' => $adapter["client"],'key' => $adapter["client_key"], 'secret' => $adapter["secret"] ],
                    ],
                ],
                'curl_options' => [
                    CURLOPT_SSL_VERIFYPEER => false
                ]
            ];
        } else {
            $config = [
                'callback' => $indexUrl.'facebook/',
                'providers' => [
                    "{$adapter["adapter"]}" => [
                        'enabled' => true,
                        'keys'    => [ 'id' => $adapter["client"], 'secret' => $adapter["secret"] ],
                    ],
                ],
                'curl_options' => [
                    CURLOPT_SSL_VERIFYPEER => false
                ]
            ];
        }


        try {
            $hybridauth = new Hybridauth( $config );

            $connection = $hybridauth->authenticate( $adapterId );

            $tokens = $connection->getAccessToken();
            $userProfile = $connection->getUserProfile();

            $aVals = array();
            $aVals["adapter"] = $adapter["adapter"];
            $aVals['access_token'] = $tokens['access_token'];
            $aVals['token_type'] = $tokens['token_type'];
            $aVals['expires_at'] = $tokens['expires_at'];
            $aVals["identifier"] = $userProfile->identifier;
            $aVals["email"] = $userProfile->emailVerified ? $userProfile->emailVerified : $userProfile->email;
            $aVals["data"]["webSiteURL"] = $userProfile->webSiteURL;
            $aVals["data"]["profileURL"] = 'http://facebook.com/'.$userProfile->identifier;
            $aVals["data"]["photoURL"] = $userProfile->photoURL;
            $aVals["data"]["displayName"] = $userProfile->displayName;
            $aVals["data"]["description"] = $userProfile->description;
            $aVals["data"]["firstName"] = $userProfile->firstName;
            $aVals["data"]["lastName"] = $userProfile->lastName;
            $aVals["data"]["language"] = $userProfile->language;
            $aVals["data"]["age"] = $userProfile->age;
            $aVals["data"]["email"] = $userProfile->email;
            $aVals["data"]["emailVerified"] = $userProfile->emailVerified;

            if (\Phpfox::getCookie("is_social_signup")) {
                //SOCIAL LOGIN HOOK
                (($sPlugin = Phpfox_Plugin::get('socialconnect.social_login')) ? eval($sPlugin) : false);
            } else {
                $iId = Phpfox::getService('socialconnect.data')->insert($aVals);
                if  ($iId) {
                    $this->url()->send('socialconnect',false,_p('Adapter successfully connected!'));
                    $connection->disconnect();
                }
            }
        }
        catch (\Exception $e) {
            echo $e->getMessage();
        }
        die;
    }
}
