<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class setBGCController extends Controller
{
    /**
     * setBGCController constructor.
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
        return view('admin.setbgc.setbgc');
    }

    public function set()
    {
        $bodyBgc = $_POST['bodyBgc'];
        $headBgc = $_POST['headBgc'];

        if (!empty($bodyBgc) && !empty($headBgc)) {
            $issetColor = DB::table('background_site_colors')->where('id', '=', 1)->first();
            if ($issetColor !== null) {
                DB::table('background_site_colors')->where('id', 1)
                    ->update(
                        [
                            'bgc_body' => $bodyBgc,
                            'bgc_header' => $headBgc
                        ]
                    );
            } else {
                DB::table('background_site_colors')->insert([
                    [
                        'bgc_body' => $bodyBgc,
                        'bgc_header' => $headBgc,
                    ]
                ]);
            }
        } else {
            return redirect()->back()->withErrors(['Заповніть поля!']);
        }
        return redirect()->back()->with('message', 'Додано!');
    }
}
