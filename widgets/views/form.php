<?php
use kartik\icons\Icon;
use qvalent\comments\controllers\BaseController;
use qvalent\comments\models\CommentCompose;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var $model CommentCompose */
/** @var $isRoot bool */

$module = Yii::$app->getModule('comments');
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'qv-comment-add-form',
        'style' => $isRoot ? '' : 'display:none'
    ],
    'id' => $isRoot ? 'qv-add-comment-form' : 'qv-add-reply-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'action' => Url::to([$module->id . '/default/send', 'itemType' => $model->item_type, 'itemId' => $model->item_id])
]); ?>

<?= $form->field($model, 'text')->textarea(['rows' => 5])->label($isRoot ? 'Написать комментарий' : false)->error(false) ?>
<?php if (!$isRoot) { ?> <?= Html::activeHiddenInput($model, 'parent_id') ?> <?php } ?>
<?= Html::beginTag('div', ['class' => 'qv-comment-submit-block']) ?>
<?= Html::submitButton(
    'Отправить ' . Icon::show('send', [], Icon::BSG),
    ['class' => 'qv-comment-submit-btn btn btn-xs btn-info'])
?>
<?= Html::endTag('div') ?>
<?= Html::hiddenInput(BaseController::RETURN_PARAM, Yii::$app->request->getUrl()) ?>
<?php ActiveForm::end(); ?>
