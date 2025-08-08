<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TestController extends Controller
{
    private string $table;
    private object $model;
    public function __construct()
    {
        $this->model = User::query();
        $this->table = (new User())->getTable();
        View::share([
            'title' => ucwords($this->table),
            'table' => $this->table,
        ]);
    }
}
