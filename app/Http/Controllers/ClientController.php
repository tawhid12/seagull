<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\Client\AddNewRequest;
use App\Http\Requests\Client\UpdateRequest;
use App\Models\Accounts\Child_one;
use App\Models\Accounts\Child_two;
use App\Models\Vessel;
use Toastr;
use DB;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::latest()->paginate(15);
        return view('client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyData = company();
        $user = User::find(currentUserId()); // $userId is the ID of the user you're interested in
        $assigned_companies = $user->company;
        $vessels = Vessel::where('company_id',$companyData['company_id'])->get();
        return view('client.create',compact('assigned_companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*echo '<pre>';
        print_r($request->toArray());die;*/
        try {
            DB::beginTransaction();
            $c = New Client();
            $c->client_name = $request->client_name;
            $c->client_short_name = $request->client_short_name;
            $c->phone = $request->phone;
            $c->mobile = $request->mobile;
            $c->email = $request->email;
            //$c->vessel_id = $request->vessel_id;
            $c->fax = $request->fax;
            $c->web = $request->web;
            $c->address = $request->address;
            $c->address = $request->address;
            $c->tin = $request->tin;
            $c->tin_name = $request->tin_name;
            $c->bin = $request->bin;
            $c->bin_name = $request->bin_name;
            $c->contact_person_name = $request->contact_person_name;
            $c->contact_person_phone = $request->contact_person_phone;
            $c->contact_person_email = $request->contact_person_email;
            $c->company_id=/*$request->company_id*/company()['company_id'];
            $c->created_by=currentUserId();
            if($c->save()){
                $id_child_one = Child_one::where('head_code','1130')/*->where(company())*/->first();
                $ach = new Child_two;
                $ach->child_one_id= $id_child_one->id;
                $ach->company_id=company()['company_id'];
                $ach->head_name=$request->client_name;
                $ach->head_code = '1130'.$c->id;
                $ach->opening_balance =$request->openingAmount ?? 0;
                $ach->created_by=currentUserId();
                if($ach->save()) {
                    $c->account_id = $ach->id;
                    $c->save();
                    DB::commit();
                    \LogActivity::addToLog('Add Client', $request->getContent(), 'Client');
                    return redirect()->route('client.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
                }else
                    return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }else{
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            DB::rollback();
            //dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $c = Client::findOrFail(encryptor('decrypt', $id));
        $user = User::find(currentUserId()); // $userId is the ID of the user you're interested in
        $assigned_companies = $user->company;
        return view('client.edit', compact('c', 'assigned_companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $c = Client::findOrFail(encryptor('decrypt', $id));
            $c->client_name = $request->client_name;
            //$c->vessel_id = $request->vessel_id;
            $c->email = $request->email;
            $c->contact_no = $request->contact_no;
            $c->company_id=/*$request->company_id/*/company()['company_id'];
            $c->created_by=currentUserId();
            if($c->save()){
                \LogActivity::addToLog('Update Client',$request->getContent(),'Client');
                return redirect()->route('client.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            }else{
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            //dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }

    public function client_by_company(Request $request, $id){
        $clients = Client::where('company_id',$id)->get();


        $data = '<div class="col-md-3 col-12" id="client_id">';
        $data .= '<div class="form-group">';
        $data .= '<label for="client_id">Select Client</label>';
        $data .= '<select name="client_id" class="form-control js-example-basic-single" required>';
        $data .= '<option value="">Select</option>';

        foreach ($clients as $c) {
            if($c->id == $request->client_id)
            $data .= '<option value="' . $c->id . '" selected>' . $c->client_name . '</option>';
            else
            $data .= '<option value="' . $c->id . '" >' . $c->client_name . '</option>';

        }

        $data .= '</select>';
        $data .= '</div>';

        return response()->json(['data' => $data]);
    }
}
