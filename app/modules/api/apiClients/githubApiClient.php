<?php
/**
* this class resposible for calling github api 
*/
namespace app\modules\api\apiClients;

use Yii;
use GuzzleHttp\Client;
use yii\web\UnprocessableEntityHttpException;
use Exception;

class githubApiClient implements gitClientInterface
{
	    
	protected $client, $appid;

	public function __construct()
	{
        $this->client = new Client(
            [
                'base_uri' => 'https://api.github.com',
                'headers' => [
                	'Authorization' => 'Bearer ' . Yii::$app->params['github_access_token']
                ],
                'exceptions' => true
            ]
        );
	}
     
    public function search(Array $params)
    {
		$queryParams = [];
    	$queryParams['query'] = $params;
    	try {
        	$response = $this->client->get('/search/code', $queryParams);
        } catch (Exception $e) {
        	$exceptionMessage = $this->getTheErrorMessage($e->getMessage());
        	throw new UnprocessableEntityHttpException($exceptionMessage, 1);
        }
        $responseContent  = json_decode($response->getBody()->getContents(), true);

        return $responseContent;
    }

    private function getTheErrorMessage($exceptionMessage)
    {
    	$pattern = '/"message":\s*"(.*)"/m';
    	preg_match($pattern, $exceptionMessage, $matches, PREG_OFFSET_CAPTURE);
    	if (isset($matches[1][0])) {
    	    $errorMessage = $matches[1][0];
    	} else {
    		$errorMessage = "something wrong happens in calling github api";
    	}

    	return $errorMessage;
    }
}
