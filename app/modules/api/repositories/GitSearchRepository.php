<?php
/**
* repository for searching in a provided git rest api
*/
namespace app\modules\api\repositories;

use Yii;
use app\modules\api\adapters\SearchingAdapterInterface;
use Exception;

class GitSearchRepository implements SearchingRepositoryInterface
{
    protected $searchingAdapter;

    public function setsearchingAdapter(SearchingAdapterInterface $searchingAdapter)
    {
        $this->searchingAdapter = $searchingAdapter;
    }

    /**
     * search using the provided git adapter
     * @param SearchingAdapterInterface $searchingAdapter the adapter for chosen git providor
     **/
    public function search(String $query)
    {
        $params = ['query' => $query, 'sort' => Yii::$app->request->get('sort')];
        $searchingData = $this->searchingAdapter->getSearchingData($params);
        
        return $this->getResponseFromSearchingData($searchingData);  
    }

    /**
     * return the searching response array for the searching data
     **/
    protected function getResponseFromSearchingData(Array $searchingData)
    {
        $searchResult = [];
        if (!isset($searchingData['items']))
            throw new Exception("can't found search items from the data providor", 1);
        
        if ($searchingData['items']) {
            foreach ($searchingData['items'] as $itemIndex => $item) {
                $this->validateSearchingItem($item);
                
                $searchResult[$itemIndex]['owner_name'] = $item['repository']['owner']['login'];
                $searchResult[$itemIndex]['repository_name'] = $item['repository']['full_name'];
                $searchResult[$itemIndex]['file_name'] = $item['name'];
            }
        }
        
        return $searchResult;
    }

    protected function validateSearchingItem(Array $searchingItem)
    {
        if (!isset($searchingItem['repository']['owner']['login']))
            throw new Exception("can't found owner_name from the data providor", 1);
        if (!isset($searchingItem['repository']['full_name']))
            throw new Exception("can't found repository_name from the data providor", 1);
        if (!isset($searchingItem['name']))
            throw new Exception("can't found file_name from the data providor", 1);
    }
}