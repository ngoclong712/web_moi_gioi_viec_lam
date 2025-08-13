<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $configs = SystemConfigController::getAndCache();
        $data = $configs['languages'];
        if ($request->get('q') != null) {
            $data = $configs['languages']->filter(function ($each) use ($request) {
                return Str::contains(strtolower($each['name']), $request->get('q'));
            });
        };

        return $this->successResponse($data);
    }
}
