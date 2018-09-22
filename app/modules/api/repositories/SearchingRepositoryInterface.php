<?php
/**
* interface for git searching repository
*/
namespace app\modules\api\repositories;

use app\modules\api\adapters\SearchingAdapterInterface;

interface SearchingRepositoryInterface
{	
	public function setsearchingAdapter(SearchingAdapterInterface $searchingAdapter);

    public function search(Array $params);
}