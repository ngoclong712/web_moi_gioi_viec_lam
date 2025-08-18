<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class HomePageController extends Controller
{
    public function index()
    {
//        dd(app()->getLocale());
        $posts = Post::query()
            ->with([
                'languages',
                'company' => function ($q) {
                    return $q -> select([
                        'id',
                        'name',
                        'logo'
                    ]);
                }
            ])
//            ->latest()
//            ->limit(10)
            ->latest()
            ->paginate();
//            ->get();
//        dd($posts->toArray());
        return view('applicant.index', [
            'posts' => $posts,
        ]);
    }
}
