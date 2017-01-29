var replyBtn = '.qv-comment-reply-link';
var replyForm = '#qv-add-reply-form';
var repliesBlock = '.qv-root-comment-block-right';
var parentId = '#commentcompose-parent_id';
$(replyBtn).click(function () {
    var btn = $(this);
    $(parentId).val(btn.data('parent-id'));
    var replyBlock = btn.closest(repliesBlock);
    if (replyBlock.find(replyForm).length && $(replyForm).is(':visible')) {
        $(replyForm).hide(100);
    } else {
        $(replyForm).detach().appendTo(replyBlock).show(100);
    }
    return false;
});
