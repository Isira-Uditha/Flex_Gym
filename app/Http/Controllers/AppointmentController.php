<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\WorkoutPlan;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\AssignOp\Concat;

class AppointmentController extends Controller
{

    public function index(Request $request)
    {
        $app_service = new AppointmentService();

        if ($request->ajax()) {
            $appointments= $app_service->getAppointments($request->all());
            return datatables()->of($appointments)
            ->addColumn('appointment_id', function ($row) {
                return $row->appointment_id;
            })
            ->addColumn('appointment_date', function ($row) {
                return $row->appointment_date;
            })
            ->addColumn('time_slot', function ($row) {
                return $row->time_slot;
            })
            ->addColumn('workout_plan_name', function ($row) {
                return $row->workout_plan_name;
            })
            ->addColumn('bmi', function ($row) {
                return $row->bmi;
            })
            ->addColumn('bmi_type', function ($row) {
                return $row->bmi_type;
            })
            ->addColumn('current_height', function ($row) {
                return $row->current_height;
            })
            ->addColumn('current_weight', function ($row) {
                return $row->current_weight;
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . url('sample/' . $row->id) . '" class="' . "delete-giveaway" . '"><i class="fas fa-trash-alt text-danger font-16"></i></a>';
            })
            ->rawColumns(['action'])

            ->make(true);
        }

        $data['workouts'] = $app_service->getAllWorkouts();
        return view('appointment.index',compact('data'));
    }

    public function view(Request $request){
        $action = $request->action;
        $id = $request->id;

        $app_service = new AppointmentService();

        switch($action) {
            case 'Add':

                $data['workouts'] = $app_service->getAllWorkouts();
                $data['userName'] = User::select(DB::raw("CONCAT(first_name,' ',last_name) As userName"))->where('uid', 1)->first();
                $data['userID'] = User::select('uid')->where('uid', 1)->first();

                return view('appointment.create',compact('data'));
                 break;
            default:
        }
    }

    public function create(Request $request)
    {
        $action = $request->action;
        $id = $request->id;
        $data = $request->all();

        if($action == 'Add'){
            $rules = [
                'uid' => 'required',
                'userName' => 'required',
                'appointment_date' => 'required',
                'current_height' => 'required|between:0,999.99',
                'current_weight' => 'required|between:0,999.99',
                'workout_plan_id' => 'required',
                'time_slot' => 'required',
                'bmi' => 'required',
            ];
        }

        $validatedData = Validator::make(
            $request->all(),
            $rules,
            [
                'uid.required' => 'This field is required',
                'userName.required' => 'This field is required',
                'appointment_date.required' => 'This field is required',
                'current_height.required' => 'This field is required',
                'current_weight.required' => 'This field is required',
                'workout_plan_id.required' => 'This field is required',
                'time_slot.required' => 'This field is required',
                'bmi.required' => 'This field is required',
            ]
        );

        if ($validatedData->fails()) {
            return redirect()->back()->withInput()->withErrors($validatedData->errors())
                ->with('error_message', 'please check as we’re missing some information.');
        } else {
            $app_service = new AppointmentService();
            switch($action) {
                case 'Add':
                    $res = $this->store($data);
                    if($res){
                        return redirect(route('appointment_index'))->with('success_message', 'Record created succefully ');
                    }else{
                        return redirect()->back()->withInput()->withErrors($validatedData->errors())
                        ->with('error_message', 'please check as we’re missing some information.');
                    }
                    // return view('appointment.create',compact('data'));
                    break;
                default:
            }
        }

    }


    public function store($data)
    {
        $appointment = new Appointment();

        $bmi = $this->getBMIAndType($data['current_height'],$data['current_weight']);

        $appointment->uid = $data['uid'];
        $appointment->appointment_date = Carbon::createFromFormat('m/d/Y',$data['appointment_date'])->format('Y-m-d');
        $appointment->current_height = $data['current_height'];
        $appointment->current_weight = $data['current_weight'];
        $appointment->workout_plan_id = $data['workout_plan_id'];
        $appointment->diet_plan_id = $bmi['diet_plan'];
        $appointment->time_slot = $data['time_slot'];
        $appointment->bmi = $bmi['bmi'];
        $appointment->bmi_type = $bmi['bmi_type'];

        return $appointment->save();

    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function getBMIAndType($height,$weight)
    {
        $bmi =   number_format((float)$weight/($height*$height), 2, '.', '');
        if($bmi < 18.50){
            $bmi_type = 'Underweight';
            $diet_plan = '1';
        }else if($bmi >= 18.50 && $bmi  < 24.90){
            $bmi_type = 'Normal weight';
            $diet_plan = '2';
        }else if($bmi  >= 24.90 && $bmi  < 30.00){
            $bmi_type = 'Overweight';
            $diet_plan = '3';
        }else{
            $bmi_type = 'Obesity';
            $diet_plan = '4';
        }
        $data['bmi'] = $bmi;
        $data['bmi_type'] = $bmi_type;
        $data['diet_plan'] = $diet_plan;

        return $data;
    }

    public function getSugestedSchedules(Request $request){
        $bmi = $request->bmi;
        if($bmi < 18.50){
            $bmi_type = 'Underweight';
        }else if($bmi >= 18.50 && $bmi  < 24.90){
            $bmi_type = 'Normal weight';
        }else if($bmi  >= 24.90 && $bmi  < 30.00){
            $bmi_type = 'Overweight';
        }else{
            $bmi_type = 'Obesity';
        }

        $res = WorkoutPlan::select('*')->where('workout_bmi_category',$bmi_type)->get();

        return response()->json(['success' => 1, 'data' => $res], 200);
    }
}
