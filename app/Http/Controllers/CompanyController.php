<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\StoreRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    use ResponseTrait;
    private string $table;
    private object $model;
    public function __construct()
    {
        $this->model = Company::query();
    }

    public function index(Request $request)
    {
        $data = $this->model
        ->where('name', 'like', '%'.$request->get('q').'%')
        ->get();

        return $this->successResponse($data);
    }

    public function check($companyName)
    {
        $data = $this->model
            ->where('name', '=', $companyName)
            ->exists();

        return $this->successResponse($data);
    }

    public function store(StoreRequest $request)
    {
        try {
            $arr = $request->validated();
            $arr['logo'] = optional($request->file('logo'))->store('company_logo');

            Company::create($arr);
            return $this->successResponse();
        }
        catch (\Throwable $th) {
            $message = '';
            if($th->getCode() == '23000') {
                $message = 'Duplicate company name, please try again.';
            }
            return $this->errorResponse($message);
        }

    }
}
