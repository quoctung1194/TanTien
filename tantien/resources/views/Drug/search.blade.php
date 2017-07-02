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
            <div class="form-group">
                <label class="col-sm-3 control-label label-center padding-right-none">
                    {{ __('index.drug name') }}
                </label>
                <div class="col-sm-5 ui-widget">
                    <input type="text" name="name" class="form-control name" />
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div>
                        {{ Form::button(__('index.clear'), [
                            'id' => $controller . 'resetBtn',
                            'class' => 'btn btn-default active rightBtn pull-right',
                            'type' => 'reset',
                            'style' => 'margin-left: 5px'
                        ])}}
                    </div>
                    <div>
                        {{ Form::button(__('index.search'), [
                            'id' => $controller . '_btn_search',
                            'class' => 'btn btn-primary pull-right',
                            'type' => 'button'
                        ])}}
                    </div>
                </div>
            </div>
        {{ Form::close() }}
    </div>
</div>
