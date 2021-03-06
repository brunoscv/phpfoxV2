<?php

/**
 * Class Admincp_Component_Controller_Setting_Logger_Database
 * @since 4.8.0
 * @author phpfox
 */
class Admincp_Component_Controller_Setting_Logger_Database extends Phpfox_Component
{
    const SERVICE_ID = 'database';

    public function process()
    {
        $sError = null;

        /**
         * @var \Core\Log\Admincp
         */
        $logManager = Phpfox::getLib('log.admincp');

        if ($this->request()->method() === 'POST') {
            $aVals = $this->request()->get('val');
            $config = [
                'level' => $aVals['level'],
            ];

            try {
                $bIsValid = $logManager->verifyServiceConfig(self::SERVICE_ID, $config);
                if (!$bIsValid) {
                    $sError = _p('invalid_configuration');
                }
            } catch (Exception $exception) {
                $bIsValid = false;
                $sError = $exception->getMessage();
            }

            if ($bIsValid) {
                $logManager->updateServiceConfig(self::SERVICE_ID, !!$aVals['is_active'], $config);
                Phpfox::addMessage(_p('Your changes have been saved!'));
            }
        } else {
            $aVals = $logManager->getServiceConfig(self::SERVICE_ID);
        }

        $this->template()->clearBreadCrumb()
            ->setTitle(_p('log_handling'))
            ->setBreadCrumb(_p('log_handling'))
            ->setActiveMenu('admincp.setting.logger')
            ->assign([
                'aForms' => $aVals,
                'sError' => $sError,
                'sLogTable' => Phpfox::getT('core_log_data'),
            ]);
    }
}