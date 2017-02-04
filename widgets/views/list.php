<?php
use qvalent\comments\assets\CommentsAsset;
use qvalent\comments\models\Comment;
use kartik\icons\Icon;
use qvalent\comments\widgets\CommentsForm;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

/** @var $comments Comment[] */
/** @var $userShowCallback Closure */
/** @var $newComment Comment */
/** @var $itemId int */
/** @var $itemType int */
/** @var $canCreate bool */

CommentsAsset::register($this);
?>

<div class="qv-comments">
    <?php foreach ($comments as $comment) { ?>
        <div class="qv-root-comment-block">
            <div class="qv-root-rate-block">
                <a class="qv-root-rate-btn qv-rate-up" href="javascript:void(0)">
                    <?= Icon::show('triangle-top', [], Icon::BSG); ?>
                </a>
                <div class="qv-root-current-rating">
                    <?= rand(0, 100); ?>
                </div>
                <a class="qv-root-rate-btn qv-rate-down" href="javascript:void(0)">
                    <?= Icon::show('triangle-bottom', [], Icon::BSG); ?>
                </a>
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
                            <?= call_user_func($userShowCallback, $comment->user); ?> [<?= rand(0, 100); ?>]
                        </div>
                    </div>
                </div>
                <div class="qv-comment-replies">
                    <?php if (!empty($comment->activeChilds)) { ?>
                        <?php foreach ($comment->activeChilds as $reply) { ?>
                            <div class="qv-comment-reply">
                                <div class="qv-reply-rating"><?= rand(0, 100); ?></div>
                                <div class="qv-reply-rate">
                                    <a class="qv-reply-rate-btn qv-rate-down" href="javascript:void(0)">-</a>
                                    <a class="qv-reply-rate-btn qv-rate-up" href="javascript:void(0)">+</a>
                                </div>
                                <div class="qv-reply-text">
                                    <?= Yii::$app->formatter->format($reply->text, ['ntext', 'html']) ?><span
                                            class="qv-reply-info"> – <?= call_user_func($userShowCallback, $reply->user); ?>
                                        [<?= rand(0, 100); ?>], <?= date('d.m.Y H:i', $reply->created_at); ?></span>
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
