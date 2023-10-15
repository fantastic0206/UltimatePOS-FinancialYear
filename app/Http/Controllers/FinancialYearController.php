<?php

namespace App\Http\Controllers;

use App\FinancialYear;
use Illuminate\Http\Request;
use App\Utils\BusinessUtil;
use App\Utils\Util;
use Yajra\DataTables\Facades\DataTables;

class FinancialYearController extends Controller
{
    /**
     * All Utils instance.
     */
    protected $businessUtil;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(Util $commonUtil, BusinessUtil $businessUtil)
    {
        $this->commonUtil = $commonUtil;
        $this->businessUtil = $businessUtil;
    }

    /**
     * Show the application financial year.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! auth()->user()->can('financial.view')) {
            abort(403, 'Unauthorized action.');
        }
        
        // var_dump("==============", request()->ajax());exit();
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $financial_year = FinancialYear::where('financial_years.business_id', $business_id)
                                ->select(['financial_years.title', 'financial_years.start_date', 'financial_years.end_date', 'financial_years.status']);
            return Datatables::of($financial_year)
                    ->addColumn(
                        'action',
                        '@can("financial.update")
                            <button data-href="{{action(\'App\Http\Controllers\FinancialYearController@edit\', [$id])}}" class="btn btn-xs btn-primary edit_financial_year_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                        &nbsp;
                        @endcan

                        @can("financial.delete")
                            <button data-href="{{action(\'App\Http\Controllers\FinancialYearController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_financial_year_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>
                        @endcan'
                    )
                    ->removeColumn('id')
                    ->rawColumns([3])
                    ->make(false);
        }

        return view('financial_year.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! auth()->user()->can('financial_year.create')) {
            abort(403, 'Unauthorized action.');
        }

        // $default_datetime = $this->businessUtil->format_date('now', true);
        $default_datetime = date("M/D/Y");

        // $business_id = request()->session()->get('user.business_id');
        // $price_groups = SellingPriceGroup::forDropdown($business_id, false);

        // return view('financial_year.create')->with(compact('price_groups'));
        return view('financial_year.create')->with(compact('default_datetime'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('customer.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['title', 'start_date']);
            $input['business_id'] = $request->session()->get('user.business_id');
            $input['created_by'] = $request->session()->get('user.id');
            $input['status'] = 1;

            $financial_year = FinancialYear::create($input);
            $output = ['success' => true,
                'data' => $financial_year,
                'msg' => __('lang_v1.success'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerGroup  $customerGroup
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! auth()->user()->can('customer.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $customer_group = CustomerGroup::where('business_id', $business_id)->find($id);

            $business_id = request()->session()->get('user.business_id');
            $price_groups = SellingPriceGroup::forDropdown($business_id, false);

            return view('customer_group.edit')
                ->with(compact('customer_group', 'price_groups'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! auth()->user()->can('customer.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['name', 'amount', 'price_calculation_type', 'selling_price_group_id']);
                $business_id = $request->session()->get('user.business_id');

                $input['amount'] = ! empty($input['amount']) ? $this->commonUtil->num_uf($input['amount']) : 0;

                $customer_group = CustomerGroup::where('business_id', $business_id)->findOrFail($id);

                $customer_group->update($input);

                $output = ['success' => true,
                    'msg' => __('lang_v1.success'),
                ];
            } catch (\Exception $e) {
                \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

                $output = ['success' => false,
                    'msg' => __('messages.something_went_wrong'),
                ];
            }

            return $output;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! auth()->user()->can('customer.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $business_id = request()->user()->business_id;

                $cg = CustomerGroup::where('business_id', $business_id)->findOrFail($id);
                $cg->delete();

                $output = ['success' => true,
                    'msg' => __('lang_v1.success'),
                ];
            } catch (\Exception $e) {
                \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

                $output = ['success' => false,
                    'msg' => __('messages.something_went_wrong'),
                ];
            }

            return $output;
        }
    }
}
