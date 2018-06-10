<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * Class AddCategoriesController
 * @package App\Http\Controllers\Admin
 */
class AddCategoriesController extends Controller
{
    /**
     * AddCategoriesController constructor.
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
        return view('admin.category.category');
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function add()
    {
        if (!empty($_POST['category'])) {
            DB::table('categories')->insert([
                ['category_name' => $_POST['category']]
            ]);
        } else {
            return redirect()->back()->withErrors(['Введіть категорію!']);
        }
        return redirect()->back()->with('message', 'Додано!');

    }
}
