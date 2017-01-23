<?php

namespace qvalent\comments\widgets;

use qvalent\comments\models\Comment;
use qvalent\comments\Module;
use Yii;
use yii\base\InvalidParamException;
use yii\base\Widget;

class CommentsList extends Widget
{

    /**
     * User row callback
     * By default taken from Module settings
     * @var  \Closure
     */
    public $userShowCallback;

    public function init()
    {
        parent::init();
        /** @var Module $commentsModule */
        $commentsModule = Yii::$app->getModule('comments');
        $this->userShowCallback = $commentsModule->userShowCallback;

    }


    public function run()
    {
        $comments = Comment::find()->joinWith('user')->itemType(1)->parentsOnly()->all();

        $this->ensureValidParams();

        return $this->render('list', [
            'comments' => $comments,
            'userShowCallback' => $this->userShowCallback
        ]);
    }

    private function ensureValidParams()
    {
        if (is_callable($this->userShowCallback)) return true;

        throw new InvalidParamException('userShowCallback should be callable');
    }
}

?>
