<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * Class CommentsController
 * @package App\Http\Controllers\Admin
 */
class CommentsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $comments = DB::table('comments')
            ->join('news', 'comments.news_id', '=', 'news.id')
            ->select('news.id', 'news.title', 'comment_text')
            ->orderBy('news.id')
            ->paginate(5);

        return view('admin.comments.comments', ['comments' => $comments]);
    }
}
