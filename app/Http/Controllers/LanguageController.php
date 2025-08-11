<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    use ResponseTrait;
    private string $table;
    private object $model;
    public function __construct()
    {
        $this->model = Language::query();
    }

    public function index(Request $request)
    {
        $data = $this->model
            ->where('name', 'like', '%'.$request->get('q').'%')
            ->get();

        return $this->successResponse($data);
    }
}
