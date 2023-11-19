<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


use App\Models\User;

use DateTime;
use DateInterval;
use App\Http\Traits\ResponseTrait;
use App\Models\Attendance;

use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    use ResponseTrait;

    public function batchwiseAttendanceReport(Request $request)
    {
        $batch_data = Batch::find($request->batch_id);
        $image_path = asset('backend/images/logo.webp');
        //$data = '<div class="col-md-12 text-center">';
        //$data .= '<div class="row">';
        $data = '<div style="width:10%;display:inline-block;"><img src=' . $image_path . ' alt="" height="40"></div>';
        $data .=     '<div style="width:90%;display:inline-block;text-align:center;"><h4 class="m-0 p-0 text-center" style="font-size:11px;font-weight:700;">NEW VISION INFORMATION TECHNOLOGY LTD.</h4>';
        $data .= '<p class="m-0 p-0 text-center" style="font-size:9px"><strong class="text-center">Course : ' . \DB::table('courses')->where('id', $batch_data->courseId)->first()->courseName . '</strong></p>';
        $data .=     '<p class="m-0 p-0 text-center" style="font-size:9px"><strong>Trainer Attendance Roster</strong></p></div>';



        $data .=     '<p class="m-0 p-0" style="font-size:10px;display:flex;justify-content:space-between">
                        <strong>Started On :'  . \Carbon\Carbon::createFromTimestamp(strtotime($batch_data->startDate))->format('j M, Y') . '</strong>
                        <strong>' . \DB::table('batchtimes')->where('id', $batch_data->btime)->first()->time . '</strong>
                        <strong>' . \DB::table('batchslots')->where('id', $batch_data->bslot)->first()->slotName . '</strong>
                        <strong>Batch : ' . $batch_data->batchId . '</strong>
                        <strong>Trainer : ' . \DB::table('users')->where('id', $batch_data->trainerId)->first()->name . '</strong>  
                        </p>';


        $startDate = new DateTime($batch_data->startDate);
        $endDate = new DateTime($batch_data->endDate);

        // Create a DateInterval of 1 day
        $interval = new DateInterval('P1D');

        $data .= '<table class="table table-sm" style="border:1px solid #000;color:#000;">
                    <tbody>';
        $data .=    '</tr>
                    <tr height="20px">
                        <th colspan="3" style="border:1px solid #000;;color:#000;font-size:9px;text-align:right"><strong>Trainer Sign:</strong></th>';
        for ($i = 0; $i < 17; $i++) {
            $data .= '<td class="cell" style="border:1px solid #000;color:#000;font-size:9px"></td>';
        }
        $data .=    '</tr>';
        $data .=    '</tr>
                    <tr height="20px">
                        <th colspan="3" style="border:1px solid #000;;color:#000;font-size:9px;text-align:right"><strong>Class Date:</strong></th>';
        for ($i = 0; $i < 17; $i++) {
            $data .= '<td class="cell" style="border:1px solid #000;color:#000;font-size:9px"></td>';
        }
        $data .=    '</tr>';

        $data .=    '   <tr>
                            <th width="135px" class="align-middle" style="border:1px solid #000;;color:#000;font-size:9px;"><strong>Student Name</strong></th>
                            <th width="40px" class="align-middle" style="border:1px solid #000;;color:#000;font-size:9px"><strong>INV</strong></th>
                            <th width="40px" class="align-middle" style="border:1px solid #000;color:#000;font-size:9px"><strong>AE:</strong></th>
                            ';
        // Loop through the date range
        //$count = $request->count_class;
        $count = 0;
        $date = $startDate;
        while ($date <= $endDate) {

            // Check if the current date is a Saturday, Monday or Wednesday
            if ($date->format('l') == 'Saturday' || $date->format('l') == 'Monday' || $date->format('l') == 'Wednesday') {
                // Display the date in a column
                if ($count < 17) {
                    /*Carbon\Carbon::createFromTimestamp(strtotime($date->format('Y-m-d')))->format('j/m/y')*/
                    //$data .= '<td style="border:1px solid #000;;color:#000;"></td>';
                }
                $count++;
            }
            $date->add($interval);
        }
        if ($count > 17) $count = 17;

        if ($request->batch_id) {
            $batch_students = DB::table('student_batches')->where('batch_id', $request->batch_id)->where('status', 2)->get();
        }
        foreach ($batch_students as $batch_student) {
            $s_data = \DB::table('students')->where('id', $batch_student->student_id)->first();
            $words = explode(" ", $s_data->name);
            $firstThreeWords = array_slice($words, 0, 3);
            $name = implode(" ", $firstThreeWords);

            $data .= '<tr height="20px">';
            $data .= '<td style="border:1px solid #000;color:#000;font-size:8px">' . strtoupper($name) . '</td>';
            $data .= '<td style="border:1px solid #000;color:#000;font-size:8px">';
            if (\DB::table('payments')
                ->join('paymentdetails', 'paymentdetails.paymentId', 'payments.id')
                ->where(['paymentdetails.batchId' => $request->batch_id, 'paymentdetails.studentId' => $batch_student->student_id])->whereNotNull('payments.invoiceId')->exists()
            ) {
                $data .= \DB::table('payments')->join('paymentdetails', 'paymentdetails.paymentId', 'payments.id')->where(['paymentdetails.batchId' => $request->batch_id, 'paymentdetails.studentId' => $batch_student->student_id])->whereNotNull('payments.invoiceId')->first()->invoiceId;
            } else {
                $data .= '-';
            }
            '</td>';
            $data .= '<td style="border:1px solid #000;color:#000;font-size:8px">' . \DB::table('users')->where('id', $s_data->executiveId)->first()->username . '</td>';
            for ($i = 0; $i < $count; $i++) {
                $data .= '<td style="border:1px solid #000;color:#000;font-size:8px"></td>';
            }
            $data .= '</tr>';
        }
        $data .=    '</tbody>
                </table>';





        return response()->json(array('data' => $data));
    }

    public function datewiseAttendance(Request $request)
    {

        $data =  '<div style="width:90%;display:inline-block;text-align:center;"><h4 class="m-0 p-0 text-center" style="font-size:18px;font-weight:700;color:#25396f;">Seagull Marine Engineer\'s PVT Ltd.</h4>';
        $data .= '<p class="m-0 p-0 text-center" style="font-size:16px;"><strong style="color:#25396f">Employee Daily Attendance</strong></p></div>';



        $data .= '<form action="' . route('attendance.store') . '" method="post"> ' . csrf_field() . '';

        $data .=    '<div class="row">
                        <div class="col-md-12 d-flex justify-content-end">
                            <div class="col-md-3">
                                <div class="input-group my-2">
                                    <input type="text" name="postingDate" class="form-control" placeholder="dd/mm/yyyy">
                                </div>
                            </div>
                        </div>
                    </div>';
        $data .= '<table class="table table-sm table-hover table-striped" style="width:100%;border:1px solid #000;color:#000;">
                    <tbody>
                        <tr>
                            <th class="align-middle" style="border:1px solid #000;;color:#000;"><strong>SL.</strong></th>
                            <th class="align-middle" style="border:1px solid #000;;color:#000;"><strong>Employee ID</strong></th>
                            <th class="align-middle" style="border:1px solid #000;;color:#000;"><strong>Name</strong></th>
                            <th class="align-middle" style="border:1px solid #000;;color:#000;"><strong>Designation</strong></th>
                            <th style="border:1px solid #000;;color:#000;"><strong>Is Present.</strong></th>
                        </tr>';


        $employees = DB::table('employees')->whereNull('resign_date')->get();

        foreach ($employees as $key => $e) {
            $data .= '<tr>';
            $data .= '<td style="border:1px solid #000;color:#000;">' . ++$key . '</td>';
            $data .= '<td style="border:1px solid #000;color:#000;">' . $e->employee_id . '</td>';
            $data .= '<td style="border:1px solid #000;color:#000;">' . strtoupper($e->employee_name) . '</td>';
            $data .= '<td style="border:1px solid #000;color:#000;">' . $e->designation_id . '</td>';
            $data .= '<input type="hidden" name="employee_id[]" value="' . $e->id . '">';

            $data .= '<td style="border:1px solid #000;color:#000;"><input size="1" type="checkbox" name="isPresent[' . $e->id . ']" value="1"></td>';
            $data .= '</tr>';
        }




        $data .=    '</tbody>
                </table>';

        $data .= '<script>$("input[name=\'postingDate\']").daterangepicker({
                    singleDatePicker: true,
                    startDate: "'.$request->postingDate.'",
                    showDropdowns: true,
                    autoUpdateInput: true,
                    format: \'dd/mm/yyyy\',
                });</script>';

        $data .= '<div class="col-md-12 d-flex justify-content-end"><button class="btn btn-primary" type="submit">Submit</button></div>';
        $data .= '</form>';





        return response()->json(array('data' => $data));
    }
    public function batchwiseStudentAttnReport(Request $request)
    {
        $batch_data = Batch::find($request->batch_id);
        $image_path = asset('backend/images/logo.webp');
        $data = '<div style="width:10%;display:inline-block;"><img src=' . $image_path . ' alt="" height="40"></div>';
        $data .=     '<div style="width:90%;display:inline-block;text-align:center;"><h4 class="m-0 p-0 text-center" style="font-size:11px;font-weight:700;">NEW VISION INFORMATION TECHNOLOGY LTD.</h4>';
        $data .= '<p class="m-0 p-0 text-center" style="font-size:9px"><strong class="text-center">Course : ' . \DB::table('courses')->where('id', $batch_data->courseId)->first()->courseName . '</strong></p>';
        $data .=     '<p class="m-0 p-0 text-center" style="font-size:9px"><strong>Student Daily Attendance Report</strong></p></div>';



        $data .=     '<p class="m-0 p-0" style="font-size:10px;display:flex;justify-content:space-between">
                        <strong>Started On :'  . \Carbon\Carbon::createFromTimestamp(strtotime($batch_data->startDate))->format('j M, Y') . '</strong>
                        <strong>' . \DB::table('batchtimes')->where('id', $batch_data->btime)->first()->time . '</strong>
                        <strong>' . \DB::table('batchslots')->where('id', $batch_data->bslot)->first()->slotName . '</strong>
                        <strong>Batch : ' . $batch_data->batchId . '</strong>
                        <strong>Trainer : ' . \DB::table('users')->where('id', $batch_data->trainerId)->first()->name . '</strong>  
                        </p>';


        $startDate = new DateTime($batch_data->startDate);
        $endDate = new DateTime($batch_data->endDate);

        // Create a DateInterval of 1 day
        $interval = new DateInterval('P1D');

        if ($request->batch_id) {
            $postingDate = DB::table('attendances')->select('postingDate', 'edit_allow')->where('batch_id', $request->batch_id)->groupBy('postingDate')->get();
        }
        $data .= '<div class="table-responsive"><table class="table table-sm" style="width:100%;border:1px solid #000;color:#000;">
                    <tbody>
                        <tr class="text-center">
                            <th class="align-middle" rowspan="2" style="border:1px solid #000;;color:#000;width:5px;"><strong>ID</strong></th>
                            <th class="align-middle" rowspan="2" style="border:1px solid #000;;color:#000;width:180px;"><strong>Name</strong></th>
                            <th class="align-middle" rowspan="2" style="border:1px solid #000;;color:#000;width:5px;"><strong>Invoice</strong></th>
                            <th class="align-middle" rowspan="2" style="border:1px solid #000;color:#000;width:5px;"><strong>Executive</strong></th>
                            <th style="border:1px solid #000;;color:#000;" colspan="' . $postingDate->count() . '"><strong>Attendance Details</strong></th>
                            <th style="border:1px solid #000;;color:#000;width:5px;"><strong>Tclass:- ' . $postingDate->count() . '</strong></th>
                        </tr>';
        $data .= '<tr>';
        foreach ($postingDate as $pdate) {

            $data .= '<th style="border:1px solid #000;;color:#000;text-align:center">'
                . \Carbon\Carbon::createFromTimestamp(strtotime($pdate->postingDate))->format('d/m/y');
            if (currentUser() == 'operationmanager' && $pdate->edit_allow == 0) {
                $data .= '<form action="' . route(currentUser() . '.attendance.update', $request->batch_id) . '" method="post"> ' . csrf_field() . ' ' . method_field('PUT') . '';
                $data .= '<input type="hidden" name="postingDate" value="' . $pdate->postingDate . '">';
                $data .= '<input type="hidden" name="type" value="1">';
                $data .= '<button type="submit" class="btn btn-sm btn-warning">Edit Allow</button>';
                $data .= '</form>';
            }
            if (currentUser() == 'trainer' && $pdate->edit_allow == 1) {
                // $data .= '<a class="d-block btn btn-sm btn-info" title="Edit Attendance" href="'.route(currentUser() . '.attendance.edit',$request->batch_id).'">Edit</a>';
                $data .= '<form action="' . route(currentUser() . '.attendance.edit', $request->batch_id) . '"> ' . csrf_field() . '';
                $data .= '<input type="hidden" name="postingDate" value="' . $pdate->postingDate . '">';
                $data .= '<button type="submit" class="btn btn-sm btn-warning">Edit</button>';
                $data .= '</form>';
                $data .= '<form action="' . route(currentUser() . '.attendance.destroy', $request->batch_id) . '" method="post"> ' . csrf_field() . ' ' . method_field('DELETE') . '';
                $data .= '<input type="hidden" name="postingDate" value="' . $pdate->postingDate . '">';
                $data .= '<button type="submit" class="btn btn-sm btn-danger">Delete</button>';
                $data .= '</form>';
            }
            $data .= '<p class="m-0 p-0">' . \Carbon\Carbon::createFromTimestamp(strtotime($pdate->postingDate))->format('D') . '</p>
            </th>';
        }
        $data .= '<th class="text-center">T.Pre</th></tr>';



        if ($request->batch_id) {
            $batch_students = DB::table('student_batches')->where('batch_id', $request->batch_id)->where('status', 2)->where('is_drop', 0)->get();
        }
        foreach ($batch_students as $batch_student) {
            $data .= '<tr>';
            $s_data = \DB::table('students')->where('id', $batch_student->student_id)->first();

            $data .= '<td style="border:1px solid #000;color:#000;">' . $s_data->id . '</td>';
            $data .= '<input type="hidden" name="student_id[]" value="' . $s_data->id . '">';
            $data .= '<input type="hidden" name="batch_id[]" value="' . $batch_data->id . '">';
            $data .= '<td style="border:1px solid #000;color:#000;">' . strtoupper($s_data->name) . '</td>';
            $data .= '<td style="border:1px solid #000;color:#000;">';
            if (\DB::table('payments')
                ->join('paymentdetails', 'paymentdetails.paymentId', 'payments.id')
                ->where(['paymentdetails.batchId' => $request->batch_id, 'paymentdetails.studentId' => $batch_student->student_id])->whereNotNull('payments.invoiceId')->exists()
            ) {
                $data .= \DB::table('payments')->join('paymentdetails', 'paymentdetails.paymentId', 'payments.id')->where(['paymentdetails.batchId' => $request->batch_id, 'paymentdetails.studentId' => $batch_student->student_id])->whereNotNull('payments.invoiceId')->first()->invoiceId;
            } else {
                $data .= '-';
            }
            '</td>';
            $data .= '<td style="border:1px solid #000;color:#000;">' . \DB::table('users')->where('id', $s_data->executiveId)->first()->username . '</td>';

            foreach ($postingDate as $pdate) {
                $attendance_data = Attendance::where('student_id', $batch_student->student_id)->where('batch_id', $batch_data->id)->where('postingDate', '=', \Carbon\Carbon::createFromTimestamp(strtotime($pdate->postingDate))->format('Y-m-d'))->first();
                //if ($attendance_data !== null && $attendance_data->isPresent == 1) 
                if ($attendance_data->isPresent == 1)
                    $data .= '<th style="border:1px solid #000;color:#fff;background-color:green;text-align:center;"><strong>P</strong></th>';
                else
                    $data .= '<th style="border:1px solid #000;color:#fff;background-color:red;text-align:center;"><strong>A</strong></th>';
            }
            $data .= '<th style="border:1px solid #000;color:#000;text-align:center;">' . Attendance::where('student_id', $batch_student->student_id)->where('batch_id', $batch_data->id)->where('isPresent', '=', 1)->count() . '</th>';
            $data .= '</tr>';
        }




        $data .=    '</tbody>
                </table></div>';




        return response()->json(array('data' => $data));
    }
}
