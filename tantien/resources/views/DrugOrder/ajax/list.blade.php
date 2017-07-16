<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('index.list') }}</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="box-header">
                <div class="btn-group pull-left">
                    <h4>
                        @if($displaySum and \Auth::user()->is_admin == 1)
                            {{ __('index.total cash') . ' : ' . number_format($sum, 0, '.', ' ') }} VND
                        @endif
                    </h4>
                </div>
                <div class="btn-group pull-right">
                    {{ Form::button(__('index.add new'), [
                        'class' => 'add-action btn btn-primary',
                        'data-object' => $controller,
                        'type' => 'button',
                        'data-toggle' => 'modal',
                        'data-target' => '#add' . $controller . 'Modal'
                    ])}}
                </div>
            </div>
            <div class="scrollView">
                <div class="box-body">
                    <table id="{{ $controller }}" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="30%" scope="col" class="sort-action">{{ __('index.drugOrder code') }}</th>
                                <th width="55%" scope="col" class="sort-action">{{ __('index.total cash') }}</th>
                                <th width="15%" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($drugOrder as $order)
                            <tr>
                                <td>
                                    <a href="javascript:void(0)" class="edit-action" data-id="{{ $order->id }}" data-object="{{ $controller }}">
                                        {{ $order->id }}
                                    </a>
                                </td>
                                <td>
                                    {{ number_format($order->getTotal(), 0, '.', ' ') }} VND
                                </td>
                                <td>
                                    <a class="delete-action btn btn-danger btn-list" data-id="{{ $order->id }}"
                                        data-object="{{ $controller }}" >
                                        {{ __('index.remove') }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('Layout.paging', ['paginator' => $drugOrder])
