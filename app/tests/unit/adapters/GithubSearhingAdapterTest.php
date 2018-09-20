<?php
namespace adapters;

use Yii;
use \Codeception\Util\Fixtures;
use yii\codeception\TestCase;
use Codeception\Specify;

class GithubSearhingAdapterTest extends TestCase
{
    use Specify;
    public $searchingAdapter;

    protected function setUp()
    {
        parent::setUp();
        $searchData = require( __DIR__ . '/../../fixtures/_data/githubResponse/search_data.php'); 
        Yii::$container->set('GithubSearhingAdapter',
            'app\modules\api\adapters\GithubSearhingAdapter');
        Fixtures::add('search_data', $searchData);
    }

    public function testDefaultQueryParams()
    {
        $this->specify("test the default query params value when no params passed");
        $this->searchingAdapter = Yii::$container->get('GithubSearhingAdapter');
        $this->searchingAdapter->setQueryParams([
            'q' => 'addClass'
        ]);
        $this->assertTrue($this->searchingAdapter->getPage() == 1);
        $this->assertTrue($this->searchingAdapter->getPerPage() == 25);
        $this->assertTrue($this->searchingAdapter->getSort() == 'score');
    }

    public function testPassedQueryParams()
    {
        $this->specify("test the passed params");
        $this->searchingAdapter = Yii::$container->get('GithubSearhingAdapter');
        $this->searchingAdapter->setQueryParams([
            'q' => 'addClass',
            'page' => 2,
            'per_page' => 5,
            'sort' => 'indexed',
        ]);
        $this->assertTrue($this->searchingAdapter->getPage() == 2);
        $this->assertTrue($this->searchingAdapter->getPerPage() == 5);
        $this->assertTrue($this->searchingAdapter->getSort() == 'indexed');
    }

    public function testGettingTheNeededFieldsFromGithub()
    {
        $this->specify("test getting the needed fields from the search data returned from github");
        $this->searchingAdapter = Yii::$container->get('GithubSearhingAdapter');
        $this->searchingAdapter->setSearchData(Fixtures::get('search_data'));
        $responseData = $this->searchingAdapter->getResponseData();
        
        foreach ($responseData as $responseItem) {
            $this->assertNotNull($responseItem['owner_name']);
            $this->assertNotNull($responseItem['repository_name']);
            $this->assertNotNull($responseItem['file_name']);
        }
    }
}