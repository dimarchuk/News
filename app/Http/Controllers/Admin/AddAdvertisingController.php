<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddAdvertisingController extends Controller
{
    /**
     * AddAdvertisingController constructor.
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
        return view('admin.advertising.advertising');
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function add()
    {
        $product_name = $_POST['product_name'];
        $price = $_POST['price'];
        $salesman = $_POST['salesman'];
        $discount = $_POST['discount'];

        if (!empty($product_name) && !empty($price) && !empty($salesman) && !empty($discount)) {
            DB::table('advertising')->insert([
                [
                    'product_name' => $product_name,
                    'price' => $price,
                    'advertiser' => $salesman,
                    'discount' => $discount
                ]
            ]);
        } else {
            return redirect()->back()->withErrors(['Заповніть поля!']);
        }
        return redirect()->back()->with('message', 'Додано!');

    }
}
