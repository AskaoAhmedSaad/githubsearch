<?php
/**
* this class resposible for calling github api 
*/
namespace app\modules\api\apiClients;

use GuzzleHttp\Client;
use Exception;

class githubApiClient implements gitClientInterface
{
	    
	protected $client, $appid;

	public function __construct()
	{
	    try {
	        $this->client = new Client(
	            [
	                'base_uri' => 'https://api.github.com',
	                'exceptions' => true
	            ]
	        );
	    } catch (Exception $e) {
	    	return $e->getMessage();
	    }
	}
     
    public function search(Array $params)
    {
		$queryParams = [];
    	$queryParams['query']['q'] = $params['query'];
    	try {
        	$response = $this->client->get('/search/code', $queryParams);
        } catch (Exception $e) {
        	throw new Exception("something wrong happens in calling github api", 1);
        }
        $responseContent  = json_decode($response->getBody()->getContents(), true);

        return $responseContent;
    }
}
