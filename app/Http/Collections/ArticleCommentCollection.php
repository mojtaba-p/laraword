<?php

namespace App\Http\Collections;

use Illuminate\Database\Eloquent\Collection;

class ArticleCommentCollection extends Collection
{

    /**
     * parses comments to parent child structure and
     * replaces `''` in comments array with `root` word
     *
     * @return ArticleCommentCollection
     */
    public function parsed()
    {
        $all_comments = parent::groupBy('parent_id');

        if (count($all_comments)) {
            $all_comments['root'] = $all_comments[''];
            unset($all_comments['']);
        }

        return $all_comments;
    }
}
