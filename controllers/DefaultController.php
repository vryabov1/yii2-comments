<?php

namespace qvalent\comments\controllers;


use qvalent\comments\models\Comment;
use qvalent\comments\models\CommentCompose;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class DefaultController extends Controller
{

    /**
     * @param $itemType
     * @param $itemId
     * @return array|Response
     */
    public function actionSend($itemType, $itemId)
    {
        /** @var CommentCompose $model */
        $model = Yii::createObject(CommentCompose::className(), [$itemType, $itemId]);
        $model->load(Yii::$app->request->post());

        if ($this->isAjaxValidate()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $model->save();

        return $this->redirect($this->getReturnUrl());
    }


    /**
     * @return bool
     */
    private function isAjaxValidate()
    {
        return Yii::$app->request->isAjax
            && in_array(Yii::$app->request->post('ajax'), ['qv-add-comment-form', 'qv-add-reply-form'], true);
    }

    /**
     * @return string
     */
    private function getReturnUrl()
    {
        return Yii::$app->request->post('returnUrl');
    }
}
