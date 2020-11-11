# SaeBoda Coupon code API

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

## Documentation
vendor\bin\phpunit tests