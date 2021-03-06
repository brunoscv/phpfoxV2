<?php
/**
 * @author phpfox
 * @license phpfox.com
 */

namespace Core\SMS;


class ClickatellSmsSender implements SmsSenderInterface
{
	/**
	 * @const http://api.clickatell.com/
	 */
	const BASE_URL = 'https://platform.clickatell.com/';

	private $apiKey;

	/**
	 * @inheritDoc
	 */
	public function __construct($params)
	{
		$this->apiKey = $params['key'];
	}


	/**
	 * @link https://www.twilio.com
	 *
	 * <code>
	 * Phpfox::getLib('phpfox.verify')->sendSMS('+841637514924', 'test message from server');
	 * </code>
	 * @param $to
	 * @param $msg
	 * @return bool
	 */
	public function sendSMS($to, $msg)
	{

		$endpointUrl = self::BASE_URL . 'messages/http/send';

		$postFields = http_build_query([
			'apiKey' => $this->apiKey,
			'to' => trim($to, '+'),
			'content' => $msg,
		]);

		$ch = curl_init($endpointUrl . '?' . $postFields);

		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);

		$response = curl_exec($ch);
		$errno = curl_error($ch);

		curl_close($ch);

		if (!empty($errno)) {
			return false;
		}

		if (empty($response)) {
			return false;
		}
		$aRespone = json_decode($response, true);

		if (!empty($aRespone['error'])) {
			return false;
		}
		if (!empty($aRespone['messages'][0]['error'])) {
			return false;
		}

		return true;
	}
}