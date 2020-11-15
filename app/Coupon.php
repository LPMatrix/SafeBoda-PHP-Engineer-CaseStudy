<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Polyline;
use App\Event;

class Coupon extends Model
{
		protected $dates = [
        	'expires_at',
    	];
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

		public function generateCouponString($length) {
	        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	        $charactersLength = strlen($characters);
	        $couponString = '';
	        for ($i = 0; $i < $length; $i++) {
	            $couponString .= $characters[rand(0, $charactersLength - 1)];
	        }
	        return $couponString;
    	}

		public function rules($request){
			$todayDate = Carbon::now();
			$rules = [
	            'radius' => 'required|numeric',
	            'event_id' => 'required|numeric',
	            'amount' => 'required|numeric',
	            'expires_at' => 'required|date|after_or_equal:'.$todayDate
	        ];

	        return $validator = Validator::make($request, $rules);

		}

		// filter active coupons
		public function active()
		{
        	return Coupon::where('active', '1')->where('used', '0')->whereDate('expires_at', '>', Carbon::now());
    	}

    	// using vincenty Great Circle Distance to calculate distance between origin and destinatoin 
    	public function VGCD($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000) {
			// convert from degrees to radians
			$latFrom = deg2rad($latitudeFrom);
			$lonFrom = deg2rad($longitudeFrom);
			$latTo = deg2rad($latitudeTo);
			$lonTo = deg2rad($longitudeTo);

			$lonDelta = $lonTo - $lonFrom;
			$a = pow(cos($latTo) * sin($lonDelta), 2) + pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
			$b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

			$angle = atan2(sqrt($a), $b);

			return ($angle * $earthRadius) / 1000;
		}

		public function isValid($coupon){
			$coupons = $this->active()->get()->toArray();

			foreach ($coupons as $key => $value) {
				if ($value['code'] == $coupon) {
            		return true;
	        	}
			}
			return false;
			
		}

		public function getVGCD($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $coupon)
		{
			$event = Coupon::where('code', $coupon)->firstOrFail();
			$event = Event::find($event->event_id);

			$event_longitude = $event->longitude;
			$event_latitude = $event->latitude;

			$origin_to_event_distance = $this->VGCD($latitudeFrom, $longitudeFrom, $event_latitude, $event_longitude);
			$event_to_destination_distance = $this->VGCD($event_latitude, $event_longitude, $latitudeTo, $longitudeTo);

        	return Coupon::where('radius', '>=', $origin_to_event_distance)->orWhere('radius', '>=', $event_to_destination_distance)->where('code', $coupon);
    	}

    	// get polyline for active coupon code
    	public function getPolyline(array $points)
    	{
       		return Polyline::encode($points);
    	}
}