<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class Coupon extends Model
{
		 protected $fillable = [
	        'code',
	        'radius',
	        'event_id',
	        'amount',
	        'active',
	        'used',
	        'expires_at',
    	];

		public function event()
		{
			return $this->belongsTo(Event::class);
		}

		public function rules($request){
			$todayDate = Carbon::now();
			$rules = [
	            'radius' => 'required|numeric',
	            'event_id' => 'required|numeric',
	            'amount' => 'required|numeric',
	            'expires_at' => 'required|date_format:Y-m-d H:m:s|after_or_equal:'.$todayDate
	        ];

	        $validator = Validator::make($request, $rules);
	        
	        if($validator->fails()) {
	            return response()
	                    ->json(['errors' => $validator->errors(), 'created' => false], 400);
	        }

		}

		public function active()
		{
        	return Coupon::where('active', '1')->where('used', '0')->whereDate('expires_at', '>', Carbon::now());
    	}


}