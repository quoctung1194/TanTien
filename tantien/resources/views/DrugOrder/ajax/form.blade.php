<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header first-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="runSaveDataFormgroupsModalLabel">
                {{ __('index.drugOrder') }}
            </h4>
        </div>

        <!-- route hidden -->
        <input type="hidden" id="DO-getDrugList" value="{{ route('DO-getDrugList') }}" />
        <input type="hidden" id="DO-getUnitList" value="{{ route('DO-getUnitList') }}" />
        <input type="hidden" id="DO-getSum" value="{{ route('DO-getSum') }}" />

        <form class="form-horizontal" id="{{ $action . $controller . 'ModalForm' }}">
            <input type="hidden" id="id" value="{{ $drugOrder->id }}" name="id" />
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        {{ __('index.drugOrder code') }}
                    </label>
                    <div class="col-sm-8">
                        {{ Form::text('code', $drugOrder->code, [
                            'class' => 'form-control',
                            'required' => 'required',
                            'placeholder' => __('index.drugOrder code'),
                        ])}}
                    </div>
                </div>
                
                <div class="modal-header">
                    <h4 class="modal-title">
                        <label>-------- {{ __('index.drugOrder list') }} --------</label>
                    </h4>
                </div>

                <!-- default table begin -->
                <table id="defaultTable" style="display: none;">
                    <tbody>
                        <tr id="addDrug-00">
                            <td></td>
                            <td>
                                {{ Form::select('', [], null, [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                ])}}
                            </td>
                            <td>
                                {{ Form::select('', [], null, [
                                    'class' => 'form-control unit-select2',
                                    'required' => 'required',
                                ])}}
                            </td>
                            <td>
                                {{ Form::number('', 1, [
                                    'class' => 'form-control quantity',
                                    'required' => 'required',
                                    'range' => '[1, 100]'
                                ])}}
                            </td>
                            <td style="text-align: right;">
                                <label>0 VND</label>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger removeRow">
                                    {{ __('index.remove') }}
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- default table end -->

                <table id="addDrug" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="10%">
                                {{ __('index.order number') }}
                            </th>
                            <th width="25%">
                                {{ __('index.drug name') }}
                            </th>
                            <th width="15%">
                                {{ __('index.unit') }}
                            </th>
                            <th width="15%">
                                {{ __('index.quantity') }}
                            </th>
                            <th width="20%" style="text-align: right;">
                                {{ __('index.total cash') }}
                            </th>
                            <th width="auto">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($action === 'edit')
                            @php
                                $index = 0;
                            @endphp

                            @foreach ($drugOrder->orderDetails as $item)
                            <tr id="addDrug-{{ ++$index }}">
                                <td>
                                    {{ $index }}
                                </td>
                                <td>
                                    {{ Form::select('', [$item->drug_id => $item->drug->name], null, [
                                        'class' => 'form-control drug-select2',
                                        'required' => 'required',
                                        'name' => 'drugDetail[' . $index . '][drug_id]',
                                        'data-target' => $index
                                    ])}}    
                                </td>
                                <td>
                                    {{ Form::select('', [$item->unit_id => $item->unit->name], null, [
                                        'class' => 'form-control unit-select2',
                                        'required' => 'required',
                                        'name' => 'drugDetail[' . $index . '][unit_id]',
                                        'data-target' => $index
                                    ])}}
                                    <script>
                                        loadUnitCombobox(
                                            '{{ $item->drug_id }}',
                                            '[name="drugDetail[{{$index}}][unit_id]"]'
                                        );
                                    </script>
                                </td>
                                <td>
                                    {{ Form::number('', $item->quantity, [
                                        'class' => 'form-control quantity',
                                        'required' => 'required',
                                        'range' => '[1, 100]',
                                        'name' => 'drugDetail[' . $index . '][quantity]',
                                        'data-target' => $index,
                                        'onChange' => 'getSumOfDrug(' . $index . ')',
                                    ])}}
                                </td>
                                <td style="text-align: right;">
                                    <label name="drugDetail[{{ $index }}][sum]">
                                        {{ number_format($item->sum, 0, '.', ' ') }} VND
                                    </label>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger removeRow">
                                        {{ __('index.remove') }}
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                @if ($action === 'edit')
                <table class="table table-bordered">
                     <tr>
                        <td colspan="5">
                            <div class="row pad5"  style="margin-right: 10px">
                                <h4 class="pull-right pad10" >
                                    <b>{{ number_format($drugOrder->getTotal(), 0, '.', ' ') }} VND</b>
                                </h4>
                            </div>
                        </td>
                    </tr>
                </table>
                @endif

                <button type="button" class="btn btn-primary pull-right pad10"
                    onclick="addNewDrugOrderRow('{{ $action . $controller . 'ModalForm' }}')">
                    {{ __('index.add new') }}
                </button>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                    {{ __('index.save') }}
                </button>
                <button type="submit" data-dismiss="modal" class="btn btn-defauly active">
                    {{ __('index.close') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
   loadDrugCombobox();
   runSaveDataForm('{{ $controller }}', '{{ $action }}');
</script>