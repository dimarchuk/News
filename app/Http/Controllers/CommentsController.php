<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class CommentsController
 * @package App\Http\Controllers
 */
class CommentsController extends Controller
{

    /**
     * @return mixed
     */
    public function index(int $newsId)
    {

        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->where('news_id', '=', $newsId)
            ->where('approved_comments', '=', true)
            ->orderBy('created_at')
            ->select('users.email','comment_text', 'comments.created_at')
            ->get();


        $resp = $comments;
        return response(json_encode($resp), 200)
            ->header('Content-type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function add(Request $request)
    {

        $data = json_decode(trim(file_get_contents('php://input')), true);

        $content = '';
        $userId = null;
        $newsId = null;
        $confirmed = true;

        $currentDate = date('Y-m-d H:i:s');
        if (!empty($data)) {
            $content = $data['content'];
            $newsId = $data['newsId'];
            $userEmail = $data['userEmail'];
            $resp = 'success';
        } else {
            $resp = 'error';
        }

        if ($newsId === 7) {
            $confirmed = false;
        }

        $userId = DB::table('users')->where('email', '=', $userEmail)->first()->id;

        DB::table('comments')->insert(
            [
                'comment_text' => $content,
                'user_id' => $userId,
                'news_id' => $newsId,
                'count_likes' => 0,
                'count_dislikes' => 0,
                'approved_comments' => $confirmed,
                'created_at' => $currentDate
            ]
        );

        return response(json_encode($resp), 200)
            ->header('Content-type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * @return mixed
     */
    public function getActiveUsers()
    {
        $resp = [];
        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->groupBy('user_id')
            ->select('user_id', 'users.email', DB::raw('count(1) AS count'))
            ->orderBy('count', 'decs')
            ->limit(5)
            ->get();

        $topArticles = DB::table('comments')
            ->join('news', 'comments.news_id', '=', 'news.id')
            ->groupBy('news_id')
            ->select('news_id', 'news.title', DB::raw('count(1) AS count'))
            ->orderBy('count', 'decs')
            ->limit(3)
            ->get();

        $resp['topUsers'] = $comments;
        $resp['topArticles'] = $topArticles;

        return response(json_encode($resp), 200)
            ->header('Content-type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }

    public function getUserComments(int $userId)
    {
        define('PER_PAGE', 5);//5

        if (isset($_GET['page'])) {
            $page = $_GET['page'] ? $_GET['page'] : 1;
        } else $page = 1;

        $resp = [];
        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->where('user_id', '=', $userId)
            ->select('users.email', 'comment_text')
            ->forPage($page, PER_PAGE)
            ->get();
        $countComments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->where('user_id', '=', $userId)
            ->count();

        $resp['email'] = $comments->first()->email;

        foreach ($comments as $comment) {
            $resp['item'][] = $comment->comment_text;
        }
        $resp['currentPage'] = $page;
        $resp['countPages'] = (int)ceil($countComments / PER_PAGE);

        return response(json_encode($resp), 200)
            ->header('Content-type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }
}
