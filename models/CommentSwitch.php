<?php

namespace qvalent\comments\models;

use yii\base\InvalidParamException;
use yii\base\Model;

class CommentSwitch extends Model
{

    public $model;

    public function __construct($id, $config = [])
    {
        $this->model = Comment::findOne($id);

        if (!$this->model) throw new InvalidParamException('comment not found');

        parent::__construct($config);
    }

    private function save()
    {
        return $this->model->save();
    }

    public function disable()
    {
        $this->model->status = Comment::STATUS_INACTIVE;
        return $this->save();
    }

    public function enable()
    {
        $this->model->status = Comment::STATUS_ACTIVE;
        return $this->save();
    }
}
