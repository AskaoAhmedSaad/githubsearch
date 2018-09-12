<?php
/**
* interface for calling any git providor api
*/
namespace app\modules\api\apiClients;

interface gitClientInterface
{
	public function search(Array $params);
}