<?php
/**
* interface for request validator
*/
namespace app\modules\api\components\requestsValidators\dependencies;

interface RequestValidatorInterface
{
	public function getRules();

	public function getCustomErrorMessages();

	public function getValidationErrors();
}