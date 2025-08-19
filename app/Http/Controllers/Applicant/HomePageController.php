<?php

namespace App\Http\Controllers\Applicant;

use App\Enums\SystemCacheKeyEnum;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class HomePageController extends Controller
{
    public function index(Request $request)
    {
        $searchCities = $request->get('cities') ?? [];

        $arrCity = getAndCachePostCities();

        $query = Post::query()
            ->with([
                'languages',
                'company' => function ($q) {
                    return $q->select([
                        'id',
                        'name',
                        'logo'
                    ]);
                }
            ])
            ->latest();

        if(!empty($searchCities)) {
            $query->where(function ($q) use ($searchCities) {
                foreach ($searchCities as $searchCity) {
                    $q->orWhere('city', 'like', '%' . $searchCity . '%');
                }
                $q->orWhereNull('city');
                return $q;
            });
        }
        $posts = $query->paginate();
        $posts->appends(['cities' => $searchCities]);
        return view('applicant.index', [
            'posts' => $posts,
            'arrCity' => $arrCity,
            'searchCities' => $searchCities,
        ]);
    }
}
