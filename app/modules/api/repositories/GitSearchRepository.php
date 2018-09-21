<?php
/**
* repository for searching in a provided git rest api
*/
namespace app\modules\api\repositories;

use Yii;
use app\modules\api\adapters\SearchingAdapterInterface;
use app\modules\api\adapters\DataProvidorInterface;

class GitSearchRepository implements SearchingRepositoryInterface
{
    protected $searchingAdapter;

    /**
     * set the git searching adapter
     * */
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
        $params = [
                    'q' => $query,
                    'sort' => Yii::$app->request->get('sort'),
                    'page' => Yii::$app->request->get('page'),
                    'per_page' => Yii::$app->request->get('per_page'),
                    'order' => Yii::$app->request->get('order')
                ];

        $this->searchingAdapter->setQueryParams($params);
        $this->searchingAdapter->search($params);

        $paginatedResponse = Yii::$container->get('paginatedResponse');
        
        return $paginatedResponse->getResponse($this->searchingAdapter);
    }
}