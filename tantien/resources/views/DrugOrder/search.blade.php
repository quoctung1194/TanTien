<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('index.search') }}</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        {{ Form::open([
            'class' => 'form-horizontal',
            'id' => 'searchForm'
        ])}}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label label-center padding-right-none">
                        {{ __('index.drugOrder code') }}
                    </label>
                    <div class="col-sm-8 ui-widget">
                        {{ Form::text('code', null, [
                            'class' => 'form-control search-input',
                        ])}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div>
                    {{ Form::button(__('index.clear'), [
                        'class' => 'btn btn-default active rightBtn pull-right',
                        'type' => 'reset',
                        'style' => 'margin-left: 5px'
                    ])}}
                </div>
                <div>
                    {{ Form::button(__('index.search'), [
                        'class' => 'btn btn-primary pull-right',
                        'type' => 'button'
                    ])}}
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
