<?php
use qvalent\comments\assets\CommentsAsset;
use qvalent\comments\models\Comment;
use kartik\icons\Icon;

/** @var $comments Comment[]*/
/** @var $userShowCallback Closure */
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
                        <?= $comment->text ?>
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
                <?php if (!empty($comment->childs)) { ?>
                <div class="qv-comment-replies">
                    <?php foreach ($comment->childs as $reply) { ?>
                        <div class="qv-comment-reply">
                            <div class="qv-reply-rating"><?= rand(0, 100); ?></div>
                            <div class="qv-reply-rate">
                                <a class="qv-reply-rate-btn qv-rate-down" href="javascript:void(0)">-</a>
                                <a class="qv-reply-rate-btn qv-rate-up" href="javascript:void(0)">+</a>
                            </div>
                            <div class="qv-reply-text">
                                <?= $reply->text ?><span class="qv-reply-info"> – <?= call_user_func($userShowCallback, $reply->user); ?>
                                    [<?= rand(0, 100); ?>], <?= date('d.m.Y H:i', $reply->created_at); ?></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>
