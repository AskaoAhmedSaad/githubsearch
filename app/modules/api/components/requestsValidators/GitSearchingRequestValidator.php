<?php
namespace app\modules\api\components\requestsValidators;

use app\modules\api\components\requestsValidators\dependencies\IlluminateRequestValidator;

class GitSearchingRequestValidator extends IlluminateRequestValidator
{
    public $q, $page, $per_page, $sort, $order;

    public function getRules()
    {
        return [
            'q' => ['required','string'],
            'page' => ['integer', 'nullable'],
            'per_page' => ['integer', 'nullable'],
            'sort' => ['string', 'nullable'],
            'order' => ['string', 'nullable'],
        ];
    }

    public function getCustomErrorMessages()
    {
        return [];
    }

}
