<?php

/**
* adapter for using Github api
*/
namespace app\modules\api\adapters;

use Yii;
use app\apiClients\OpenWeatherMapClient; 

class GithubSearhingAdapter implements SearchingAdapterInterface
{
    private $apiClient;
    private $query;
    private $sort;
	private $searchingData;

	public function __construct()
	{
		$this->apiClient = Yii::$app->githubApiClient;
    }

    public function getSearchingData(Array $params)
    {
        if (!isset($params['sort']) || !$params['sort']) {
            $params['sort'] = 'score';
        }
        
        return $this->apiClient->search($params);
    }
}