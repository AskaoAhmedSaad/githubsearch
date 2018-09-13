<?php
namespace repositories;

use \Codeception\Util\Fixtures;
use yii\codeception\TestCase;

class GitSearchRepositoryTest extends TestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        $searchData = require_once( __DIR__ . '/../../fixtures/_data/githubResponse/search_data.php'); 
        Fixtures::add('search_data', $searchData);
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        print_r(Fixtures::get('search_data'));die;
    }
}