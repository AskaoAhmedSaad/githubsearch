<?php
/**
 * return error response
 * */
namespace app\modules\api\components\responses;

class ErrorResponse implements ResponseInterface
{
	protected $errorData;

	public function setErrorData($errorData)
	{
		$this->errorData = $errorData;
	}

	public function getResponse()
	{
		return [
			"error" => true,
			"data" => $this->errorData
		];
	}
}