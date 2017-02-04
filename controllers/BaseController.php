<?php

namespace qvalent\comments\controllers;

use Yii;
use yii\web\Controller;

class BaseController extends Controller
{

    const RETURN_PARAM = 'returnUrl';

    /**
     * @return string
     */
    protected function getReturnUrl()
    {
        return Yii::$app->request->post(static::RETURN_PARAM, Yii::$app->request->get(static::RETURN_PARAM));
    }
}
