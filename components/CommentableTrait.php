<?php

namespace common\modules\comments\components;

use common\modules\comments\models\Comment;
use common\modules\comments\Module;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

trait CommentableTrait {
    public function getComments()
    {
        /** @var $this ActiveRecord */
        /** @var $commentsModule Module */

        $commentsModule = \Yii::$app->getModule('comments');

        $itemType = ArrayHelper::getValue($commentsModule->items, $this->className() . '.item_type');

        return $this->hasMany(Comment::className(), ['item_id' => current($this->primaryKey())])->where(['item_type' => $itemType]);
    }
}