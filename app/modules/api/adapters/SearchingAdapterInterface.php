<?php
/**
* interface for any searching adapter
*/
namespace app\modules\api\adapters;

interface SearchingAdapterInterface
{
	public function getSearchingData(Array $query);
}