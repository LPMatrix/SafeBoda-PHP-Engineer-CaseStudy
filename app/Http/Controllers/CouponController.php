<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Coupon;

class CouponController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    // generate and return a coupon code
    public function store(Request $request)
    {
        $CouponModel = new Coupon;
        $validator = $CouponModel->rules($request->all());
        if($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all(), 'status' => false], 400);
        }
        
        $couponCode = $CouponModel::create([
            'code' => $CouponModel->generateCouponString(6),
            'event_id' => $request->event_id,
            'radius' => $request->radius,
            'amount' => $request->amount,
            'expires_at' => $request->expires_at,
        ]);

        return response()->json(['data'=>$couponCode, 'status'=>true], 201);
    }

    public function index(){
        $coupons = Coupon::all();
        return response()->json(['data'=>$coupons], 200);
    }

    public function active_coupons(){
        $CouponModel = new Coupon;
        $coupons = $CouponModel->active()->get()->toArray();
        return response()->json(['data'=>$coupons], 200);
    }

    public function deactivate_coupon($coupon){
        $coupon = Coupon::findOrFail($coupon);
        $coupon->update(['active'=>'0']);

        return response()->json(['data'=>$coupon, 'status'=>true], 200);
    }

    public function update(Request $request, $coupon){
        $coupon = Coupon::findOrFail($coupon);
        $coupon->update(['radius'=>$request->radius]);
        return response()->json(['data'=>$coupon, 'status'=>true], 200);
    }

    public function verify(Request $request){
        $CouponModel = new Coupon;
        $latitudeFrom = $request->origin[0]; 
        $longitudeFrom = $request->origin[1]; 
        $latitudeTo = $request->destination[0]; 
        $longitudeTo = $request->destination[1];
        $coupon = $request->coupon;
        
        $response = $CouponModel->isValid($coupon);

        if ($response) {
            $points = [$request->origin, $request->destination];
            $coupon = $CouponModel->getVGCD($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $coupon)->get()->toArray();
            if (count($coupon) > 0) {
                return response()->json(['data' => $coupon, 'polyline' => $CouponModel->getPolyline($points), 'status' => true], 200);
            } else {
                return response()->json(['message' => 'Coupon code is invalid','status' => false], 404);
            }
        
        }else{
            return response()->json(['message' => 'Coupon code is invalid','status' => false], 404);
        }

    }
}