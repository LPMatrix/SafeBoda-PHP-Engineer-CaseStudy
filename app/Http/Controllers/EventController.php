<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Event;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    // define the coupon variable
    protected $coupon;

    public function __construct()
    {

    }

    // generate and return a coupon code
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/']
        ];

        $validator = Validator::make($request->all(), $rules);
        
        if($validator->fails()) {
            return response()
                    ->json(['errors' => $validator->errors(), 'created' => false], 400);
        } 

        $eventModel = new Event;
        $event = $eventModel::create([
            'name' => $request->name,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ]);

        return response()->json(['data'=>$event, 'created'=>true], 201);
    }

    public function index(){
        $coupons = Event::all();
        return response()->json(['data'=>$coupons], 200);
    }


}
