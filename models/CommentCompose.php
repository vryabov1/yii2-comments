<?php

namespace qvalent\comments\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "{{%comments}}".
 *
 * @property integer $id
 * @property integer $item_type
 * @property integer $item_id
 * @property integer $user_id
 * @property integer $parent_id
 * @property string $text
 * @property integer $status
 *
 */
class CommentCompose extends Model
{

    public $item_type;
    public $parent_id;
    public $item_id;
    public $text;

    public function __construct($itemType, $itemId, array $config = [])
    {
        $this->item_type = $itemType;
        $this->item_id = $itemId;
        parent::__construct($config);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'safe'],
            ['text', 'filter', 'filter' => 'yii\helpers\HtmlPurifier::process'],
            [['item_type', 'item_id', 'text'], 'required'],
            [['item_type', 'item_id', 'parent_id'], 'integer'],
            [['text'], 'string'],
        ];
    }

    public function save()
    {
        if (!$this->validate()) return false;
        /** @var Comment $model */
        $model = Yii::createObject(Comment::className());
        $model->setAttributes($this->getAttributes());
        $model->status = Comment::STATUS_ACTIVE;
        $model->user_id = Yii::$app->user->id;
        return $model->save();
    }
}
