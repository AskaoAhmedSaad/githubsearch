<?php
namespace components\responses;

use Yii;
use \Codeception\Util\Fixtures;
use yii\codeception\TestCase;
use Codeception\Specify;

class PaginatedResponseTest extends TestCase
{
    use Specify;

    public function testGettingPaginatedResponseForFivePerPage()
    {
        $this->specify("test getting paginated response for five per page");
        $searchingAdapter = Yii::$app->githubSearhingAdapter;
        $searchingAdapter->setQueryParams([
            'q' => 'addClass',
            'page' => 2,
            'per_page' => 5,
            'sort' => 'indexed',
        ]);
        $searchingAdapter->setSearchData(Fixtures::get('search_data'));
        
        $paginatedResponse = Yii::$app->paginatedResponse->getResponse($searchingAdapter);
        $paginatedResponse['data'];
        foreach ($paginatedResponse['data'] as $responseItem) {
            $this->assertNotNull($responseItem['owner_name']);
            $this->assertNotNull($responseItem['repository_name']);
            $this->assertNotNull($responseItem['file_name']);
        }
        $this->assertNotNull($paginatedResponse['meta']['pagination']);
        $this->assertTrue($paginatedResponse['meta']['pagination']['per_page'] == 5);
        $this->assertTrue($paginatedResponse['meta']['pagination']['current_page'] == 2);
    }

    public function testGettingPaginatedResponseWithNoParamsPassed()
    {
        $this->specify("test getting paginated response with no params passed");
        $searchingAdapter = Yii::$app->githubSearhingAdapter;
        $searchingAdapter->setQueryParams([
            'q' => 'addClass',
        ]);
        $searchingAdapter->setSearchData(Fixtures::get('search_data'));
        
        $paginatedResponse = Yii::$app->paginatedResponse->getResponse($searchingAdapter);
        $paginatedResponse['data'];
        foreach ($paginatedResponse['data'] as $responseItem) {
            $this->assertNotNull($responseItem['owner_name']);
            $this->assertNotNull($responseItem['repository_name']);
            $this->assertNotNull($responseItem['file_name']);
        }
        $this->assertNotNull($paginatedResponse['meta']['pagination']);
        $this->assertTrue($paginatedResponse['meta']['pagination']['per_page'] == 25);
        $this->assertTrue($paginatedResponse['meta']['pagination']['current_page'] == 1);
    }
}