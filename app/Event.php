<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	protected $fillable = [
	        'name',
	        'longitude',
	        'latitude',
    	];

	public function coupon()
	{
		return $this->hasMany(Coupon::class);
	}
}