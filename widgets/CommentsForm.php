<?php

namespace qvalent\comments\widgets;

use qvalent\comments\models\CommentCompose;
use Yii;
use yii\base\Widget;

class CommentsForm extends Widget
{

    public $isRoot;
    public $itemType;
    public $itemId;

    public function run()
    {
        return $this->render('form', [
            'model' => Yii::createObject(CommentCompose::className(), [$this->itemType, $this->itemId]),
            'isRoot' => $this->isRoot
        ]);
    }
}

?>
