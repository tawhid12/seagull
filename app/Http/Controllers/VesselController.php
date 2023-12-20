<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vessel;
use App\Models\Client;
use App\Models\VesselCategory;
use Illuminate\Http\Request;
use App\Http\Requests\Vessel\AddNewRequest;
use App\Http\Requests\Vessel\UpdateRequest;
use Toastr;

class VesselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vessel = Vessel::with(['company','client'])->latest()->paginate(15);
        return view('vessel.index', compact('vessel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(currentUserId()); // $userId is the ID of the user you're interested in
        $assigned_companies = $user->company;
        $clients = Client::where('company_id',company())->get();
        $vessel_cats = VesselCategory::all();
        return view('vessel.create', compact('assigned_companies','clients','vessel_cats'));
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
            $v = new Vessel();
            $v->vessel_name = $request->vessel_name;
            $v->vessel_number = $request->vessel_number;
            $v->vessel_cat_id = $request->vessel_cat_id;
            $v->company_id = /*$request->company_id;*/company()['company_id'];
            $v->client_id = $request->client_id;
            $v->created_by = currentUserId();
            if ($v->save()) {
                \LogActivity::addToLog('Add Vessel', $request->getContent(), 'Vessel');
                return redirect()->route('vessel.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
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
     * @param  \App\Models\Vessel  $vessel
     * @return \Illuminate\Http\Response
     */
    public function show(Vessel $vessel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vessel  $vessel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $v = Vessel::findOrFail(encryptor('decrypt', $id));
        $clients = Client::where('company_id',company())->get();
        $vessel_cats = VesselCategory::all();
        return view('vessel.edit', compact('v','clients','vessel_cats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vessel  $vessel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $v = Vessel::findOrFail(encryptor('decrypt', $id));
            $v->vessel_name = $request->vessel_name;
            $v->vessel_number = $request->vessel_number;
            $v->vessel_cat_id = $request->vessel_cat_id;
            $v->company_id = /*$request->company_id;*/company()['company_id'];
            $v->client_id = $request->client_id;
            $v->created_by = currentUserId();
            if ($v->save()) {
                \LogActivity::addToLog('Add Vessel', $request->getContent(), 'Vessel');
                return redirect()->route('vessel.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
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
     * @param  \App\Models\Vessel  $vessel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vessel $vessel)
    {
        //
    }
    public function vessel_by_company($id)
    {
        $vessels = Vessel::where('company_id', $id)->get();
        $data = '<div class="row">';

        $data .= '<div class="col-md-3 col-12">';
        $data .= '<div class="form-group">';
        $data .= '<label for="vessel_id">Select Vessel</label>';
        $data .= '<select name="vessel_id" class="form-control js-example-basic-single" required>';
        $data .= '<option value="">Select</option>';

        foreach ($vessels as $v) {
            $data .= '<option value="' . $v->id . '">' . $v->name . '</option>';
        }

        $data .= '</select>';
        $data .= '</div>';
        $data .= '</div>';
        return response()->json(['data' => $data]);
    }
}
