<?php

namespace Clake\UserExtended\Classes;

use Clake\Userextended\Models\Comment;

/**
 * User Extended by Shawn Clake
 * Class CommentManager
 * User Extended is licensed under the MIT license.
 *
 * @author Shawn Clake <shawn.clake@gmail.com>
 * @link https://github.com/ShawnClake/UserExtended
 *
 * @license https://github.com/ShawnClake/UserExtended/blob/master/LICENSE MIT
 * @package Clake\UserExtended\Classes
 */
class CommentManager
{

    /**
     * Creates a comment for a user
     * @param $userId
     * @param $content
     * @return bool
     */
    public static function createComment($userId, $content)
    {
        $user = UserUtil::getUser($userId);

        $author = UserUtil::getLoggedInUser();

        if(is_null($author) || is_null($user))
            return false;

        $comment = new Comment();

        $comment->user = $user;
        $comment->author = $author;
        $comment->content = $content;

        return $comment->save();

    }

    /**
     * Deletes a comment specified by a comment ID
     * @param $commentId
     */
    public static function deleteComment($commentId)
    {

        if(self::canDeleteComment($commentId))
        {
            $comment = Comment::where('id', $commentId)->first();
            $comment->delete();
        }

    }

    /**
     * Returns whether or not a user is allowed to create a comment
     */
    public static function canCreateComment()
    {

    }

    /**
     * Returns whether or not a user is allowed to delete a comment
     * @param $commentId
     * @return bool
     */
    public static function canDeleteComment($commentId)
    {
        $loggedInUser = UserUtil::getLoggedInUser();

        if(is_null($loggedInUser))
            return false;

        $accessible = false;

        if(Comment::where('id', $commentId)->where('user_id', $loggedInUser->id)->count() == 1)
            $accessible = true;

        if(Comment::where('id', $commentId)->where('author_id', $loggedInUser->id)->count() == 1)
            $accessible = true;

        return $accessible;
    }

    /**
     * Returns whether or not a user can edit a comment
     * @param $commentId
     * @return bool
     */
    public static function canEditComment($commentId)
    {
        $loggedInUser = UserUtil::getLoggedInUser();

        if(is_null($loggedInUser))
            return false;

        if(Comment::where('id', $commentId)->where('author_id', $loggedInUser->id)->count() == 1)
            return true;

        return false;
    }

    /**
     * Edits a comment
     * @param $commentId
     * @param $content
     */
    public static function editComment($commentId, $content)
    {
        if(self::canEditComment($commentId))
        {
            $comment = Comment::where('id', $commentId)->first();
            $comment->content = $content;
            $comment->save();
        }
    }

}