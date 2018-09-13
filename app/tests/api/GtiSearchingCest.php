<?php

use \Codeception\Util\Fixtures;

class GtiSearchingCest
{
    public function _before(ApiTester $I)
    {
        $positiveResponseWith5Items = require_once( __DIR__ . '/../fixtures/_data/searchApiResponse/response_with_5_items.php'); 
        Fixtures::add('response_with_5_items', $positiveResponseWith5Items);
    }

    public function _after(ApiTester $I)
    {
    }

    public function testPositiveSearching(ApiTester $I)
    {
        $I->wantTo('test searching with passing all params');
        $I->sendGET('/api/git/search?q=addClass&page=1&per_page=5&sort=indexed&order=asc');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(\Codeception\Util\Fixtures::get('response_with_5_items'));


        $I->wantTo('test searching without sort and order param, check if diffrent result is shown');
        $I->sendGET('/api/git/search?q=addClass&page=1&per_page=5');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->cantSeeResponseContainsJson(\Codeception\Util\Fixtures::get('response_with_5_items'));

        $I->wantTo('test searching without per_page param param, check the defaault is 25 item');
        $I->sendGET('/api/git/search?q=addClass&page=20&sort=indexed&order=asc');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            "per_page" => "25",
            "current_page" => "20",
        ]);
    }
}
