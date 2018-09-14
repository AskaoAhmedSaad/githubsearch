<?php
/**
* interface for any data providor
**/
namespace app\modules\api\components;

interface DataProvidorInterface
{
	public function getResponseData();

	public function getPage();

	public function getPerPage();

	public function getSort();

	public function getTotal();
}