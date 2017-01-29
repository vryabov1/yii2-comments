<?php

namespace qvalent\comments\widgets;

use qvalent\comments\models\Comment;
use qvalent\comments\Module;
use Yii;
use yii\base\InvalidParamException;
use yii\base\Widget;

class CommentsList extends Widget
{

    public $itemType;
    public $itemId;

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
        $this->ensureValidParams();

        $comments = Comment::find()
            ->itemType($this->itemType)
            ->itemId($this->itemId)
            ->parentsOnly()
            ->joinWith('user')
            ->all();

        return $this->render('list', [
            'itemId' => $this->itemId,
            'itemType' => $this->itemType,
            'comments' => $comments,
            'userShowCallback' => $this->userShowCallback,
        ]);
    }

    private function ensureValidParams()
    {
        if (!is_callable($this->userShowCallback)) {
            throw new InvalidParamException('userShowCallback should be callable');
        }
        if (!isset($this->itemType)) {
            throw new InvalidParamException('itemType should be set');
        }
        if (!isset($this->itemId)) {
            throw new InvalidParamException('itemId should be set');
        }
    }
}

?>
