<?php
/**
 * return the paginated data from the data providor with the pagination meta data
 * */
namespace app\modules\api\components\responses;

class PaginatedResponse implements ResponseInterface
{
	public function getResponse($dataProvidor)
	{
		return [
			"data" => $dataProvidor->getResponseData(), 
			"meta" => [
			    "pagination" => [
			        "total" => $dataProvidor->getTotal(),
			        "per_page" => $dataProvidor->getPerPage(),
			        "current_page" => $dataProvidor->getPage(),
			        "total_pages" => ceil($dataProvidor->getTotal() / $dataProvidor->getPerPage()),
			    ]
			]
		];
	}
}