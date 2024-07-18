<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;

use App\Models\Vouchers\GeneralLedger;
use App\Models\Accounts\Master_account;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use App\Models\Company;
use Illuminate\Support\Carbon;
use Exception;
use DB;

class IncomeStatementController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        return view('accounts.incomeStatement.index',compact('companies'));
    }

    public function details(Request $r){
        $month=$r->month;
        $year=$r->year;
        $company_id=$r->company_id;
        $acc_head=Master_account::where('company_id',$company_id)->get();
       
        $allaccheadsinc=array();
        $allaccheadsexp=array();
        $tax_data=array();

        foreach($acc_head as $ah){
            if($ah->head_code=="4000"){
                if($ah->sub_head){
                    foreach($ah->sub_head as $sub_head){/* operating income */
                        ${$sub_head->head_code."two"} = [];
                        ${$sub_head->head_code."one"} = [];
                        ${$sub_head->head_code."main"} = [];

                        $allaccheadsinc[$sub_head->head_code]=$sub_head;

                            if($sub_head->child_one->count() > 0){
                                foreach($sub_head->child_one as $child_one){
                                    if($child_one->child_two->count() > 0){
                                        foreach($child_one->child_two as $child_two){
                                            ${$sub_head->head_code."two"}[]=$child_two->id;
                                            $incomeheadoptwo[]=$child_two->id;
                                        }
                                    }else{
                                        ${$sub_head->head_code."one"}[]=$child_one->id;
                                        $incomeheadopone[]=$child_one->id;
                                    }
                                }
                            }else{
                                ${$sub_head->head_code."main"}[]=$sub_head->id;
                                $incomeheadop[]=$sub_head->id;
                            }
                      
                    }
                }
            }else if($ah->head_code=="5000"){
                if($ah->sub_head){
                    foreach($ah->sub_head as $sub_head){
                        ${$sub_head->head_code."two"} = [];
                        ${$sub_head->head_code."one"} = [];
                        ${$sub_head->head_code."main"} = [];

                        $allaccheadsexp[$sub_head->head_code]=$sub_head;

                        if($sub_head->child_one->count() > 0){
                            foreach($sub_head->child_one as $child_one){
                                if($child_one->child_two->count() > 0){
                                    foreach($child_one->child_two as $child_two){
                                        ${$sub_head->head_code."two"}[]=$child_two->id;
                                    }
                                }else{
                                    ${$sub_head->head_code."one"}[]=$child_one->id;
                                }
                            }
                        }else{
                            ${$sub_head->head_code."main"}[]=$sub_head->id;
                        }
                    }
                }
            }
        }

        // print_r($allaccheadsexp);die;

        if($month){
            $datas=$year."-".$month."-01";
            $datae=$year."-".$month."-31";
        }else{
            $datas=$year."-01-01";
            $datae=$year."-12-31";
        }
            //\DB::connection()->enableQueryLog();
            /* operating income */
            foreach($allaccheadsexp as $head=>$name){

                $main=${$head."main"};
                $one=${$head."one"};
                $two=${$head."two"};

                ${"exp".$head}=GeneralLedger::whereBetween('rec_date',[$datas,$datae])
                ->where(function($query) use ($main,$one,$two){
                    $query->orWhere(function($query) use ($main){
                        $query->whereIn('sub_head_id',$main);
                    });
                    $query->orWhere(function($query) use ($one){
                        $query->whereIn('child_one_id',$one);
                    });
                    $query->orWhere(function($query) use ($two){
                        $query->whereIn('child_two_id',$two);
                    });
                })
                ->get();
                //$queries = \DB::getQueryLog();
            }
            foreach($allaccheadsinc as $head=>$name){

                $main=${$head."main"};
                $one=${$head."one"};
                $two=${$head."two"};

                ${"inc".$head}=GeneralLedger::whereBetween('rec_date',[$datas,$datae])
                ->where(function($query) use ($main,$one,$two){
                    $query->orWhere(function($query) use ($main){
                        $query->whereIn('sub_head_id',$main);
                    });
                    $query->orWhere(function($query) use ($one){
                        $query->whereIn('child_one_id',$one);
                    });
                    $query->orWhere(function($query) use ($two){
                        $query->whereIn('child_two_id',$two);
                    });
                })
                ->get();
                //$queries = \DB::getQueryLog();
            }
           
            // $queries = \DB::getQueryLog();
            // dd($queries);
            /* nonoperating income */
           
            /* tax expense */
            $taxamount=GeneralLedger::whereBetween('rec_date',[$datas,$datae])
            ->where(function($query) use ($tax_data){
                $query->orWhere(function($query) use ($tax_data){
                     $query->whereIn('child_one_id',$tax_data);
                });
            })
            ->get();
            $company = DB::table('companies')->where('id',$company_id)->first();
        $data='<div class="col-lg-12 stretch-card">
                
                <div class="card mt-3">
                    <h4 class="text-center card-title m-0">Company Name :- '.$company->company_name.'</h4>
                    <p class="text-center m-0">Address :- '.$company->address.'</p>
                    <h5 class="text-center card-title m-0">Income Statement</h5>
                    <p class="text-center m-0">For the Month of '. \Carbon\Carbon::create()->month($month)->format('F').' '.$year.'</p>
                    <table class="table table-bordered">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th> Particulars </th>
                        <th> Taka </th>
                        <th> Taka </th>
                        </tr>
                    </thead>
                    <tbody>';
                    $i=1;
                    $opinc=0;
                    $totalinc=0;
                    $opexp=0;
                    $totalexp=0;
                    $tax=0;
                    if($allaccheadsinc){
                        foreach($allaccheadsinc as $head=>$name){
                            $opinc=0;
                            $data.='<tr>
                            <th> </th>
                            <th class="" colspan="1">'.$name->head_name.'</th>
                            <td></td>
                            <td></td>
                            </tr>';
                            /* income */
                            if(${"inc".$head}){
                                foreach(${"inc".$head} as $opi){
                                    $opinc+=$opi->cr;
                                    $data.='<tr class="table-info">';
                                    $data.='<td>'.$i++.'</td>';
                                    $data.='<td><b class="ms-3">'.$opi->journal_title.'</b> </td>';
                                    $data.='<td>-</td>';
                                    $data.='<td class="text-right"> '.$opi->cr.' </td>';
                                    $data.='</tr>';
                                }
                            }
                            $data.='<tr>
                            <th> </th>
                            <th style="text-align:right"> Total '.$name->head_name.' </th>
                            <th>-</th>
                            <th> '.$opinc.' </th>
                            </tr>';
                            $totalinc+=$opinc;
                        }
                    }
                    if($allaccheadsexp){
                        foreach($allaccheadsexp as $head=>$name){
                            $opexp=0;
                            $data.='<tr>
                            <th> </th>
                            <th class="" colspan="1">'.$name->head_name.'</th>
                            <td></td>
                            <td></td>
                            </tr>';
                            /* income */
                            if(${"exp".$head}){
                                foreach(${"exp".$head} as $opi){
                                    $opexp+=$opi->dr;
                                    $data.='<tr class="table-info">';
                                    $data.='<td>'.$i++.'</td>';
                                    $data.='<td><b class="ms-3">'.$opi->journal_title.'</b> </td>';
                                    $data.='<td>-</td>';
                                    $data.='<td class="text-right"> '.$opi->dr.' </td>';
                                    $data.='</tr>';
                                }
                            }
                            $data.='<tr>
                            <th> </th>
                            <th style="text-align:right"> Net '.$name->head_name.' </th>
                            <th>-</th>
                            <th> '.$opexp.' </th>
                            </tr>';
                            $totalexp+=$opexp;
                        }
                    }
                   

                    
                   
                    if($taxamount){
                        foreach($taxamount as $t){
                            $tax+=$t->dr;
                            $data.='<tr class="table-info">';
                            $data.='<td>'.$i++.'</td>';
                            $data.='<td> '.$t->journal_title.' </td>';
                            $data.='<td class="text-right"> '.$t->dr.' </td>';
                            $data.='</tr>';
                            
                        }
                    }
                    $data.='<tr>
                            <th> </th>
                            <th class="text-right"> Net Income</th>
                            <th class="text-right"> '.($totalinc  - ($totalexp + $tax)).' </th>
                            </tr>';

            $data.='</tbody>
                </table>
            </div>
            
        </div>';
        echo  json_encode($data);
        //print_r($r->year);
    }

}
