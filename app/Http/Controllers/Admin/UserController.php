<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class UserController extends Controller
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

    public function index(Request $request)
    {
//        $data = $this->model->clone()
//            ->when($request->has('role') && $request->get('role') !== 'All', function ($query) use ($request) {
//                return $query->where('role', $request->get('role'));
//            })
//            ->when($request->has('city') && $request->get('city') !== 'All', function ($query) use ($request) {
//                return $query->where('city', $request->get('city'));
//            })
//            ->with('company:id,name')
//            ->latest()->paginate(5);

        $selectedRole = $request->get('role');
        $selectedCity = $request->get('city');
        $selectedCompany = $request->get('company');

        $query = $this->model->clone()
            ->with('company:id,name')
            ->latest();

        if(isset($selectedRole) && $selectedRole !== 'All') {
            $query->where('role', $selectedRole);
        }
        if(isset($selectedCity) && $selectedCity !== 'All') {
            $query->where('city', $selectedCity);
        }
        if(isset($selectedCompany) && $selectedCompany !== 'All') {
            $query->whereHas('company', function ($query) use ($selectedCompany) {
                return $query->where('id', $selectedCompany);
            });
        }

        $data = $query->paginate(5);

        $roles = UserRoleEnum::asArray();
        $cities = $this->model->clone()
            ->distinct()
            ->limit(10)
            ->pluck('city');
        $companies = Company::query()
            ->select('id', 'name')
            ->get();

        return view("admin.$this->table.index",  [
            'data' => $data,
            'roles' => $roles,
            'cities' => $cities,
            'companies' => $companies,
            'selectedRole' => $selectedRole,
            'selectedCompany' => $selectedCompany,
            'selectedCity' => $selectedCity,
        ]);
    }

    public function show(User $user)
    {

    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back();
    }
}
