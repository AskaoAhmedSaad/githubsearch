<?php

namespace app\modules\api;

use Yii;

/**
 * api module definition class
 */
class Module extends yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\api\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        // initialize the module with the configuration loaded from config.php

        Yii::$container->set('app\modules\api\adapters\SearchingAdapterInterface',
            'app\modules\api\adapters\GithubSearhingAdapter');

        Yii::$container->set('app\modules\api\repositories\SearchingRepositoryInterface',
            'app\modules\api\repositories\GitSearchRepository');

    }
}
