<?php

namespace App\Http\Controllers;

use App\Models\VesselCategory;
use Illuminate\Http\Request;
use Toastr;
class VesselCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vessel_cats = VesselCategory::latest()->paginate(15);
        return view('vessel_cat.index', compact('vessel_cats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vessel_cat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $d = New VesselCategory();
            $d->category_name = $request->category_name;
            $d->created_by=currentUserId();
            if($d->save()){
                \LogActivity::addToLog('Add Vessel Category',$request->getContent(),'Vessel Category');
                return redirect()->route('vessel-categories.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\ShipCategory  $shipCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ShipCategory $shipCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShipCategory  $shipCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $v=VesselCategory::findOrFail(encryptor('decrypt',$id));
        return view('vessel_cat.edit',compact('v'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShipCategory  $shipCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try {
            $d = VesselCategory::findOrFail(encryptor('decrypt',$id));
            $d->category_name = $request->category_name;
            $d->updated_by=currentUserId();
            if($d->save()){
                \LogActivity::addToLog('Update Vessel Category',$request->getContent(),'Vessel Category');
                return redirect()->route('vessel-categories.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\ShipCategory  $shipCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShipCategory $shipCategory)
    {
        //
    }
}
