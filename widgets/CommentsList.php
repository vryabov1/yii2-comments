<?php

namespace qvalent\comments\widgets;

use yii\base\Widget;

class CommentsList extends Widget
{

    public function run()
    {
        return $this->render('list');
    }
}

?>