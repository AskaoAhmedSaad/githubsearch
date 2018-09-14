<?php
namespace adapters;

use Yii;
use \Codeception\Util\Fixtures;
use yii\codeception\TestCase;
use Codeception\Specify;

class GithubSearhingAdapterTest extends TestCase
{
    use Specify;

    protected function _before()
    {
        $searchData = require( __DIR__ . '/../../fixtures/_data/githubResponse/search_data.php'); 
        Fixtures::add('search_data', $searchData);
    }

    public function testDefaultQueryParams()
    {
        $this->specify("test the default query params value when no params passed");
        $searchingAdapter = Yii::$app->githubSearhingAdapter;
        $searchingAdapter->setQueryParams([
            'q' => 'addClass'
        ]);
        $this->assertTrue($searchingAdapter->getPage() == 1);
        $this->assertTrue($searchingAdapter->getPerPage() == 25);
        $this->assertTrue($searchingAdapter->getSort() == 'score');
    }

    public function testPassedQueryParams()
    {
        $this->specify("test the passed params");
        $searchingAdapter = Yii::$app->githubSearhingAdapter;
        $searchingAdapter->setQueryParams([
            'q' => 'addClass',
            'page' => 2,
            'per_page' => 5,
            'sort' => 'indexed',
        ]);
        $this->assertTrue($searchingAdapter->getPage() == 2);
        $this->assertTrue($searchingAdapter->getPerPage() == 5);
        $this->assertTrue($searchingAdapter->getSort() == 'indexed');
    }

    public function testGettingTheNeededFieldsFromGithub()
    {
        $this->specify("test getting the needed fields from the search data returned from github");
        $searchingAdapter = Yii::$app->githubSearhingAdapter;
        $searchingAdapter->setSearchData(Fixtures::get('search_data'));
        $responseData = $searchingAdapter->getResponseData();
        
        foreach ($responseData as $responseItem) {
            $this->assertNotNull($responseItem['owner_name']);
            $this->assertNotNull($responseItem['repository_name']);
            $this->assertNotNull($responseItem['file_name']);
        }
    }
}