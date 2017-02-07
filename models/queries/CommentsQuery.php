<?php

namespace qvalent\comments\models\queries;

use qvalent\comments\models\Comment;
use yii\db\ActiveQuery;

class CommentsQuery extends ActiveQuery
{

    private $_alias;

    /**
     * @param $itemType
     * @return $this
     */
    public function itemType($itemType)
    {
        $this->andFilterWhere([$this->getPrefix() . 'item_type' => $itemType]);
        return $this;
    }

    /**
     * @param $itemId
     * @return $this
     */
    public function itemId($itemId)
    {
        $this->andFilterWhere([$this->getPrefix() . 'item_id' => $itemId]);
        return $this;
    }

    /**
     * @return $this
     */
    public function parentsOnly()
    {
        $this->andWhere([$this->getPrefix() . 'parent_id' => null]);
        return $this;
    }

    public function activeOnly()
    {
        $this->andWhere([$this->getPrefix() . 'status' => Comment::STATUS_ACTIVE]);
        return $this;
    }

    /**
     * @return string
     */
    private function getPrefix()
    {
        return $this->_alias ? $this->_alias . '.' : '';
    }

    public function setAlias($alias)
    {
        $this->alias($alias);
        $this->_alias = $alias;
        return $this;
    }
}
