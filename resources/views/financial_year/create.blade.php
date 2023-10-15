<div class="modal-dialog" role="document">
  <div class="modal-content">
    {!! Form::open(['url' => action([\App\Http\Controllers\FinancialYearController::class, 'store']), 'method' => 'post', 'id' => 'financial_year_add_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'lang_v1.add_financial_year' )</h4>
    </div>

    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('title', __( 'lang_v1.financial_year_name' ) . ':*') !!}
        {!! Form::text('title', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang_v1.financial_year_name' ) ]); !!}
      </div>

      <div class="form-group">
        {!! Form::label('start_date', __('financial.start_date') . ':') !!}
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </span>
          {!! Form::date('start_date', $default_datetime, ['class' => 'form-control', '', 'required']); !!}
        </div>
      </div>

    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->