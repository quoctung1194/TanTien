<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Drug;
use App\Unit;
use App\UnitPrice;
use App\SpecialPrice;

class DrugController extends Controller
{
    /**
     * Index action
     *
     * @return void
     */
    public function index()
    {
        return $this->view('index');
    }

    /**
     * Search action
     *
     * @return void
     */
    public function search(Request $request)
    {
        // limit items per page
        $limit = \Config::get('tantien.limit');
        // assign from form values
        $name = $request->name;
        // query builder
        $query = Drug::query();

        // where conditions
        $find_condition = [
            ['name', 'like', '%' . $name . '%']
        ];
        $query = $query
            ->where($find_condition);

        // get sorting columns array
        $sortArr = $this->getSortColumns();
        foreach ($sortArr as $col => $direct) {
            $query = $query->orderBy($col, $direct);
        }

        // result list
        $drugs = $query->paginate($limit);
        return $this->view('ajax.list', compact('drugs'));
    }

    /**
     * Add method
     *
     * @return void
     */
    public function add(Request $request)
    {
        // init new entity
        $drug = new Drug();

        // load unit
        $units = Unit::all();

        if ($request->isMethod('post')) {
            // get form values
            $name = $request->name;
            $standardDetails = $request->standard;
            if(!empty($request->special)) {
                $specialDetails = $request->special;
            } else {
                $specialDetails = [];
            }

            // checking validate
            if (Drug::where('name', strtolower($name))->count() > 0) {
                $result = [
                    'status' => false,
                    'error' => (object)[
                        'msg' => __('index.drug duplicate'),
                    ]
                ];

                echo json_encode($result);
                return;
            } else if (!isset($standardDetails)) {
                $result = [
                    'status' => false,
                    'error' => (object)[
                        'msg' => __('index.drug emptyStandard'),
                    ]
                ];

                echo json_encode($result);
                return;
            }

            // assign standard into array
            $unitPrices = [];
            $last_ref_unit_id = -1;
            foreach ($standardDetails as $standard) {
               $item = new UnitPrice();
               $item->fill($standard);

               $unitPrices[] = $item;
               // save last ref_unit_id
               $last_ref_unit_id = $standard['ref_unit_id'];
            }
            if($last_ref_unit_id != -1) {
                //create last unitPrice
                $item = new UnitPrice();
                $item->unit_id = $last_ref_unit_id;
                $item->ref_unit_id = -1;
                $item->quantity = -1;
                $unitPrices[] = $item;
            }

            // assign special into array
            $specialPrices = [];
            if(!empty($request->special)) {
                foreach($specialDetails as $special) {
                    $item = new SpecialPrice();
                    $item->fill($special);

                    $specialPrices[] = $item;
                }
            }

            $drug->fill($request->all());
            
            // saving to database
            $status = false;
            if($drug->save()) {
                $status = $drug->unitPirce()->saveMany($unitPrices);
                if(!empty($request->special)) {
                    $status = $drug->specialPrice()->saveMany($specialPrices);
                }
            }

            // response to client
            if(!$status) {
                $result = [
                    'status' => false,
                    'error' => (object)[
                        'msg' => __('index.common_save_error'),
                    ]
                ];
            } else {
                $result = [
                    'status' => true,
                    'id' => $drug->id,
                ];
            }

            echo json_encode($result);
            return;
        }

        // set variables and render view
        return $this->view('ajax.add', compact('drug', 'units'));
    }

    /**
     * Edit method
     *
     * @return void
     */
    public function edit(Request $request)
    {
        // init new entity
        $id = $request->id;
        // load unit
        $units = Unit::all();
        $drug = Drug::with('unitPirce', 'specialPrice')->find($id);

        if ($request->isMethod('post')) {
            // get form values
            $name = $request->name;
            $standardDetails = $request->standard;
            if(!empty($request->special)) {
                $specialDetails = $request->special;
            } else {
                $specialDetails = [];
            }

            // checking validate
            if (Drug::where('name', strtolower($name))
                    ->where('id', '!=', $id)
                    ->count() > 0) {
                $result = [
                    'status' => false,
                    'error' => (object)[
                        'msg' => __('index.drug duplicate'),
                    ]
                ];

                echo json_encode($result);
                return;
            } else if (!isset($standardDetails)) {
                $result = [
                    'status' => false,
                    'error' => (object)[
                        'msg' => __('index.drug emptyStandard'),
                    ]
                ];

                echo json_encode($result);
                return;
            }

            // delete all unitprices element
            $drug->unitPirce()->delete();
            // assign standard into array
            $unitPrices = [];
            $last_ref_unit_id = -1;
            foreach ($standardDetails as $standard) {
               $item = new UnitPrice();
               $item->fill($standard);

               $unitPrices[] = $item;
               // save last ref_unit_id
               $last_ref_unit_id = $standard['ref_unit_id'];
            }
            if($last_ref_unit_id != -1) {
                //create last unitPrice
                $item = new UnitPrice();
                $item->unit_id = $last_ref_unit_id;
                $item->ref_unit_id = -1;
                $item->quantity = -1;
                $unitPrices[] = $item;
            }

            // delete all special price element
            $drug->specialPrice()->delete();
            // assign special into array
            $specialPrices = [];
            if(!empty($request->special)) {
                foreach($specialDetails as $special) {
                    $item = new SpecialPrice();
                    $item->fill($special);

                    $specialPrices[] = $item;
                }
            }

            $drug->fill($request->all());
            
            // saving to database
            $status = false;
            if($drug->save()) {
                $status = $drug->unitPirce()->saveMany($unitPrices);
                if(!empty($request->special)) {
                    $status = $drug->specialPrice()->saveMany($specialPrices);
                }
            }

            // response to client
            if(!$status) {
                $result = [
                    'status' => false,
                    'error' => (object)[
                        'msg' => __('index.common_save_error'),
                    ]
                ];
            } else {
                $result = [
                    'status' => true,
                    'id' => $drug->id,
                ];
            }

            echo json_encode($result);
            return;
        }

        // set variables and render view
        return $this->view('ajax.edit', compact('drug', 'units'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Drug id.
     */
    public function delete(Request $request)
    {
        // get id
        $id = $request->id;
        // get entity
        $drug = Drug::find($id);
        // delete entity
        $drug->delete();

        // print json format
        return response()->json([
            'status' =>  true
        ]);
    }
}
