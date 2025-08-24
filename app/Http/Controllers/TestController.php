<?php

namespace App\Http\Controllers;

use App\Enums\FileTypeEnum;
use App\Enums\PostCurrencySalaryEnum;
use App\Enums\PostStatusEnum;
use App\Enums\UserRoleEnum;
use App\Models\Company;
use App\Models\File;
use App\Models\Language;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use NumberFormatter;

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

    public function test()
    {
//        return DB::getSchemaBuilder()->getColumnListing('posts');

        return user();
    }
}
