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

        if (!isset($module->userShowCallback)) {
            $module->userShowCallback = function (IdentityInterface $userModel) {
                return 'User#' . $userModel->getId();
            };
        }
    }
}
