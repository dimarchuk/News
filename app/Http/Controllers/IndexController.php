<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

/**
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $resp = [];
        // categories & 5 last news headers
        $categories = DB::table('categories')->get();
        foreach ($categories as $category) {
            $articles = DB::table('news_category')
                ->join('news', 'news_category.news_id', '=', 'news.id')
                ->where('category_id', '=', $category->id)
                ->latest('created_at')
                ->limit(5)//5
                ->get();

            $rez = [];
            foreach ($articles as $article) {
                $rez[] = [
                    'id' => $article->news_id,
                    'title' => $article->title
                ];
            }

            $resp['articles'][] = [
                'name' => $category->category_name,
                'category_id' => $category->id,
                'item' => $rez
            ];
        }

        //info for slider
        $sliderArticles = DB::table('news_category')
            ->join('news', 'news_category.news_id', '=', 'news.id')
            ->join('categories', 'news_category.category_id', '=', 'categories.id')
            ->latest('created_at')
            ->limit(5)
            ->get();

        foreach ($sliderArticles as $key => $sliderArticle) {
            $img = "http://8434-5a79ee928fcb5.st.php-academy.org/public/images/{$sliderArticle->img}";
            $resp['sliderInfo'][] = [
                'index' => $key,
                'id' => $sliderArticle->news_id,
                'title' => $sliderArticle->title,
                'category' => $sliderArticle->category_name,
                'img' => $img
            ];
        }

        return response(json_encode($resp), 200)
            ->header('Content-type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }
}
