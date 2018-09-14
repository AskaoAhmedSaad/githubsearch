<?php
/**
* interface for any searching adapter
*/
namespace app\modules\api\adapters;

interface SearchingAdapterInterface
{
	public function setQueryParams(Array $params);

	public function search();

	public function setSearchData(Array $searchData);
}