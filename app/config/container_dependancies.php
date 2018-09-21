<?php

return [
	'definitions' => [
	    'githubApiClient' => [
	           'class' =>  'app\modules\api\apiClients\githubApiClient'
	       ],
	    'paginatedResponse' => [
	           'class' =>  'app\modules\api\components\responses\PaginatedResponse'
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