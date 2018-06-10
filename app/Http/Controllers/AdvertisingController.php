<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

/**
 * Class AdvertisingController
 * @package App\Http\Controllers
 */
class AdvertisingController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $resp = DB::table('advertising')->orderBy(DB::raw('RAND()'))->take(1)->first();

        return response(json_encode($resp), 200)
            ->header('Content-type', 'application/json')
            ->header('Access-Control-Allow-Origin', '*');
    }
}
