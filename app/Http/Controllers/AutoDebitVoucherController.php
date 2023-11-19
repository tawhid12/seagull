<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts\Child_one;
use App\Models\Accounts\Child_two;
use App\Models\Requisiton;
use DB;
use Session;
use Exception;
class AutoDebitVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $r = Requisiton::findOrFail(encryptor('decrypt',$request->id));
        /*echo '<pre>';
        print_r($requisition);
        echo '</pre>';
        die;*/
        $paymethod = array();
        $account_data = Child_one::whereIn('head_code', [1110, 1120])/*->where(company())*/->get();

        if ($account_data) {
            foreach ($account_data as $ad) {
                $shead = Child_two::where('child_one_id', $ad->id);
                if ($shead->count() > 0) {
                    $shead = $shead->get();
                    foreach ($shead as $sh) {
                        $paymethod[] = array(
                            'id' => $sh->id,
                            'head_code' => $sh->head_code,
                            'head_name' => $sh->head_name,
                            'table_name' => 'child_twos'
                        );
                    }
                } else {
                    $paymethod[] = array(
                        'id' => $ad->id,
                        'head_code' => $ad->head_code,
                        'head_name' => $ad->head_name,
                        'table_name' => 'child_ones'
                    );
                }
            }
        }

        return view('voucher.debitVoucher.auto.create', compact('paymethod','r'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
