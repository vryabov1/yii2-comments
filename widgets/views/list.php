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

<?php

use kartik\icons\Icon;

$comments = [
    [
        'rating'=>113,
        'comment_text' => "You can't catch parse errors when enabling error output at runtime, because it parses the file before actually executing anything (and since it encounters an error during this, it won't execute anything). You'll need to change the actual server configuration so that display_errors is on and the approriate error_reporting level is used. If you don't have access to php.ini, you may be able to use .htaccess or similar, depending on the server.",
        'username' => 'snusnu',
        'date' => '2015-10-21 10:23',
        'user_rating' => 2150,
        'replies' => [
            [
                'rating'=>4,
                'comment_text' => "error output at runtime",
                'username' => 'alibaba',
                'date' => '2015-10-21 12:23',
                'user_rating' => 87
            ],
            [
                'rating'=>0,
                'comment_text' => "Thank you Guys!",
                'username' => 'checkmate',
                'date' => '2015-10-21 12:33',
                'user_rating' => 7
            ],
            [
                'rating'=>2,
                'comment_text' => "When using PHP as an Apache module, we can a change the configuration settings using directives in Apache configuration files (e.g. httpd.conf) and .htaccess files. You will need “AllowOverride Options” or “AllowOverride All” privileges to do so. Check this",
                'username' => 'useyourbrain',
                'date' => '2015-11-23 02:12',
                'user_rating' => 2
            ]
        ]
    ],
    [
        'rating'=>20,
        'comment_text' => "I'm looking for that. Thanks!",
        'username' => 'admin',
        'date' => '2015-10-11 10:30',
        'user_rating' => 90
    ]
];

?>

<div class="qv-comments">
    <?php foreach ($comments as $comment) { ?>
        <div class="qv-root-comment-block">
            <div class="qv-root-rate-block">
                <a class="qv-root-rate-btn qv-rate-up" href="javascript:void(0)">
                    <?= Icon::show('triangle-top', [], Icon::BSG); ?>
                </a>
                <div class="qv-root-current-rating">
                    <?= $comment['rating'] ?>
                </div>
                <a class="qv-root-rate-btn qv-rate-down" href="javascript:void(0)">
                    <?= Icon::show('triangle-bottom', [], Icon::BSG); ?>
                </a>
            </div>
            <div class="qv-root-comment-block-right">
                <div class="qv-root-comment">
                    <div class="qv-root-comment-text">
                        <?= $comment['comment_text'] ?>
                    </div>
                    <div class="qv-root-comment-info">
                        <div class="qv-root-comment-date">
                            <?= date('d.m.Y H:i', strtotime($comment['date'])); ?>
                        </div>
                        <div class="qv-root-comment-user">
                            <?= $comment['username'] ?> [<?= $comment['user_rating'] ?>]
                        </div>
                    </div>
                </div>
                <?php if (empty($comment['replies'])) continue; ?>
                <div class="qv-comment-replies">
                    <?php foreach ($comment['replies'] as $reply) { ?>
                        <div class="qv-comment-reply">
                            <div class="qv-reply-rating"><?= $reply['rating'] ?: ''; ?></div>
                            <div class="qv-reply-rate">
                                <a class="qv-reply-rate-btn qv-rate-down" href="javascript:void(0)">-</a>
                                <a class="qv-reply-rate-btn qv-rate-up" href="javascript:void(0)">+</a>
                            </div>
                            <div class="qv-reply-text">
                                <?= $reply['comment_text'] ?><span class="qv-reply-info"> – <?= $reply['username'] ?>
                                    [<?= $reply['user_rating'] ?>], <?= date('d.m.Y H:i', strtotime($reply['date'])); ?></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
