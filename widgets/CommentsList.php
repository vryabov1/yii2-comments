<?php

namespace qvalent\comments\widgets;

use qvalent\comments\models\Comment;
use qvalent\comments\models\queries\CommentsQuery;
use qvalent\comments\Module;
use qvalent\rate\models\Rate;
use Yii;
use yii\base\InvalidParamException;
use yii\base\Widget;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Class CommentsList
 * @package qvalent\comments\widgets
 */
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


    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->ensureValidParams();

        $comments = $this->getComments();

        $commentRateSums = $this->getCommentRateSums($comments);

        $userVotes = $this->getUserVotes($comments);

        $getRateSum = function ($commentModel, $hideZero = false) use ($commentRateSums) {
            $value = ArrayHelper::getValue($commentRateSums, $commentModel->id, 0);
            if (!$hideZero || $value != 0) return $value;
            return '';
        };

        $getUserVote = function ($commentModel) use ($userVotes) {
            return ArrayHelper::getValue($userVotes, $commentModel->id, 0);
        };

        return $this->render('list', [
            'itemId' => $this->itemId,
            'itemType' => $this->itemType,
            'comments' => $comments,
            'userShowCallback' => $this->userShowCallback,
            'canCreate' => Yii::$app->user->can(Module::PERMISSION_CREATE),
            'getRateSum' => $getRateSum,
            'getUserVote' => $getUserVote,
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

    /**
     * @param Comment[] $comments
     * @return array
     */
    private function getCommentIds($comments)
    {
        $parentIds = ArrayHelper::getColumn($comments, 'id');

        $childIds = [];

        foreach ($comments as $comment) {
            $childIds = ArrayHelper::merge($childIds, ArrayHelper::getColumn($comment->childs, 'id'));
        }

        return ArrayHelper::merge($parentIds, $childIds);
    }

    /**
     * @return Comment[]
     */
    private function getComments()
    {
        return Comment::find()
            ->setAlias('parent')
            ->itemType($this->itemType)
            ->itemId($this->itemId)
            ->parentsOnly()
            ->activeOnly()
            ->joinWith([
                'user u',
                'childs ch' => function ($query) {
                    /** @var CommentsQuery $query */
                    return $query->andOnCondition(['ch.status' => Comment::STATUS_ACTIVE]);
                },
                'childs.user',
            ])
            ->all();
    }

    /**
     * @param Comment[] $comments
     * @return array
     */
    private function getCommentRateSums($comments)
    {
        return ArrayHelper::map(
            (new Query())
                ->select([
                    'sum' => new Expression('SUM(value)'),
                    'item_id'
                ])
                ->from(Rate::tableName())
                ->where([
                    'item_type' => Comment::RATE_ITEM_TYPE,
                    'item_id' => $this->getCommentIds($comments)
                ])
                ->groupBy('item_id')
                ->all(),
            'item_id',
            'sum'
        );
    }

    /**
     * @param Comment[] $comments
     * @return array
     */
    private function getUserVotes($comments)
    {
        return ArrayHelper::map(
            (new Query())
                ->select([
                    'sum' => new Expression('SUM(value)'),
                    'item_id'
                ])
                ->from(Rate::tableName())
                ->where([
                    'item_type' => Comment::RATE_ITEM_TYPE,
                    'item_id' => $this->getCommentIds($comments),
                    'user_id' => Yii::$app->user->id
                ])
                ->groupBy('item_id')
                ->all(),
            'item_id',
            'sum'
        );
    }
}

?>
