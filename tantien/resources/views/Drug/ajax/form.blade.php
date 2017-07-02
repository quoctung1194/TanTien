<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header first-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="runSaveDataFormgroupsModalLabel">
                {{ __('index.drug') }}
            </h4>
        </div>

        <form class="form-horizontal" id="{{ $action . $controller . 'ModalForm' }}">
            <input type="hidden" id="id" value="{{ $drug->id }}" name="id" />
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        {{ __('index.drug name') }}
                    </label>
                    <div class="col-sm-8">
                        {{ Form::text('name', $drug->name , [
                            'class' => 'form-control',
                            'required' => 'required',
                            'placeholder' => __('index.drug name'),
                        ])}}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        {{ __('index.drug original_price') }}
                    </label>
                    <div class="col-sm-8">
                        {{ Form::number('original_price', $drug->original_price , [
                            'class' => 'form-control',
                            'placeholder' => __('index.drug original_price'),
                        ])}}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">
                        {{ __('index.drug price') }}
                    </label>
                    <div class="col-sm-8">
                        {{ Form::number('price', $drug->price , [
                            'class' => 'form-control',
                            'required' => 'required',
                            'placeholder' => __('index.drug price'),
                        ])}}
                    </div>
                </div>

                <div class="modal-header">
                    <h4 class="modal-title">
                        <label>-------- {{ __('index.drug standard') }} --------</label>
                    </h4>
                </div>

                <!-- default table begin -->
                <table id="defaultTable" style="display: none;">
                    <tbody>
                        <tr id="addStandard-00">
                            <td>
                                <select class="form-control">
                                    @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" value="1" required="required" class="form-control" />
                            </td>
                            <td>
                                <select class="form-control">
                                    @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- default table end -->

                <table id="addStandard" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="40%">
                                {{ __('index.unit') }}
                            </th>
                            <th width="30%">
                                {{ __('index.quantity') }}
                            </th>
                            <th width="30%">
                                {{ __('index.unit_ref') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody> 
                        @if($action == 'edit')
                            @php
                                $index = 0;
                            @endphp

                            @foreach ($drug->unitPirce as $item)
                                @if($item->ref_unit_id != -1)
                                <tr id="addStandard-{{ ++$index }}">
                                    <td>
                                        <select name="standard[{{ $index }}][unit_id]" class="form-control">
                                            @foreach($units as $unit)
                                                @if($unit->id == $item->unit_id)
                                                    <option selected value="{{ $unit->id }}">
                                                        {{ $unit->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $unit->id }}">
                                                        {{ $unit->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" value="{{ $item->quantity }}"
                                            name="standard[{{ $index }}][quantity]"
                                            required="required" class="form-control" />
                                    </td>
                                    <td>
                                        <select name="standard[{{ $index }}][ref_unit_id]"
                                            class="form-control">
                                            @foreach($units as $unit)
                                                @if($unit->id == $item->ref_unit_id)
                                                    <option selected value="{{ $unit->id }}">
                                                        {{ $unit->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $unit->id }}">
                                                        {{ $unit->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>

                <button type="button" class="btn btn-primary pull-right pad10"
                    onclick="addNewStandard()">
                    {{ __('index.add new') }}
                </button>

                <button type="button" style="margin-right: 5px" class="btn btn-danger pull-right pad10"
                    onclick="removeStandard()">
                    {{ __('index.remove') }}
                </button>


                <div class="modal-header">
                    <h4 class="modal-title">
                        <label>-------- {{ __('index.drug special_prices') }} --------</label>
                    </h4>
                </div>

                <!-- default table begin -->
                <table id="defaultSpecialTable" style="display: none;">
                    <tbody>
                        <tr id="addSpecial-00">
                            <td>
                                <input type="number" value="1" required="required" class="form-control" />
                            </td>
                            <td>
                                <select class="form-control">
                                    @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" value="1" required="required" class="form-control" />
                            </td>
                            <td style="text-align: center;">
                                <button type="button" class="btn btn-danger removeRow" >
                                    {{ __('index.remove') }}
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- default table end -->

                <table id="addSpecial" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="30%">
                                {{ __('index.quantity') }}
                            </th>
                            <th width="30%">
                                {{ __('index.unit') }}
                            </th>
                            <th width="30%">
                                {{ __('index.price') }}
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($action == 'edit')
                            @php
                                $index = 0;
                            @endphp

                            @foreach ($drug->specialPrice as $item)
                                <tr id="addSpecial-{{ ++$index }}">
                                    <td>
                                        <input type="number" value="{{ $item->quantity }}" required="required"
                                            name="special[{{ $index }}][quantity]" class="form-control" />
                                    </td>
                                    <td>
                                        <select name="special[{{ $index }}][unit_id]"
                                            class="form-control">
                                            @foreach($units as $unit)
                                                @if($unit->id == $item->unit_id)
                                                    <option selected value="{{ $unit->id }}">
                                                        {{ $unit->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $unit->id }}">
                                                        {{ $unit->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" value="{{ $item->price }}"
                                            name="special[{{ $index }}][price]"
                                            required="required" class="form-control" />
                                    </td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-danger removeRow" >
                                            {{ __('index.remove') }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                <button type="button" class="btn btn-primary pull-right pad10"
                    onclick="addNewSpecialPrice()">
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
   runSaveDataForm('{{ $controller }}', '{{ $action }}');
</script>