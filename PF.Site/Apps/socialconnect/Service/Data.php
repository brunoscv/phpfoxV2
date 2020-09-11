<?php
/**
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		App_Socialconnect
 */

namespace Apps\Socialconnect\Service;

use Phpfox;
use Phpfox_Error;
use Phpfox_Plugin;
use Phpfox_Service;

defined('PHPFOX') or exit('NO DICE!');

class Data extends Phpfox_Service
{
    public function __construct()
    {
        $this->_sTable = Phpfox::getT('socialconnect');
    }

    public function delete($id)
    {
        $this->database()->delete($this->_sTable,'connect_id = '.$id);
        return true;
    }

    public function getForEdit($id)
    {
        $aRow = $this->database()->select('*')
            ->from($this->_sTable)
            ->where('connect_id = '.$id)
            ->execute('getSlaveRow');

        return $aRow;
    }

    public function updateConnection($id, $aVals)
    {
        if (!empty($aVals["client"]) and !empty($aVals["secret"])) {
            $this->database()->update($this->_sTable,array(
                'client' => $aVals["client"],
                'secret' => $aVals["secret"],
                'client_key' => $aVals["client_key"],
                'adapter' => $aVals['adapter'],
            ),'connect_id = '.$id);

            if (!empty($_FILES["image_path"]["name"])) {
                $sName = Phpfox::getLib('parse.input')->cleanFileName(uniqid());
                $aImage = Phpfox::getLib('file')->load('image_path', array('jpg', 'jpeg', 'gif', 'png'));
                $aSql1["image_path"] = str_replace("index.php/", "", Phpfox::getParam('core.path')) . "PF.Base/file/pic/photo/" . Phpfox::getLib('file')->upload('image_path', "PF.Base/file/pic/photo/", $sName, false, 0644, false);
                $this->database()->update($this->_sTable, $aSql1, 'connect_id = ' . $id);
            }
        } else {
            Phpfox_Error::set(_p("Please fill needed fields"));
            return false;
        }

        return true;
    }

    public function updateCategoryActivity($iId, $iType)
    {
        Phpfox::isAdmin(true);
        db()->update(($this->_sTable), array('is_enabled' => (int)($iType == '1' ? 1 : 0)),
            'connect_id = ' . (int)$iId);
        // clear cache
    }

    public function addConnection($aVals)
    {
        if (!empty($aVals["client"]) and !empty($aVals["secret"])) {
            $iId = $this->database()->insert($this->_sTable,array(
                'client' => $aVals["client"],
                'secret' => $aVals["secret"],
                'client_key' => $aVals["client_key"],
                'adapter' => $aVals['adapter'],
                'is_enabled' => 1
            ));

            if (!empty($_FILES["image_path"]["name"])) {
                $sName = Phpfox::getLib('parse.input')->cleanFileName(uniqid());
                $aImage = Phpfox::getLib('file')->load('image_path', array('jpg', 'jpeg', 'gif', 'png'));
                $aSql1["image_path"] = str_replace("index.php/", "", Phpfox::getParam('core.path')) . "PF.Base/file/pic/photo/" . Phpfox::getLib('file')->upload('image_path', "PF.Base/file/pic/photo/", $sName, false, 0644, false);
                $this->database()->update($this->_sTable, $aSql1, 'connect_id = ' . $iId);
            }
        } else {
            Phpfox_Error::set(_p("Please fill needed fields"));
            return false;
        }

        return true;
    }

    public function getData()
    {
        $aRows = $this->database()->select('*')
            ->from($this->_sTable)
            ->order('ordering ASC')
            ->execute('getSlaveRows');

        return $aRows;
    }

    public function insert($aVals)
    {
        $iId = $this->database()->insert(Phpfox::getT('socialconnect_data'),array(
            'access_token' => !empty($aVals["access_token"]) ? $aVals["access_token"] : "",
            'token_type' => !empty($aVals["token_type"]) ? $aVals["token_type"] : "",
            'expires_at' => !empty($aVals["expires_at"]) ? $aVals["expires_at"] : 0,
            'identifier' => !empty($aVals["identifier"]) ? $aVals["identifier"] : "",
            'data' => !empty($aVals["data"]) ? serialize($aVals["data"]) : "",
            'user_id' => Phpfox::getUserId(),
            'time_stamp' => PHPFOX_TIME,
            'is_login' => 0,
            'adapter' => !empty($aVals["adapter"]) ? $aVals["adapter"] : "",
            'email' => !empty($aVals["email"]) ? $aVals["email"] : "",
        ));

        return $iId;
    }

    public function getAdapter($adapter)
    {
        $aRow = $this->database()->select('*')
            ->from($this->_sTable)
            ->where('adapter="'.$adapter.'"')
            ->execute('getSlaveRow');

        return $aRow;
    }

    public function deleteEntry($adapter)
    {
        $this->database()->delete(Phpfox::getT('socialconnect_data'),'user_id = '.PHPFOX::getUserId()." AND adapter = '{$adapter}'");

        return true;
    }

    public function getUserSocial($userId)
    {
        $aRows = $this->database()->select('d.*,s.*')
            ->from(Phpfox::getT('socialconnect_data'),'d')
            ->join(Phpfox::getT('socialconnect'),'s','s.adapter = d.adapter')
            ->where('d.user_id = '.$userId)
            ->order('s.ordering ASC')
            ->execute('getSlaveRows');

        if (!empty($aRows)) {
            foreach ($aRows as &$aRow) {
                if (!empty($aRow["data"])) {
                    $aRow["data"] = unserialize($aRow["data"]);
                }
            }

            return $aRows;
        }

        return false;
    }

    public function getEnabledData()
    {
        //Fix enabled feature
        $aRows = $this->database()->select('d.*')
            ->from($this->_sTable,'d')
            ->where('d.is_enabled = 1')
            ->order('ordering ASC')
            ->execute('getSlaveRows');

        //CHECK IF USER ENABLED CONNECTION
        if (!empty($aRows)) {
            foreach ($aRows as &$aRow) {
              $aRow["connected"] = $this->database()->select('*')
                  ->from(Phpfox::getT('socialconnect_data'))
                  ->where(' user_id = '.Phpfox::getUserId().' AND adapter="'.$aRow["adapter"].'"')
                  ->execute('getSlaveRow');

                if (!empty($aRow["connected"]["data"])) {
                    $aRow["connected"]["data"] = unserialize($aRow["connected"]["data"]);
                }

            }
        }

        return $aRows;
    }
}
