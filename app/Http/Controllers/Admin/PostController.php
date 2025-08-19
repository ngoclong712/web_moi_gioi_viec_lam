<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ObjectLanguageTypeEnum;
use App\Enums\PostCurrencySalaryEnum;
use App\Enums\PostRemotableEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Controllers\SystemConfigController;
use App\Http\Requests\Post\StoreRequest;
use App\Imports\PostsImport;
use App\Models\Company;
use App\Models\ObjectLanguage;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class PostController extends Controller
{
    use ResponseTrait;
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
        $configs = SystemConfigController::getAndCache();

        return view('admin.posts.create', [
            'currencies' => $configs['currencies'],
            'countries' => $configs['countries'],
        ]);
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $arr = $request->only([
                "job_title",
                "district",
                "city",
                "min_salary",
                "max_salary",
                "currency_salary",
                "requirement",
                "start_date",
                "end_date",
                "number_applicants",
                "slug",
            ]);
            $companyName = $request->get('company');

            if(!empty($companyName)) {
                $arr['company_id'] = Company::query()->firstOrCreate(['name' => $companyName])->id;
            }
            if($request->has('remotables')) {
                $remotables = $request->get('remotables');
                if(!empty($remotables['remote']) && !empty($remotables['office'])) {
                    $arr['remotable'] = PostRemotableEnum::HYBRID;
                }else if(!empty($remotables['remote'])) {
                    $arr['remotable'] = PostRemotableEnum::REMOTE_ONLY;
                }else {
                    $arr['remotable'] = PostRemotableEnum::OFFICE_ONLY;
                }
            }
            if($request->has('can_parttime')) {
                $arr['can_parttime'] = 1;
            }

            $post = Post::create($arr);
            $languages = $request->get('languages');

            foreach($languages as $language) {
                ObjectLanguage::create([
                    'language_id' => $language,
                    'object_id' => $post->id,
                    'object_type' => Post::class,
                ]);
            }

            DB::commit();

            return $this->successResponse();
        }
        catch (Throwable $th) {
            DB::rollBack();
            return $this->errorResponse();
        }
    }

    public function importCsv(Request $request)
    {
//        return 1;
        try {
            Excel::import(new PostsImport,  $request->file('file'));
            return $this->successResponse();
        }
        catch (Throwable $th) {
            return $this->errorResponse();
        }
    }
}
