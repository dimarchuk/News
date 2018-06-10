<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * Class UpdateController
 * @package App\Http\Controllers\Admin
 */
class UpdateController extends Controller
{
    public function index(int $commentId)
    {
        $comments = DB::table('comments')
            ->select('id', 'comment_text')
            ->where('id', '=', $commentId)
            ->first();

        return view('admin.update.update', ['comment' => $comments]);
    }

    /**
     *
     */
    public function update()
    {

        $commentId = $_POST['id'];
        $content = $_POST['content'];

        DB::table('comments')->where('id', $commentId)
            ->update(
                [
                    'comment_text' => $content
                ]
            );

        return redirect('/comments');
    }
}
