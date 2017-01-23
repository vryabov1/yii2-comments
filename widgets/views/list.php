<?php
use qvalent\comments\models\Comment;
use kartik\icons\Icon;

/** @var $comments Comment[]*/
/** @var $userShowCallback Closure */

?>

<style>
    .qv-comments {
        display: table;
        border-collapse: collapse;
        max-width: 600px;
    }

    .qv-root-comment-block {
        border-bottom: 1px solid #f0f0f0;
        display: table-row;
        width: 100%;
    }

    .qv-root-rate-block {
        text-align: center;
        display: table-cell;
        width: 50px;
        padding: 20px 0;
    }

    .qv-root-current-rating {
        color: #808080;
        font-size: 20px;
    }

    .qv-root-comment-block-right {
        padding: 20px 0 20px 10px;
    }

    .qv-root-comment {
        padding-bottom: 10px;
    }

    .qv-root-comment-info {
        color: #808080;
    }

    .qv-root-comment-date {
        text-align: right;
    }

    .qv-root-comment-user {
        text-align: right;
    }

    .qv-comment-replies {
        display: table;
        border-collapse: collapse;
        border-top: 1px solid #f0f0f0;
        font-size: 13px;
    }

    .qv-comment-reply {
        display: table-row;
        border-bottom: 1px solid #f0f0f0;
        width: 100%;
    }

    .qv-comment-reply:last-child {
        border-bottom: none;
    }

    .qv-reply-rating {
        display: table-cell;
        white-space: nowrap;
        padding: 5px 10px 5px 0;
        color: #808080;
    }

    .qv-reply-rate {
        display: table-cell;
        white-space: nowrap;
        padding: 5px 10px 5px 0;
    }

    .qv-reply-rate > button {
        background: none;
    }

    .qv-reply-text {
        display: table-cell;
        padding: 5px 0;
    }

    .qv-reply-info {
        white-space: nowrap;
        color: #808080;
    }

    .qv-rate-down, .qv-rate-down:hover, .qv-rate-down:active, .qv-rate-down:focus {
        color: #CA4343;
    }

    .qv-rate-up, .qv-rate-up:hover, .qv-rate-up:active, .qv-rate-up:focus {
        color: #20A020;
    }

    .qv-reply-rate-btn {
        padding: 4px;
        cursor: pointer;
    }

    .qv-reply-rate-btn:hover, .qv-reply-rate-btn:focus, .qv-reply-rate-btn:active {
        text-decoration: none;
    }
</style>


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
