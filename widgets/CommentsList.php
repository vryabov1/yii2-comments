<?php

namespace qvalent\comments\widgets;

use qvalent\comments\models\Comment;
use yii\base\Widget;

class CommentsList extends Widget
{

    public function run()
    {
        $comments = Comment::find()->joinWith('user')->itemType(1)->parentsOnly()->all();
        return $this->render('list', ['comments' => $comments]);
    }
}

?>