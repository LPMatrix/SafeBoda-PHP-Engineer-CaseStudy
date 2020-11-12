<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Coupon;
use App\Event;

class CouponCodeTest extends TestCase
{   
    // delete the data created during a test from the databse after every test run
    use DatabaseTransactions;

    // test if an event can be created
    public function testCanCreateEvent()
    {
        $data = factory(Event::class)->make()->toArray();

        $this->json("POST", '/api/create_event', $data)->seeJson([
            'created' => true,
        ])->assertResponseStatus(201);
    }

    // test if events can be listed
    public function testListEvent()
    {
        $data = factory(Event::class)->make()->toArray();

        $this->json("GET", '/api/events', $data)->seeJson([
            'data' => Event::all()->toArray(),
        ])->assertResponseStatus(200);

    }
    
    // test if coupon can be created
    public function testCanCreateCoupon()
    {
        $data = factory(Coupon::class)->make()->toArray();

        $this->json("POST", '/api/generate_coupon', $data)->seeJson([
            'created' => true,
        ])->assertResponseStatus(201);
    }

    // test if all coupons can be listed
    public function testListCoupon()
    {
        $data = factory(Coupon::class)->make()->toArray();

        $this->json('GET', 'api/coupons', $data)->seeJson([
            'data' => Coupon::all()->toArray(),
        ])->assertResponseStatus(200);

    }

    // test if only active coupons can be listed
    public function testListActiveCoupon()
    {
        $couponModel = new Coupon;
        $activeCoupons = $couponModel->active()->get()->toArray();
        $this->json('GET', 'api/active_coupons')->seeJson([
            'data' => $activeCoupons,
        ])->assertResponseStatus(200);

    }

    // test if a coupon can be used
    public function testCanUseCoupon(){
        $data = factory(Coupon::class)->create();
        $this->json('PUT', 'api/use_coupon/'.$data->id)->seeJson([
            'used' => true
        ])->assertResponseStatus(200);
    }

    // test if a coupon can be deactivated
    public function testCanDeactivateCoupon()
    {
        $data = factory(Coupon::class)->create();
        $this->json('PUT', 'api/deactivate_coupon/'.$data->id)->seeJson([
            'deactivated' => true
        ])->assertResponseStatus(200);

    }

    // test if coupon radius can be updated
    public function testCanUpdateCouponRadius()
    {
        $data = factory(Coupon::class)->create()->toArray();
        $this->json('POST', 'api/update_coupon/', $data)->seeJson([
            'updated' => true
        ])->assertResponseStatus(200);

    }
}