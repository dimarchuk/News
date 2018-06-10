<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AddNewsController extends Controller
{
    /**
     * AddNewsController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $categoies = DB::table('categories')->orderBy('categories.id')->get();

        $data = [
            'categories' => $categoies
        ];
        return view('admin.news.news', $data);
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function add()
    {


        $title = $_POST['title'];
        $content = $_POST['content'];
        $tmp = explode(',', $_POST['tags']);
        foreach ($tmp as $tag) {
            $tags[] = trim($tag);
        }
        $categoryId = $_POST['category'];
        $path = $_SERVER['DOCUMENT_ROOT'] . '/images/';
        $ext = explode('.', $_FILES['img']['name'])[1]; // расширение
        $new_name = time() . '.' . $ext; // новое имя с расширением
        $full_path = $path . $new_name; // полный путь с новым именем и расширением
        $types = array('image/png', 'image/jpeg');
        $size = 1024000;

        //add tags to db
        $tagsId = $this->addTags($tags);

        // Обработка запроса
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Проверяем тип файла
            if (!in_array($_FILES['img']['type'], $types))
                return redirect()->back()->withErrors(['Неправильний тип файлу!']);
            // Проверяем размер файла
            if ($_FILES['img']['size'] > $size)
                return redirect()->back()->withErrors(['Файл завеликий!']);
            // Загрузка файла и вывод сообщения
            if ($_FILES['img']['error'] == 0) {
                if (move_uploaded_file($_FILES['img']['tmp_name'], $full_path)) {

                    $issetTag = DB::table('news')->where('title', '=', $title)->first();
                    if ($issetTag === null) {
                        $id = DB::table('news')->insertGetId(
                            [
                                'title' => $title,
                                'content' => $content,
                                'img' => $new_name,
                                'created_at' => date('Y-m-d H:i:s'),
                                'number_of_views' => 0
                            ]
                        );

                        foreach ($tagsId as $tagId) {
                            DB::table('news_tag')->insert(
                                ['news_id' => $id, 'tag_id' => $tagId->id]
                            );
                        }
                        DB::table('news_category')->insert(
                            ['news_id' => $id, 'category_id' => $categoryId]
                        );
                    }
                    return redirect()->back()->with('message', 'Додано!');
                }
            }
        }
    }

    /**
     * @param array $tags
     * @return mixed
     */
    private function addTags(array $tags)
    {
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $issetTag = DB::table('tags')->where('name', '=', $tag)->first();
                if ($issetTag === null) {
                    $rez = DB::table('tags')->insert(
                        ['name' => $tag]
                    );
                }
            }
            $tagsId = DB::table('tags')->select('id')->whereIn('name', $tags)->get();

        }
        return $tagsId;
    }
}
