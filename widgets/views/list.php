<?php
use qvalent\comments\assets\CommentsAsset;
use qvalent\comments\models\Comment;
use kartik\icons\Icon;
use qvalent\comments\widgets\CommentsForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var $comments Comment[] */
/** @var $userShowCallback Closure */
/** @var $newComment Comment */
/** @var $itemId int */
/** @var $itemType int */
/** @var $canCreate bool */
/** @var $getRateSum Closure */
/** @var $getUserVote Closure */

CommentsAsset::register($this);
$returnUrl = Yii::$app->request->getUrl();
?>

<div class="qv-comments">
    <?php foreach ($comments as $comment) { ?>
        <div class="qv-root-comment-block">
            <div class="qv-root-rate-block">
                <?= Yii::$app->user->id == $comment->user_id ? '' : Html::a(
                    Icon::show('triangle-top', [], Icon::BSG),
                    Url::to([
                        $getUserVote($comment) == 1 ? 'rate/rate/reset' : 'rate/rate/up',
                        'itemType' => Comment::RATE_ITEM_TYPE,
                        'itemId' => $comment->id,
                        'returnUrl' => $returnUrl
                    ]),
                    [
                        'class' => ['qv-root-rate-btn', 'qv-rate-up', $getUserVote($comment) == 1 ? 'active' : ''],
                        'data-method' => 'post',
                        'title' => $getUserVote($comment) == 1 ? 'Вы плюсанули, сбросить?' : 'Плюсануть',
                    ]
                ) ?>
                <div class="qv-root-current-rating">
                    <?= $getRateSum($comment); ?>
                </div>
                <?= Yii::$app->user->id == $comment->user_id ? '' : Html::a(
                    Icon::show('triangle-bottom', [], Icon::BSG),
                    Url::to([
                        $getUserVote($comment) == -1 ? 'rate/rate/reset' : 'rate/rate/down',
                        'itemType' => Comment::RATE_ITEM_TYPE,
                        'itemId' => $comment->id,
                        'returnUrl' => $returnUrl
                    ]),
                    [
                        'class' => ['qv-root-rate-btn', 'qv-rate-down', $getUserVote($comment) == -1 ? 'active' : ''],
                        'data-method' => 'post',
                        'title' => $getUserVote($comment) == -1 ? 'Вы минусанули, сбросить?' : 'Минусануть',
                    ]
                ) ?>
            </div>
            <div class="qv-root-comment-block-right">
                <div class="qv-root-comment">
                    <div class="qv-root-comment-text">
                        <?= Yii::$app->formatter->format($comment->text, ['ntext', 'html']) ?>
                    </div>
                    <div class="qv-root-comment-info">
                        <div class="qv-root-comment-date">
                            <?= date('d.m.Y H:i', $comment->created_at); ?>
                        </div>
                        <div class="qv-root-comment-user">
                            <?= call_user_func($userShowCallback, $comment->user); ?>
                        </div>
                    </div>
                </div>
                <div class="qv-comment-replies">
                    <?php if (!empty($comment->childs)) { ?>
                        <?php foreach ($comment->childs as $reply) { ?>
                            <div class="qv-comment-reply">
                                <div class="qv-reply-rating"><?= $getRateSum($reply, true); ?></div>
                                <div class="qv-reply-rate">
                                    <?= Yii::$app->user->id == $reply->user_id ? '' : Html::a(
                                        '-',
                                        Url::to([
                                            $getUserVote($reply) == -1 ? 'rate/rate/reset' : 'rate/rate/down',
                                            'itemType' => Comment::RATE_ITEM_TYPE,
                                            'itemId' => $reply->id,
                                            'returnUrl' => $returnUrl
                                        ]),
                                        [
                                            'class' => ['qv-reply-rate-btn', 'qv-rate-down', $getUserVote($reply) == -1 ? 'active' : ''],
                                            'data-method' => 'post',
                                            'title' => $getUserVote($reply) == -1 ? 'Вы минусанули, сбросить?' : 'Минусануть',
                                        ]
                                    ) ?>
                                    <?= Yii::$app->user->id == $reply->user_id ? '' : Html::a(
                                        '+',
                                        Url::to([
                                            $getUserVote($reply) == 1 ? 'rate/rate/reset' : 'rate/rate/up',
                                            'itemType' => Comment::RATE_ITEM_TYPE,
                                            'itemId' => $reply->id,
                                            'returnUrl' => $returnUrl
                                        ]),
                                        [
                                            'class' => ['qv-reply-rate-btn', 'qv-rate-up', $getUserVote($reply) == 1 ? 'active' : ''],
                                            'data-method' => 'post',
                                            'title' => $getUserVote($reply) == 1 ? 'Вы плюсанули, сбросить?' : 'Плюсануть',
                                        ]
                                    ) ?>
                                </div>
                                <div class="qv-reply-text">
                                    <?= Yii::$app->formatter->format($reply->text, ['ntext', 'html']) ?><span
                                            class="qv-reply-info"> – <?= call_user_func($userShowCallback, $reply->user); ?>,
                                        <?= date('d.m.Y H:i', $reply->created_at); ?></span>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($canCreate) { ?>
                        <p class="qv-comment-link-block">
                            <a href="javascript:void(0)" class="qv-comment-reply-link" data-parent-id="<?= $comment->id ?>">ответить</a>
                        </p>
                    <?php } ?>
                </div>

            </div>
        </div>
    <?php } ?>
</div>

<?php if ($canCreate) { ?>
    <?= CommentsForm::widget(['isRoot' => true, 'itemType' => $itemType, 'itemId' => $itemId]); ?>
    <?= CommentsForm::widget(['isRoot' => false, 'itemType' => $itemType, 'itemId' => $itemId]); ?>
<?php } ?>

<br>
<?php if (Yii::$app->user->isGuest) { ?>
<div class="alert alert-warning">
    Комментировать могут только авторизованные пользователи.
</div>
<?php } ?>