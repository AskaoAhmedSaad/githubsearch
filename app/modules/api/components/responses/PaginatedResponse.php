<?php
namespace app\modules\api\components\responses;

class PaginatedResponse implements ResponseInterface
{
	/**
	 * return the paginated data from the data providor with the pagination meta data
	 * */
	public function getResponse($dataProvidor)
	{
		return [
			"data" => $dataProvidor->getData(), 
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