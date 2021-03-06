<?php

namespace qvalent\comments;

class Module extends \yii\base\Module
{

    const PERMISSION_CREATE = 'CreateComment';
    const PERMISSION_ADMIN = 'AdminComment';

    /**
     * User display callback
     * By default taken from Module settings
     * @var  \Closure
     */
    public $userShowCallback;
}
