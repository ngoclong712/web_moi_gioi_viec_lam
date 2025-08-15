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
        $posts = Post::with('languages')
            ->latest()
            ->paginate();
//        dd($posts->languages->toArray());
        return view('applicant.index', [
            'posts' => $posts,
        ]);
    }
}
