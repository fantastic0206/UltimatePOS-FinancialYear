@extends('layouts.app')

@section('title', __('financial.financial_year'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('financial.financial_year')
        <small>@lang('financial.financial_year')</small>
    </h1>
</section>

<!-- Main Content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                You can end Financial Year at the end of Financial year. If you end Financial year Your all closing balance will be added in opening Balance for new Financial year.
            </div>
        </div>
        <div class="col-md-12">
            <button type="button" class="btn btn-danger col-md-5">
                End Your Financial Year
            </button>
            @can('financial.create')
            <button type="button" class="btn btn-info btn-modal col-md-5 pull-right" data-href="{{action([\App\Http\Controllers\FinancialYearController::class, 'create'])}}" data-container=".financial_years_modal">
                <i class="fa fa-plus"></i> Create Financial Year
            </button>
            @endcan
        </div>
    </div>
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'lang_v1.all_your_financial_years' )])
    @can('financial.view')
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="financial_years_table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Title</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
    @endcan
    @endcomponent

    <div class="modal fade financial_years_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>
</section>
<!-- /.content -->
@stop
@section('javascript')

<script type="text/javascript">

</script>

@endsection