<?php

namespace App\Http\Controllers\Applicant;

use App\Enums\PostRemotableEnum;
use App\Enums\PostStatusEnum;
use App\Enums\SystemCacheKeyEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Applicant\Homepage\IndexRequest;
use App\Models\Config;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class HomePageController extends Controller
{
    public function index(IndexRequest $request)
    {
        $searchCities = $request->get('cities') ?? [];
        $configs = Config::getAndCache(0);
        $minSalary = $request->get('min_salary', $configs['filter_min_salary']);
        $maxSalary = $request->get('max_salary', $configs['filter_max_salary']);
        $remotable = $request->get('remotable');

        $filters[] = [];
        if(!empty($searchCities)) {
            $filters['cities'] = $searchCities;
        }
        if($request->has('min_salary')) {
            $filters['min_salary'] = $minSalary;
        }
        if($request->has('max_salary')) {
            $filters['max_salary'] = $maxSalary;
        }
        if(!empty($remotable)) {
            $filters['remotable'] = $remotable;
        }

        $posts = Post::query()
            ->indexHomepage($filters)
            ->paginate()
            ->appends(['cities' => $searchCities]);

        $arrCity = getAndCachePostCities();
        $filterRemotable = PostRemotableEnum::getRemotableArray();

        return view('applicant.index', [
            'posts' => $posts,
            'arrCity' => $arrCity,
            'searchCities' => $searchCities,
            'minSalary' => $minSalary,
            'maxSalary' => $maxSalary,
            'configs' => $configs,
            'filterRemotable' => $filterRemotable,
            'remotable' => $remotable,
        ]);
    }

    public function show($postId)
    {
        $post = Post::query()
            ->with(['file'])
            ->approved()
            ->findOrFail($postId);

        return view('applicant.show', [
            'post' => $post,
        ]);
    }
}
