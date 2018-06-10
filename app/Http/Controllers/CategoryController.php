<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

/**
 * Class CategoryController
 * @package App\Http\Controllers
 */
class CategoryController extends Controller
{
    /**
     * @param $categoryId
     * @return mixed
     */
    public function index($categoryId)
    {
        define('PER_PAGE', 5);//5
        if(isset($_GET['page'])){
            $page = $_GET['page'] ? $_GET['page'] : 1;
        }else $page = 1;

        $articles = DB::table('news_category')
            ->join('news', 'news_category.news_id', '=', 'news.id')
            ->join('categories', 'news_category.category_id', '=', 'categories.id')
            ->where('category_id', '=', $categoryId)
            ->orderBy('news_category.news_id')
            ->forPage($page, PER_PAGE)
            ->get();

        $countArticles = DB::table('news_category')
            ->where('category_id', '=', $categoryId)
            ->count();

        $resp = [];
        $resp['currentPage'] = $page;
        $resp['countPages'] = (int)ceil($countArticles / PER_PAGE);
        $resp['category_name'] = $articles[0]->category_name;
        foreach ($articles as $article) {
            $resp['articles'][] = [
                'id' => $article->news_id,
                'title' => $article->title
            ];
        }

        return response(json_encode($resp), 200)
            ->header('Content-type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }
}
