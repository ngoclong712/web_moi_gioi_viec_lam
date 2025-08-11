<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private object $model;
    public function __construct()
    {
        $this->model = Post::query();
    }

    public function index()
    {
        $data =  $this->model->paginate();
        foreach($data as $each){
            $each->currency_salary = $each->currency_salary_code;
            $each->status = $each->status_name;
        }

        return response()->json([
            'data' => $data->getCollection(),
            'success' => true,
            'pagination' => $data->linkCollection(),
        ]);
    }
}
