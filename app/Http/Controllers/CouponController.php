<?php

namespace App\Http\Controllers;
use App\Http\Classes\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

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
        $this->coupon = new Coupon;

    }

    // generate and return a coupon code
    public function generate()
    {
        $couponCode = $this->coupon->generateCouponString(6);
        return response()->json($couponCode,200);
    }

    // generate and return more than one coupon code
    public function generateMany($size)
    {
        $couponCode = [];
        for ($i=0; $i < $size; $i++) { 
            array_push($couponCode, $this->coupon->generateCouponString(6));
        }
        
        return response()->json($couponCode,200);
    }
}
