<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use app\modules\api\repositories\SearchingRepositoryInterface;
use Exception;

class GitController extends Controller
{
    public $searchingRepository;

    public function __construct($id, $module, SearchingRepositoryInterface $searchingRepository, $config = [])
    {
        $this->searchingRepository = $searchingRepository;
        $searchingAdapter = Yii::$container->get('app\modules\api\adapters\SearchingAdapterInterface');
        $this->searchingRepository->setsearchingAdapter($searchingAdapter);
        parent::__construct($id, $module, $config);
    }

    /**
     * search in git providor code
     * @param String $q the search query
     **/
    public function actionSearch()
    {
        try {
            return $this->searchingRepository->search(Yii::$app->request->get());
         } 
         catch (Exception $e) {
            throw $e;
         } 
    }
}
