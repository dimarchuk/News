<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * Class ArticleController
 * @package App\Http\Controllers
 */
class ArticleController extends Controller
{
    /**
     * @param int $articleId
     * @return mixed
     */
    public function index($articleId)
    {

        $isLogin = (bool)$_GET['islogin'] ? (bool)$_GET['islogin'] : 0;

        $article = DB::table('news_category')
            ->join('news', 'news_category.news_id', '=', 'news.id')
            ->join('categories', 'news_category.category_id', '=', 'categories.id')
            ->where('news_id', '=', $articleId)
            ->get();

        $isAnalytics = empty($article->where('category_id', '=', 7)->toArray());

        $article = $article->first();
        if (!$isLogin && !$isAnalytics) {
            preg_match_all('/[A-z](.+)[.!?][s]{0,1}/U', $article->content, $items);//([a-z]{1}|s) after [A-Z]
            $arr = array_slice($items[0], 0, 5);
            $content = implode(' ', $arr);
        } else $content = $article->content;

        $img = "http://8434-5a79ee928fcb5.st.php-academy.org/public/images/{$article->img}";
        $created_at = date('Y-m-d', strtotime($article->created_at));
        $resp['article'] = [
            'id' => $article->news_id,
            'title' => $article->title,
            'content' => $content,
            'img' => $img,
            'created_at' => $created_at,
            'number_of_views' => $article->number_of_views,
            'category_id' => $article->category_id,
            'category_name' => $article->category_name

        ];

        $tags = DB::table('news_tag')
            ->join('tags', 'news_tag.tag_id', '=', 'tags.id')
            ->where('news_id', '=', $articleId)
            ->get();

        foreach ($tags as $tag) {
            $resp['tags'][] = [
                'id' => $tag->tag_id,
                'name' => $tag->name
            ];
        }
        $resp['isLogin'] = $_GET['islogin'];
        return response(json_encode($resp), 200)
            ->header('Content-type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * @param int $tagId
     * @return mixed
     */
    public function tagArticles($tagId)
    {
        define('PER_PAGE', 5);//5
        if (isset($_GET['page'])) {
            $page = $_GET['page'] ? $_GET['page'] : 1;
        } else $page = 1;

        $tags = DB::table('news_tag')
            ->select('news_id', 'title', 'name')
            ->join('news', 'news_tag.news_id', '=', 'news.id')
            ->join('tags', 'news_tag.tag_id', '=', 'tags.id')
            ->where('tags.id', '=', $tagId)
            ->orderBy('news.id')
            ->forPage($page, PER_PAGE)
            ->get();

        $countArticles = DB::table('news_tag')
            ->where('tag_id', '=', $tagId)
            ->count();

        $resp['currentPage'] = $page;
        $resp['countPages'] = (int)ceil($countArticles / PER_PAGE);
        $resp['category_name'] = $tags[0]->name;
        foreach ($tags as $tag) {
            $resp['articles'][] = [
                'id' => $tag->news_id,
                'title' => $tag->title,
            ];
        }

        return response(json_encode($resp), 200)
            ->header('Content-type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * @param string $tagName
     * @return mixed
     */
    public function searchTags(string $tagName)
    {
        $tags = DB::table('tags')
            ->where('name', 'like', "$tagName%")
            ->get();

        return response(json_encode($tags), 200)
            ->header('Content-type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * @param int $newsId
     */
    public function setViews(int $newsId)
    {
        if (isset($_GET['count'])) {
            $count = $_GET['count'];
        }

        $issetNews = DB::table('news')->where('id', '=', $newsId)->first();
        $count = $count + $issetNews->number_of_views;
        if ($issetNews !== null) {
            DB::table('news')->where('id', $newsId)
                ->update(
                    [
                        'number_of_views' => $count
                    ]
                );
        }
        $resp['newCount'] = $count;
        return response(json_encode($resp), 200)
            ->header('Content-type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * @return mixed
     */
    public function all()
    {
        define('PER_PAGE', 5);
        if (isset($_GET['page'])) {
            $page = $_GET['page'] ? $_GET['page'] : 1;
        } else $page = 1;

        $countArticles = DB::table('news')->count();

        $articles = DB::table('news')
            ->orderBy('news.id')
            ->forPage($page, PER_PAGE)
            ->get();

        $resp['currentPage'] = $page;
        $resp['countPages'] = (int)ceil($countArticles / PER_PAGE);
        foreach ($articles as $article) {
            $resp['item'][] = [
                'id' => $article->id,
                'name' => $article->title,
            ];
        }

        return response(json_encode($resp), 200)
            ->header('Content-type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }
}
