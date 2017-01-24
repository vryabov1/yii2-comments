<?php

namespace qvalent\comments\models\queries;

use yii\db\ActiveQuery;

class CommentsQuery extends ActiveQuery
{

    /**
     * @param $itemType
     * @return $this
     */
    public function itemType($itemType)
    {
        $this->andFilterWhere(['item_type' => $itemType]);
        return $this;
    }

    /**
     * @param $itemId
     * @return $this
     */
    public function itemId($itemId)
    {
        $this->andFilterWhere(['item_id' => $itemId]);
        return $this;
    }

    /**
     * @return $this
     */
    public function parentsOnly()
    {
        $this->andWhere(['parent_id' => null]);
        return $this;
    }
}
