<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

/**
 * Class BGCController
 * @package App\Http\Controllers
 */
class BGCController extends Controller
{
    /**
     *
     */
    public function index()
    {
        $resp = DB::table('background_site_colors')->where('id', '=', 1)->first();

            return response(json_encode($resp), 200)
                ->header('Content-type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*');
    }
}
