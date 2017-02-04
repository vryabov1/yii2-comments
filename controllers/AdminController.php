<?php

namespace qvalent\comments\controllers;

use qvalent\comments\models\CommentSwitch;
use qvalent\comments\models\search\CommentSearch;
use qvalent\comments\Module;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class AdminController extends BaseController
{

    public $defaultAction = 'list';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['list', 'enable', 'disable'],
                        'allow' => true,
                        'roles' => [Module::PERMISSION_ADMIN]
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'enable' => ['post'],
                    'disable' => ['post'],
                ],
            ],
        ];
    }

    public function actionList()
    {
        /** @var CommentSearch $model */
        $model = Yii::createObject(CommentSearch::className());

        return $this->render('list', [
            'dataProvider' => $model->search(Yii::$app->request->queryParams),
            'searchModel' => $model
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDisable($id)
    {
        $this->getSwitcher($id)->disable();
        return $this->redirect($this->getReturnUrl());
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionEnable($id)
    {
        $this->getSwitcher($id)->enable();
        return $this->redirect($this->getReturnUrl());
    }

    /**
     * @param $id
     * @return CommentSwitch
     */
    private function getSwitcher($id)
    {
        /** @var CommentSwitch $modelSwitcher */
        $modelSwitcher = Yii::createObject(CommentSwitch::className(), [$id]);
        return $modelSwitcher;
    }
}
