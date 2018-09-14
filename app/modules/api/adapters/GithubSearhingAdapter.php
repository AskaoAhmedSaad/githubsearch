<?php

/**
* adapter for using Github api
*/
namespace app\modules\api\adapters;

use Yii;
use yii\web\NotAcceptableHttpException;
use yii\web\UnprocessableEntityHttpException;
use app\modules\api\components\DataProvidorInterface;

class GithubSearhingAdapter implements SearchingAdapterInterface, DataProvidorInterface
{
    protected $apiClient;
    protected $searchQuery;
    protected $searchData;
    protected $sort;
    protected $order;
    protected $page;
    protected $perPage;

    public function __construct()
    {
        $this->apiClient = Yii::$app->githubApiClient;
    }

    public function setQueryParams(Array $params)
    {
        if (!isset($params['q'])) {
            throw new NotAcceptableHttpException("there is no q param passed", 1);
        }

        $this->searchQuery = $params['q'];
        $this->sort = isset($params['sort']) && $params['sort'] ? $params['sort'] : 'score';
        $this->order = isset($params['order']) && $params['order'] ? $params['order'] : 'asc';
        $this->page = isset($params['page']) && $params['page'] ? $params['page'] : 1;
        $this->perPage = isset($params['per_page']) && $params['per_page'] ? $params['per_page'] : 25;
    }

    public function search()
    {
        $queryParams = [
            'q' => $this->searchQuery,
            'sort' => $this->sort,
            'order' => $this->order,
            'page' => $this->page,
            'per_page' => $this->perPage,
        ];
        
        $searchData = $this->apiClient->search($queryParams);
        $this->setSearchData($searchData);
    }

    /**
     * get the needed fields for the github search response data
     **/
    public function getData()
    {
        $resultData = [];
        if (!isset($this->searchData['total_count']))
            throw new UnprocessableEntityHttpException("can't get total item count from the data providor", 1);

        if (!isset($this->searchData['items']))
            throw new UnprocessableEntityHttpException("can't found search items from the data providor", 1);
        
        if ($this->searchData['items']) {
            foreach ($this->searchData['items'] as $itemIndex => $item) {
                $this->validateSearchingItem($item);
                
                $resultData[$itemIndex]['owner_name'] = $item['repository']['owner']['login'];
                $resultData[$itemIndex]['repository_name'] = $item['repository']['full_name'];
                $resultData[$itemIndex]['file_name'] = $item['name'];
            }
        }

        return $resultData;
    }

    /**
     * validate each github response data item
     **/
    protected function validateSearchingItem(Array $searchingItem)
    {
        if (!isset($searchingItem['repository']['owner']['login']))
            throw new UnprocessableEntityHttpException("can't found owner_name from the data providor", 1);
        if (!isset($searchingItem['repository']['full_name']))
            throw new UnprocessableEntityHttpException("can't found repository_name from the data providor", 1);
        if (!isset($searchingItem['name']))
            throw new UnprocessableEntityHttpException("can't found file_name from the data providor", 1);
    }

    public function setSearchData(Array $searchData)
    {
        $this->searchData = $searchData;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function getTotal()
    {
        return $this->searchData['total_count'];
    }

}