<?php
use qvalent\comments\models\Comment;
use qvalent\comments\models\search\CommentSearch;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/** @var ActiveDataProvider $dataProvider */
/** @var CommentSearch $searchModel */

$this->title = 'Comments';;
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php Pjax::begin() ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'rowOptions' => function (Comment $model) {
        return $model->isDisabled ? ['class' => 'danger'] : [];
    },
    'columns' => [
        'id',
        'item_id',
        'item_type',
        'user_id',
        'parent_id',
        [
            'attribute' => 'text',
            'format' => ['ntext', 'html']
        ],
        [
            'attribute' => 'created_at',
            'format' => 'datetime',
            'contentOptions' => ['style' => 'min-width: 190px;']
        ],
        [
            'class' => ActionColumn::className(),
            'contentOptions' => ['style' => 'min-width: 80px;'],
            'template' => '{enable} {disable}',
            'urlCreator' => function ($action, $model, $key, $index, ActionColumn $column) {
                $params = ['id' => $key, 'returnUrl' => Yii::$app->request->getUrl()];
                $params[0] = $column->controller ? $column->controller . '/' . $action : $action;
                return Url::toRoute($params);
            },
            'buttons' => [
                'disable' => function ($url, Comment $model, $key) {
//                    var_dump($url); exit;
                    if (!$model->isActive) return '';
                    $options = array_merge([
                        'title' => 'Disable',
                        'aria-label' => 'Disable',
                        'data-confirm' => 'Are you sure you want to disable this item?',
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]);
                    return Html::a('<span class="glyphicon glyphicon-off text-danger"></span>', $url, $options);
                },
                'enable' => function ($url, Comment $model, $key) {
                    if (!$model->isDisabled) return '';
                    $options = array_merge([
                        'title' => 'Enable',
                        'aria-label' => 'Enable',
                        'data-confirm' => 'Are you sure you want to enable this item?',
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]);
                    return Html::a('<span class="glyphicon glyphicon-off text-danger"></span>', $url, $options);
                }
            ]
        ],
    ],
]); ?>

<?php Pjax::end() ?>
