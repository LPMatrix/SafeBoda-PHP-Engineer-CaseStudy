# SaeBoda Coupon Code API

SafeBoda wants to give out promo codes worth x amount during events so people can get
free rides to and from the event. The flaw with that is people can use the promo codes without
going to the event.

### Task: Implement a Promo code API with the following features.
* Generation of new promo codes for an event
* The promo code is worth a specific amount of ride
* The promo code can expire
* Can be deactivated
* Return active promo codes
* Return all promo codes
* Only valid when user’s pickup or destination is within x radius of the event venue
* The promo code radius should be configurable
* To test the validity of the promo code, expose an endpoint that accepts origin, destination, the promo code.
* The API should return the promo code details and a polyline using the destination and origin if the promo code is valid and an error otherwise.

## Installation
Git clone this repo

```bash
git clone https://github.com/LPMatrix/SafeBoda-PHP-Engineer-CaseStudy.git
````

### Install needed libraries via composer:

```bash
composer install
```

### Serving the API

```php
php -S localhost:8000 -t public
```

## Testing
Run this to run the tests for the API:

```bash
vendor\\bin\\phpunit tests
```

## Usage

### Create an event

``` curl
curl -X POST \
  http://localhost:8000/api/event/create_event \
  -H 'Content-Type: application/json' \
  -d '{
        "name": "DSN Bootcamp",
        "latitude": "63.140778",
        "longitude": "-64.759483",
    }'
```

### Get all events

``` curl
curl -X GET http://localhost:8000/api/event/events
```

### Generate a coupon
#### Radius is in kilometers (km)

``` curl
curl -X POST \
  http://localhost:8000/api/coupon/generate_coupon \
  -H 'Content-Type: application/json' \
  -d '{
        "code": "FK87HW",
        "event_id": "2",
        "radius": "64",
        "expires_at": "2020-12-02 00:00:00",
        "amount": "2400",
    }'
```

### Get all coupons

``` curl
curl -X GET http://localhost:8000/api/coupon/coupons
```

### Get active coupons

``` curl
curl -X GET http://localhost:8000/api/coupon/active_coupons
```

### Update a coupon's radius
#### Radius is in kilometers (km)

``` curl
curl -X PUT \
  http://localhost:8000/api/coupon/update_coupon/:id \
  -H 'Content-Type: application/json' \
  -d '{
        "radius": "74",
    }'
```

### Deactivate a coupon

``` curl
curl -X PUT \
  http://localhost:8000/api/coupon/deactivate_coupon/:id \
  -H 'Content-Type: application/json' \
  -d '{
        "id": "1",
    }'
```

### Validate a coupon code

```curl
curl -X POST \
  http://localhost:8000/api/coupon/validate \
  -H 'Content-Type: application/json' \
  -d '{
       "code": "FK87HW",
       "origin": [
          -99.123456,
          -50.098765
       ],
       "destination": [
          -65.975421,
          180.456789
       ]
    }'
```