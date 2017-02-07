<?php

namespace qvalent\comments\models;

use qvalent\comments\models\queries\CommentsQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

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
 * @property integer $created_at
 * @property integer $updated_at
 * @property bool $isActive
 * @property bool $isDisabled
 *
 * @property Comment $parent
 * @property IdentityInterface $user
 * @property Comment[] $childs
 */
class Comment extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [TimestampBehavior::className()];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_type', 'item_id', 'user_id', 'text', 'status'], 'required'],
            [['item_type', 'item_id', 'user_id', 'parent_id', 'status'], 'integer'],
            [['text'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item_type' => Yii::t('app', 'Item Type'),
            'item_id' => Yii::t('app', 'Item ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'text' => Yii::t('app', 'Text'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Comment::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChilds()
    {
        return $this->hasMany(Comment::className(), ['parent_id' => 'id']);
    }

    /**
     * @return CommentsQuery|object
     */
    public static function find()
    {
        return Yii::$container->has(CommentsQuery::className())
            ? Yii::createObject(CommentsQuery::className())
            : new CommentsQuery(get_called_class());
    }

    public function getUser()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }

    public function getIsActive()
    {
        return $this->status == static::STATUS_ACTIVE;
    }

    public function getIsDisabled()
    {
        return $this->status == static::STATUS_INACTIVE;
    }
}
