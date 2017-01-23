<?php

namespace qvalent\comments;

class Module extends \yii\base\Module
{

    /**
     * User display callback
     * By default taken from Module settings
     * @var  \Closure
     */
    public $userShowCallback;
}
