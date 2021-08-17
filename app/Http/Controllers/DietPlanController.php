<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DietPlan;
use App\Services\DietPlanService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class DietPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $diet_service = new DietPlanService();

        if ($request->ajax()) {
            $diets = $diet_service->getAllDietPlans($request->all());
            return datatables()->of($diets)
            ->addColumn('diet_id', function ($row) {
                return $row->diet_plan_id;
            })
            ->addColumn('created_date', function ($row) {
                $date =  Carbon::createFromFormat('Y-m-d H:i:s',$row->created_at)->format('m/d/Y');
                return $date;
            })
            ->addColumn('diet_plan_name', function ($row) {
                return $row->diet_plan_name;
            })
            ->addColumn('bmi_category', function ($row) {

                return $row->bmi_category;
            })
            ->addColumn('breakfast', function ($row) {
                return $row->breakfast;
            })
            ->addColumn('lunch', function ($row) {
                return $row->lunch;
            })
            ->addColumn('dinner', function ($row) {
                return $row->dinner;
            })
            ->addColumn('description', function ($row) {
                return $row->diet_desc;
            })
            ->addColumn('action', function ($row) {
                $delete = '<a data-placement="top" data-toggle="tooltip-primary" title="Delete" data-appid = "'.$row->appointment_id.'" ><i class="fas fa-trash-alt text-danger  fa-lg delete"></i></a> ';
                $edit = ' <a href="#" data-toggle="tooltip-primary" title="Edit"><i class="fas fa-edit text-warning fa-lg" data-placement="top"></i></a>';
                return $edit.' '.$delete;
            })
            ->rawColumns(['action'])

            ->make(true);
        }
        return view('dietplans.index_diet_plan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $dietPlansCount=DietPlan::count();

        if($dietPlansCount >= 4){
            return redirect()->back()->withInput()
            ->with('error_message', 'SORRY , System is not allowed to create more than 4 diet plans, There are already 4 diet plans in the system');

        }else{
        $rules = [
            'diet_plan_name' => 'required|min:5|unique:diet_plan',
            'diet_plan_dinner' => 'required',
            'diet_plan_lunch' => 'required',
            'diet_plan_breakfast' => 'required',
            'diet_plan_bmi_category' => 'required',
        ];

        $validatedData = Validator::make(
            $request->all(),
            $rules,
            [
                'diet_plan_name.required' => 'This field is required',
                'diet_plan_lunch.required' => 'Enter meals for lunch is required',
                'diet_plan_breakfast.required' => 'Enter meals for breakfast is required',
                'diet_plan_dinner.required' => 'Enter meals for dinner is required',
                'diet_plan_bmi_category.required' => 'Select a BMI Category is required',
            ]
        );

        if ($validatedData->fails()) {
            return redirect()->back()->withInput()->withErrors($validatedData->errors())
                ->with('error_message', 'please check as we’re missing some information.');
        }else{

            $diet_plan = new DietPlan();

            $statusNo = "no";

            $diet_plan->diet_plan_name=$request->diet_plan_name;
            $diet_plan->bmi_category=$request->diet_plan_bmi_category;
            $diet_plan->breakfast=$request->diet_plan_breakfast;
            $diet_plan->lunch=$request->diet_plan_lunch;
            $diet_plan->dinner=$request->diet_plan_dinner;
            $diet_plan->diet_desc=$request->diet_plan_description;

            if($request->diet_day_monday == null){
                $diet_plan->diet_monday = $statusNo;
            }else{
                $diet_plan->diet_monday=$request->diet_day_monday;
            }

            if($request->diet_day_tuesday == null){
                $diet_plan->diet_tuesday = $statusNo;
            }else{
                $diet_plan->diet_tuesday=$request->diet_day_tuesday;
            }

            if($request->diet_day_wednesday == null){
                $diet_plan->diet_wednesday = $statusNo;
            }else{
                $diet_plan->diet_wednesday=$request->diet_day_wednesday;
            }

            if($request->diet_day_thursday == null){
                $diet_plan->diet_thursday = $statusNo;
            }else{
                $diet_plan->diet_thursday=$request->diet_day_thursday;
            }

            if($request->diet_day_friday == null){
                $diet_plan->diet_friday = $statusNo;
            }else{
                $diet_plan->diet_friday=$request->diet_day_friday;
            }

            if($request->diet_day_saturday == null){
                $diet_plan->diet_saturday = $statusNo;
            }else{
                $diet_plan->diet_saturday=$request->diet_day_saturday;
            }

            if($request->diet_day_sunday == null){
                $diet_plan->diet_sunday = $statusNo;
            }else{
                $diet_plan->diet_sunday=$request->diet_day_sunday;
            }

            $res_plan = $diet_plan->save();






        if($res_plan){
            return redirect(route('diet_plan_index'))->with('success_message', 'Diet Plan created succefully ');
        }else{
            return redirect()->back()->withInput()->withErrors($validatedData->errors())
            ->with('error_message', 'please check as we’re missing some information.');
        }
    }

}

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

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function checkValid()
    {
        //
        $dietPlansCount=DietPlan::count();

        if($dietPlansCount < 4){
            $availablity = true;

        }else{
            $availablity = false;

        }
        return response()->json(['data' => $availablity],200);



    }
}