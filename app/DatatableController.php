<?php


namespace App;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\JsonResponse;


class DatatableController extends Controller
{
    public function listUsers(): JsonResponse
    {
        return datatables()
            ->eloquent(User::query()->orderBy('updated_at', 'desc'))
            ->addColumn('btn', 'admin.users.partials._actions')
            ->rawColumns(['btn'])
            ->toJson();
    }

}
