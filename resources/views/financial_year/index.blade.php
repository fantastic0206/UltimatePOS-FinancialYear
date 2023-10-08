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
            <button type="button" class="btn btn-info  btn-modal col-md-5 pull-right">
                <i class="fa fa-plus"></i> Create Financial Year
            </button>
        </div>
    </div>
</section>
<!-- /.content -->

@endsection