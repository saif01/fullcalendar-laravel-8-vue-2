<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Calendar;

class CalendarController extends Controller
{
    //index
    public function index(){

        $allData = Calendar::get()->toArray();

       // dd($allData);

        return response()->json($allData, 200);

    }

    // store
    public function store(Request $request){

        //dd($request->all());

        //Validate
        $this->validate($request,[
            'title'         => 'required|string|max:500',
            'start_date'    => 'required',
            'start_time'    => 'required',
            'end_date'      => 'required',
            'end_time'      => 'required',
            'remarks'       => 'nullable|string|max:1000',
        ]);


        $start = $request->start_date ." ". $request->start_time;
        $end = $request->end_date ." ". $request->end_time;

        $data = new Calendar();

        $data->title    = $request->title;
        $data->start    = $start;
        $data->end      = $end;
        $data->remarks  = $request->remarks;
        $data->save();



        return response()->json('Success', 200);



    }


}
