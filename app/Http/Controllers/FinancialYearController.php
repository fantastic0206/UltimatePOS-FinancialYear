<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinancialYearController extends Controller
{
    /**
     * Show the application financial year.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->user_type == 'user_customer') {
            return redirect()->action([\Modules\Crm\Http\Controllers\DashboardController::class, 'index']);
        }

        return view('financial_year.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('financial_year.create');
    }
}
