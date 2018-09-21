<?php
namespace components\responses;

use Yii;
use \Codeception\Util\Fixtures;
use yii\codeception\TestCase;
use Codeception\Specify;

class PaginatedResponseTest extends TestCase
{
    use Specify;

    protected function setUp()
    {
        parent::setUp();
    }

    public function testGettingPaginatedResponseForFivePerPage()
    {
        $this->specify("test getting paginated response for five per page");
        $dataProvidor = Yii::$container->get('app\modules\api\components\DataProvidorInterface');
        $dataProvidor->setQueryParams([
            'q' => 'addClass',
            'page' => 2,
            'per_page' => 5,
            'sort' => 'indexed',
        ]);
        $dataProvidor->setSearchData(Fixtures::get('search_data'));
        $paginatedResponse = Yii::$container->get('paginatedResponse');
        $response = $paginatedResponse->getResponse($dataProvidor);
        foreach ($response['data'] as $responseItem) {
            $this->assertNotNull($responseItem['owner_name']);
            $this->assertNotNull($responseItem['repository_name']);
            $this->assertNotNull($responseItem['file_name']);
        }
        $this->assertNotNull($response['meta']['pagination']);
        $this->assertTrue($response['meta']['pagination']['per_page'] == 5);
        $this->assertTrue($response['meta']['pagination']['current_page'] == 2);
    }

    public function testGettingPaginatedResponseWithNoParamsPassed()
    {
        $this->specify("test getting paginated response with no params passed");
        $dataProvidor = Yii::$container->get('app\modules\api\components\DataProvidorInterface');
        $dataProvidor->setQueryParams([
            'q' => 'addClass',
        ]);
        $dataProvidor->setSearchData(Fixtures::get('search_data'));        
        $paginatedResponse = Yii::$container->get('paginatedResponse');
        $response = $paginatedResponse->getResponse($dataProvidor);
        foreach ($response['data'] as $responseItem) {
            $this->assertNotNull($responseItem['owner_name']);
            $this->assertNotNull($responseItem['repository_name']);
            $this->assertNotNull($responseItem['file_name']);
        }
        $this->assertNotNull($response['meta']['pagination']);
        $this->assertTrue($response['meta']['pagination']['per_page'] == 25);
        $this->assertTrue($response['meta']['pagination']['current_page'] == 1);
    }
}