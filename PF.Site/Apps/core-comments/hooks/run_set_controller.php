<?php

if (in_array(Phpfox::getLib('module')->getFullControllerName(), ['core.index-member', 'pages.view', 'groups.view', 'event.view'])) {
    $comments_feed = setting('comment.comments_show_on_activity_feeds', 4) == 0 ? null : setting('comment.comments_show_on_activity_feeds', 4);
    Phpfox::getLib('setting')->setParam('comment.comment_page_limit', $comments_feed);
    Phpfox::getLib('setting')->setParam('comment.total_comments_in_activity_feed', $comments_feed);
    if (!setting('comment.comment_show_replies_on_comment')) {
        Phpfox::getLib('setting')->setParam('comment.thread_comment_total_display', 0);
    } else {
        Phpfox::getLib('setting')->setParam('comment.thread_comment_total_display',
            setting('comment.comment_replies_show_on_activity_feeds',
                4) == 0 ? null : setting('comment.comment_replies_show_on_activity_feeds', 1));
    }
} else {
    Phpfox::getLib('setting')->setParam('comment.comment_page_limit',
        setting('comment.comments_show_on_item_details',
            4) == 0 ? null : setting('comment.comments_show_on_item_details', 4));
    if (!setting('comment.comment_show_replies_on_comment')) {
        Phpfox::getLib('setting')->setParam('comment.thread_comment_total_display', 0);
    } else {
        Phpfox::getLib('setting')->setParam('comment.thread_comment_total_display',
            setting('comment.comment_replies_show_on_item_details',
                4) == 0 ? null : setting('comment.comment_replies_show_on_item_details', 1));
    }
}
