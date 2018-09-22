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
    protected $requestValidator;
    protected $errorMessages;

    /**
     * set the git searching adapter
     * */
    public function setsearchingAdapter(SearchingAdapterInterface $searchingAdapter)
    {
        $this->searchingAdapter = $searchingAdapter;
        $this->requestValidator = Yii::$container->get('gitSearchingRequestValidator');
    }

    /**
     * search using the provided git adapter
     **/
    public function search(Array $params)
    {
        if ($this->isValidParams($params)) {
            $this->searchingAdapter->setQueryParams($params);
            $this->searchingAdapter->search($params);
            $paginatedResponse = Yii::$container->get('paginatedResponse');
            $paginatedResponse->setDataProvidor($this->searchingAdapter);
            
            return $paginatedResponse->getResponse();
        }
        Yii::$app->response->statusCode = 422;
        $errorResponseClass = Yii::$container->get('errorResponse');
        $errorResponseClass->setErrorData($this->errorMessages);
        return $errorResponseClass->getResponse();
    }

    protected function isValidParams(Array $params)
    {
        $valid = true;
        $this->requestValidator->load($params, '');
        $errorMessages = $this->requestValidator->getValidationErrors();
        if ($errorMessages) {
            $this->errorMessages = $errorMessages;        
            $valid = false;
        }

        return $valid;
    }
}