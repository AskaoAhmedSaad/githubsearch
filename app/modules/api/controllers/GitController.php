<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use app\modules\api\adapters\SearchingAdapterInterface;
use app\modules\api\repositories\SearchingRepositoryInterface;
use Exception;

class GitController extends Controller
{
    public $searchingRepository;

    public function __construct($id, $module, SearchingRepositoryInterface $searchingRepository, SearchingAdapterInterface $searchingAdapter, $config = [])
    {
        $this->searchingRepository = $searchingRepository;
        $this->searchingRepository->setsearchingAdapter($searchingAdapter);
        parent::__construct($id, $module, $config);
    }

    /**
     * search in git providor code
     * @param String $q the search query
     **/
    public function actionSearch(String $q)
    {
        try {
            return $this->searchingRepository->search($q);
         } 
         catch (Exception $e) {
            throw $e;
         } 
    }
}
