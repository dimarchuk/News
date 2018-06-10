<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * Class SearchArticleController
 * @package App\Http\Controllers
 */
class SearchArticleController extends Controller
{

    /**
     * @return mixed
     */
    public function index()
    {
        $tags = DB::table('tags')
            ->get();

        $categories = DB::table('categories')
            ->select('id', 'category_name as name')
            ->get();
        $resp['tags'] = $tags;
        $resp['categories'] = $categories;

        return response(json_encode($resp), 200)
            ->header('Content-type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');

    }

    /**
     * @return mixed
     */
    public function search(Request $request)
    {

        $dateFrom = date('Y-m-d');
        $dateTo = date('Y-m-d');

        $data = json_decode(trim(file_get_contents('php://input')), true);

        if (!empty($data)) {
            $categoriesId = $data['categoriesId'];
            $tagsId = $data['tagsId'];
            $dateFrom = $data['dateFrom'];
            $dateTo = $data['dateTo'];
        } else {
            $resp = 'error';
        }

        if (!empty($categoriesId) && empty($tagsId)) {
            $articles = $this->selectArticlesCategories($dateFrom, $dateTo, $categoriesId);
            $resp = $this->uniqueArtiles($articles);

        } elseif (empty($categoriesId) && !empty($tagsId)) {
            $articles = $this->selectArticlesTags($dateFrom, $dateTo, $tagsId);
            $resp = $this->uniqueArtiles($articles);

        } else if (isset($categoriesId) && !empty($tagsId)) {

            $articesCategoies = $this->selectArticlesCategories($dateFrom, $dateTo, $categoriesId);
            $articlesTags = $this->selectArticlesTags($dateFrom, $dateTo, $tagsId);

            $rez = $this->uniqueArtiles($articesCategoies);
            $resp = $this->uniqueArtiles($articlesTags, $rez);
        } else if (empty($categoriesId) && empty($tagsId)) {
            $articles = DB::table('news')->orderBy('id')->get();
            $resp = $this->uniqueArtiles($articles);
        }
        $resp['item'] = $resp;
        return response(json_encode($resp), 200)
            ->header('Content-type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * @param $articles
     * @param array $rez
     * @return array
     */
    private function uniqueArtiles($articles, $rez = [])
    {
        foreach ($articles as $article) {
            $item = [
                'id' => $article->news_id,
                'name' => $article->title
            ];
            if (!in_array($item, $rez)) {
                $rez[] = $item;
            }
        }
        return $rez;
    }

    /**
     * @param $dateFrom
     * @param $dateTo
     * @param $categoriesId
     * @return mixed
     */
    private function selectArticlesCategories($dateFrom, $dateTo, $categoriesId)
    {
        $articles = DB::table('news_category')
            ->join('news', 'news_category.news_id', '=', 'news.id')
            ->join('categories', 'news_category.category_id', '=', 'categories.id')
            ->whereIn('news_category.category_id', $categoriesId)
            ->whereBetween('news.created_at', [$dateFrom, $dateTo])
            ->get();
        return $articles;
    }

    /**
     * @param $dateFrom
     * @param $dateTo
     * @param $tagsId
     * @return mixed
     */
    private function selectArticlesTags($dateFrom, $dateTo, $tagsId)
    {
        $articles = DB::table('news_tag')
            ->join('news', 'news_tag.news_id', '=', 'news.id')
            ->join('tags', 'news_tag.tag_id', '=', 'tags.id')
            ->whereIn('news_tag.tag_id', $tagsId)
            ->whereBetween('news.created_at', [$dateFrom, $dateTo])
            ->get();
        return $articles;
    }
}
