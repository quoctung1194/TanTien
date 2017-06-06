<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DrugOrder;
use App\Drug;
use App\UnitPrice;
use App\SpecialPrice;
use App\OrderDetail;

class DrugOrderController extends Controller
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
        $code = $request->code;
        $date = $request->date;
        // sum of order
        $sum = 0;
        $displaySum = false;

        // convert date to sql data
        if(!empty($date)) {
            $date = \DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');
            $sum = $this->getSumByDate($date);
            $displaySum = true;
        }

        // query builder
        $query = DrugOrder::query();

        // where conditions
        $find_condition = [
            ['code', 'like', '%' . $code . '%']
        ];
        $query = $query
            ->with('orderDetails')
            ->where($find_condition);
        // search date
        if(!empty($date)) {
            $query = $query->whereDate('created_at', '=', $date);            
        }

        // get sorting columns array
        $sortArr = $this->getSortColumns();
        foreach ($sortArr as $col => $direct) {
            $query = $query->orderBy($col, $direct);
        }

        // result list
        $drugOrder = $query->paginate($limit);

        return $this->view('ajax.list', compact('drugOrder', 'sum', 'displaySum'));
    }

    /**
     * Add method
     *
     * @return void
     */
    public function add(Request $request)
    {
        // init new entity
        $drugOrder = new DrugOrder();

        if ($request->isMethod('post')) {

            // get form values
            $code = $request->code;
            $drugDetails = $request->drugDetail;

            // checking validate
            if (DrugOrder::where('code', $code)->count() > 0) {
                $result = [
                    'status' => false,
                    'error' => (object)[
                        'msg' => __('index.drugOrder duplicate'),
                    ]
                ];

                echo json_encode($result);
                return;
            } else if (!isset($drugDetails)) {
                $result = [
                    'status' => false,
                    'error' => (object)[
                        'msg' => __('index.drugOrder emptyDrugList'),
                    ]
                ];

                echo json_encode($result);
                return;
            }

            // making new order
            $drugOrder = new DrugOrder();
            $drugOrder->code = $code;

            // assign drug info into array
            $orderDetails = [];
            foreach ($drugDetails as $drug) {
               $item = new OrderDetail();
               $item->fill($drug);

               // get total sum
               $item->sum = $this->calculateSum($drug['drug_id'], $drug['unit_id'], $drug['quantity']);
               $orderDetails[] = $item;
            }

            // saving to database
            $status = false;
            if($drugOrder->save()) {
                $status = $drugOrder->orderDetails()->saveMany($orderDetails);
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
                    'id' => $drugOrder->id,
                ];
            }

            echo json_encode($result);
            return;
        }

        // set variables and render view
        return $this->view('ajax.add', compact('drugOrder'));
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
        $drugOrder = DrugOrder::with('orderDetails.drug', 'orderDetails.unit')->find($id);

        if ($request->isMethod('post')) {

            // get form values
            $code = $request->code;
            $drugDetails = $request->drugDetail;

            // checking validate
            if (DrugOrder::where('code', $code)
                    ->where('id', '!=', $id)
                    ->count() > 0) { // checking duplicate code
                $result = [
                    'status' => false,
                    'error' => (object)[
                        'msg' => __('index.drugOrder duplicate'),
                    ]
                ];

                echo json_encode($result);
                return;
            } else if (!isset($drugDetails)) { // checking list drug empty
                $result = [
                    'status' => false,
                    'error' => (object)[
                        'msg' => __('index.drugOrder emptyDrugList'),
                    ]
                ];

                echo json_encode($result);
                return;
            }

            // update order
            $drugOrder->code = $code;
            // delete all orderDetails element
            $oldDrugdetails = $drugOrder->orderDetails()->delete();

            // assign drug info into array
            $orderDetails = [];
            foreach ($drugDetails as $drug) {
               $item = new OrderDetail();
               $item->fill($drug);

               // get total sum
               $item->sum = $this->calculateSum($drug['drug_id'], $drug['unit_id'], $drug['quantity']);
               $orderDetails[] = $item;
            }

            // saving to database
            $status = false;
            if($drugOrder->save()) {
                $status = $drugOrder->orderDetails()->saveMany($orderDetails);
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
                    'id' => $drugOrder->id,
                ];
            }

            echo json_encode($result);
            return;
        }

        // set variables and render view
        return $this->view('ajax.edit', compact('drugOrder'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Bank id.
     */
    public function delete(Request $request)
    {
        // get id
        $id = $request->id;
        // get entity
        $drugOrder = DrugOrder::find($id);
        // delete entity
        $drugOrder->delete();

        // print json format
        return response()->json([
            'status' =>  true
        ]);
    }

    /**
     * Get Drug information
     *
     * @return void
     */
    public function getDrugList(Request $request)
    {
        // get params
        $name = $request->name;
        // query builder
        $query = Drug::query();
        // limit items per page
        $limit = \Config::get('tantien.limit');
        
        // where conditions
        $find_condition = [
            ['name', 'like', '%' . $name . '%']
        ];

        $query = $query->where($find_condition)
            ->limit($limit);

        // result list
        $drugList = $query->get();

        // print json format
        return response()->json([
            'items' =>  $drugList
        ]);
    }

    /**
     * Get Unit List
     *
     * @return void
     */
    public function getUnitList(Request $request)
    {
        // get params
        $drugId = $request->drugId;

        // query builder
        $query = UnitPrice::query();
        // where conditions
        $find_condition = [
            ['drug_id', '=', $drugId]
        ];

        $query = $query->where($find_condition);

        // result list
        $unitList = $query->get()->load('unit');

        // print json format
        return response()->json([
            'items' =>  $unitList
        ]);
    }

    /**
     * Get Sum
     *
     * @return void
     */
    public function getSum(Request $request)
    {
        // get params
        $drugId = $request->drugId;
        $unitId = $request->unitId;
        $quantity = $request->quantity;

        $sum = ceil($this->calculateSum($drugId, $unitId, $quantity));

        // print json format
        return response()->json([
            'sum' =>  number_format($sum, 0, '.', ' '),
        ]);
    }

    /**
     * Calculate sum
     *
     * @return void
     */
    private function calculateSum($drugId, $unitId, $quantity)
    {
         // query builder
        $query = SpecialPrice::query();
        // where conditions
        $find_condition = [
            ['drug_id', '=', $drugId],
            ['unit_id', '=', $unitId],
            ['quantity', '=', $quantity]
        ];
        $query = $query->where($find_condition);

        // calculate
        if($query->count() > 0) { // follow special prices
            $sum = $query->first()->price;
        } else { // normal calculation
            // query builder
            $query = UnitPrice::query();
            // where conditions
            $find_condition = [
                ['drug_id', '=', $drugId],
            ];
            $query = $query
                ->where($find_condition)
                ->orderBy('id', 'desc');

            // get unit price list
            $unitPriceList = $query->get();

            // get real price per unit
            $maxUnitPrice = Drug::find($drugId)->price;
            $limitId = -1;
            $totalQuantity = 1;
            foreach ($unitPriceList as $item) {
                if( $item->ref_unit_id == $unitId) {
                    $limitId = $item->id;
                }

                if($limitId != -1 and $limitId >= $item->id) {
                    $totalQuantity *= $item->quantity;
                }
            }

            $sum = $maxUnitPrice/$totalQuantity * $quantity;
        }

        return $sum;
    }

    /**
     * Get sum by date
     */
    private function getSumByDate($date)
    {
        // query builder
        $query = DrugOrder::query();

        $query = $query->whereDate('created_at', '=', $date);
        
        $orders = $query->get();
        $sum = 0;
        foreach ($orders as $order) {
            $sum += $order->getTotal();
        }

        return $sum;
    }
}
