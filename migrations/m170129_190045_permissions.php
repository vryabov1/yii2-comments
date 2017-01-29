<?php

use yii\db\Migration;

class m170129_190045_permissions extends Migration
{
    public function up()
    {
        $am = Yii::$app->authManager;

        $modulePermission = $am->createPermission('ModuleComments');
        $modulePermission->description = 'Модуль Комментарии';
        $am->add($modulePermission);

        $composePermission = $am->createPermission('CreateComment');
        $composePermission->description = 'Написать комментарий';
        $am->add($composePermission);
        $am->addChild($modulePermission, $composePermission);
    }

    public function down()
    {
        $am = Yii::$app->authManager;

        $composePermission = $am->getPermission('CreateComment');
        $am->remove($composePermission);

        $modulePermission = $am->getPermission('ModuleComments');
        $am->remove($modulePermission);
    }
}
