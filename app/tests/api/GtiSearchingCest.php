<?php


class GtiSearchingCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    public function testPositiveSearching(ApiTester $I)
    {
        $I->sendGET('/api/git/search?q=addClass+in:file+language:js+repo:jquery/jquery');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
    }
}
