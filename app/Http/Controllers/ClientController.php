<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\Client\AddNewRequest;
use App\Http\Requests\Client\UpdateRequest;
use App\Models\Vessel;
use Toastr;
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
    public function store(AddNewRequest $request)
    {
        try {
            $c = New Client();
            $c->client_name = $request->client_name;
            //$c->vessel_id = $request->vessel_id;
            $c->email = $request->email;
            $c->contact_no = $request->contact_no;
            $c->company_id=/*$request->company_id*/company()['company_id'];
            $c->created_by=currentUserId();
            if($c->save()){
                \LogActivity::addToLog('Add Client',$request->getContent(),'Client');
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
