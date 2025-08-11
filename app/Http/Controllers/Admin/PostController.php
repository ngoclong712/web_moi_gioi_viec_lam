<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\PostsImport;
use App\Models\Company;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class PostController extends Controller
{
    private string $table;
    private object $model;
    public function __construct()
    {
        $this->model = Post::query();
        $this->table = (new Post())->getTable();
        View::share([
            'title' => ucwords($this->table),
            'table' => $this->table,
        ]);
    }

    public function index()
    {
        return view('admin.posts.index');
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function importCsv(Request $request)
    {
//        return 1;
        Excel::import(new PostsImport,  $request->file('file'));
    }
}
