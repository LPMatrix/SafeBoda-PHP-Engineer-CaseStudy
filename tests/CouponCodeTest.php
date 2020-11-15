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

        $this->json("POST", '/api/event/create_event', $data)->seeJson([
            'status' => true,
        ])->assertResponseStatus(201);
    }

    // test if events can be listed
    public function testListEvent()
    {
        $data = factory(Event::class)->make()->toArray();

        $this->json("GET", '/api/event/events', $data)->seeJson([
            'data' => Event::all()->toArray(),
        ])->assertResponseStatus(200);

    }
    
    // test if coupon can be created
    public function testCanCreateCoupon()
    {
        $data = factory(Coupon::class)->make()->toArray();
        $this->json("POST", '/api/coupon/generate_coupon', $data)->seeJsonStructure([
            'data' => [],
        ])->assertResponseStatus(201);
    }

    // test for coupon creation error
    public function testCreateCouponError()
    {
        $this->json('POST', '/api/coupon/generate_coupon', [])->seeJsonStructure([
            'message' => [],
        ])->assertResponseStatus(400);
    }

    // test if all coupons can be listed
    public function testListCoupon()
    {
        $data = factory(Coupon::class)->make()->toArray();

        $this->json('GET', 'api/coupon/coupons', $data)->seeJson([
            'data' => Coupon::all()->toArray(),
        ])->assertResponseStatus(200);

    }

    // test if only active coupons can be listed
    public function testListActiveCoupon()
    {
        $couponModel = new Coupon;
        $activeCoupons = $couponModel->active()->get()->toArray();
        $this->json('GET', 'api/coupon/active_coupons')->seeJson([
            'data' => $activeCoupons,
        ])->assertResponseStatus(200);

    }

    // test if a coupon can be deactivated
    public function testCanDeactivateCoupon()
    {
        $data = factory(Coupon::class)->create();
        $this->json('PUT', 'api/coupon/deactivate_coupon/'.$data->id)->seeJson([
            'status' => true,
        ])->assertResponseStatus(200);

    }

    // test if coupon radius can be updated
    public function testCanUpdateCouponRadius()
    {
        $data = factory(Coupon::class)->create()->toArray();
        $this->json('PUT', 'api/coupon/update_coupon/'.$data['id'], $data)->seeJson([
            'status' => true,
        ])->assertResponseStatus(200);

    }

    // test if coupon can be validated
    public function testCanValidateCoupon()
    {
        $data = factory(Coupon::class)->create();
        $data = ['origin' => [9.0885365, 7.41783142], 'destination' =>[-65.975421, 180.456789], 'coupon'=> $data->code];
        $this->json('POST', 'api/coupon/validate/', $data)->seeJson([
            'status' => true
        ])->assertResponseStatus(200);

    }

    // test for coupon validation error
    public function testValidateCouponError()
    {
        $this->json('POST', 'api/coupon/validate', [])->seeJsonStructure([
            'message' => [],
        ])->assertResponseStatus(404);
    }


}