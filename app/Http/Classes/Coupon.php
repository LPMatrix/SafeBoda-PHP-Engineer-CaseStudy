<?php
namespace App\Http\Classes;

class Coupon
{

    public function __construct()
    {
        //
    }

    public function generateCouponString($length) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $couponString = '';
        for ($i = 0; $i < $length; $i++) {
            $couponString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $couponString;
    }
     
}
