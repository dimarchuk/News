<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ApprovedController extends Controller
{
    public function index()
    {
        $comments = DB::table('comments')
            ->join('news', 'comments.news_id', '=', 'news.id')
            ->where('approved_comments', '=', false)
            ->select('news.id', 'news.title', 'comment_text')
            ->orderBy('news.id')
            ->paginate(5);

        return view('admin.approved.approved', ['comments' => $comments]);
    }

    public function approve(int $commentId)
    {

        DB::table('comments')
            ->where('id', $commentId)
            ->update(
                [
                    'approved_comments' => 1
                ]
            );
        return redirect()->back();
    }
}
