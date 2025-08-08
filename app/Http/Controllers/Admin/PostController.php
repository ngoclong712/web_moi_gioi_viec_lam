<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Post;
use Illuminate\Support\Facades\View;

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
        $companies = Company::query()->get();
        return view('admin.posts.index');
    }

    public function importCsv()
    {
        return 1;
    }
}
