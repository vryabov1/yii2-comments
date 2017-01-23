<?php

namespace qvalent\comments;

use yii\base\BootstrapInterface;
use yii\web\IdentityInterface;

class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        /** @var Module $module */
        $module = $app->getModule('comments');
        $module->userShowCallback = function(IdentityInterface $userModel) {
            return $userModel->getId();
        };
    }
}
