<?php

namespace App\Http\Controllers;

use App\Models\Vessel;
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
        $vessel = Vessel::latest()->paginate(15);
        return view('vessel.index', compact('vessel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vessel.create');
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
            $v = New Vessel();
            $v->vessel_name = $request->vessel_name;
            $v->vessel_number = $request->vessel_number;
            $companyData = company();
            $v->company_id=$companyData['company_id'];
            $v->created_by=currentUserId();
            if($v->save()){
                \LogActivity::addToLog('Add Vessel',$request->getContent(),'Vessel');
                return redirect()->route('vessel.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
    public function edit(Vessel $vessel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vessel  $vessel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vessel $vessel)
    {
        //
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
}
