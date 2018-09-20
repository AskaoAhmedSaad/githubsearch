<?php

return [
	'definitions' => [
	    'githubApiClient' => [
	           'class' =>  'app\modules\api\apiClients\githubApiClient'
	       ],
	    'app\modules\api\adapters\SearchingAdapterInterface' => [
	           'class' =>  'app\modules\api\adapters\GithubSearhingAdapter'
	       ],
	    'app\modules\api\components\DataProvidorInterface' => [
	           'class' =>  'app\modules\api\adapters\GithubSearhingAdapter'
	       ],
	    'app\modules\api\repositories\SearchingRepositoryInterface' => [
	           'class' =>  'app\modules\api\repositories\GitSearchRepository'
	       ]
	]
];