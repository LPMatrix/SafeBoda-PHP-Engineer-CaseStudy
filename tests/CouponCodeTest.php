<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Coupon;
use App\Event;

class CouponCodeTest extends TestCase
{
    use DatabaseTransactions;

    public function testCanCreateEvent()
    {
        $data = factory(Event::class)->make()->toArray();

        $this->json("POST", '/api/create_event', $data)->seeJson([
            'created' => true,
        ])->assertResponseStatus(201);
    }

    public function testListEvent()
    {
        $data = factory(Event::class)->make()->toArray();

        $this->json("GET", '/api/events', $data)->seeJson([
            'data' => Event::all()->toArray(),
        ])->assertResponseStatus(200);

    }
    
    public function testCanCreateCoupon()
    {
        $data = factory(Coupon::class)->make()->toArray();

        $this->json("POST", '/api/generate_coupon', $data)->seeJson([
            'created' => true,
        ])->assertResponseStatus(201);
    }

    public function testListCoupon()
    {
        $data = factory(Coupon::class)->make()->toArray();

        $this->json('GET', 'api/coupons', $data)->seeJson([
            'data' => Coupon::all()->toArray(),
        ])->assertResponseStatus(200);

    }

    public function testListActiveCoupon()
    {
        $data = factory(Coupon::class, 10)->make()->toArray();
        $couponModel = new Coupon;
        $activeCoupons = $couponModel->active()->get()->toArray();
        $this->json('GET', 'api/active_coupons')->seeJson([
            'data' => $activeCoupons,
        ])->assertResponseStatus(200);

    }

    public function testCanUseCoupon(){
        $data = factory(Coupon::class)->create();
        // dd($data);
        $this->json('PUT', 'api/use_coupon/'.$data->id)->seeJson([
            'used' => true
        ])->assertResponseStatus(200);
    }

    public function testCanDeactivateCoupon()
    {
        $data = factory(Coupon::class)->create();
        // dd($data);
        $this->json('PUT', 'api/deactivate_coupon/'.$data->id)->seeJson([
            'deactivated' => true
        ])->assertResponseStatus(200);

    }
}