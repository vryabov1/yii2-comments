<?php

namespace qvalent\comments\models\queries;

use yii\db\ActiveQuery;

class CommentsQuery extends ActiveQuery
{
    public function itemType($itemType)
    {
        $this->andFilterWhere(['item_type' => $itemType]);
        return $this;
    }

    public function parentsOnly()
    {
        $this->andWhere(['parent_id' => null]);
        return $this;
    }
}