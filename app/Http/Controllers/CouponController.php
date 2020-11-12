<?php

namespace App\Http\Controllers;
use App\Http\Classes\CouponCode;
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

    // define the coupon variable
    protected $coupon;

    public function __construct()
    {
        // instatiating the coupon class
        $this->coupon = new CouponCode;

    }

    // generate and return a coupon code
    public function store(Request $request)
    {
        $CouponModel = new Coupon;
        $CouponModel->rules($request->all());
        
        $couponCode = $CouponModel::create([
            'code' => $this->coupon->generateCouponString(6),
            'event_id' => $request->event_id,
            'radius' => $request->radius,
            'amount' => $request->amount,
            'expires_at' => $request->expires_at,
        ]);

        return response()->json(['data'=>$couponCode, 'created'=>true], 201);
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

    public function use($coupon){
        $coupon = Coupon::findOrFail($coupon);
        $coupon->update(['used'=>'1']);

        return response()->json(['data'=>$coupon, 'used'=>true], 200);
    }

    public function deactivate_coupon($coupon){
        $coupon = Coupon::findOrFail($coupon);
        $coupon->update(['active'=>'0']);

        return response()->json(['data'=>$coupon, 'deactivated'=>true], 200);
    }
}
