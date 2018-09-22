<?php
/**
 * return the paginated data from the data providor with the pagination meta data
 * */
namespace app\modules\api\components\responses;

class PaginatedResponse implements ResponseInterface
{
	protected $dataProvidor;

	public function setDataProvidor($dataProvidor)
	{
		$this->dataProvidor = $dataProvidor;
	}

	public function getResponse()
	{
		return [
			"data" => $this->dataProvidor->getResponseData(), 
			"meta" => [
			    "pagination" => [
			        "total" => $this->dataProvidor->getTotal(),
			        "per_page" => $this->dataProvidor->getPerPage(),
			        "current_page" => $this->dataProvidor->getPage(),
			        "total_pages" => ceil($this->dataProvidor->getTotal() / $this->dataProvidor->getPerPage()),
			    ]
			]
		];
	}
}