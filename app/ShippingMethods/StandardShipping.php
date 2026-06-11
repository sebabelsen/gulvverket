<?php

namespace App\ShippingMethods;

use DuncanMcClean\Cargo\Contracts\Cart\Cart;
use DuncanMcClean\Cargo\Shipping\ShippingMethod;
use DuncanMcClean\Cargo\Shipping\ShippingOption;
use Illuminate\Support\Collection;

class StandardShipping extends ShippingMethod
{
    public function options(Cart $cart): Collection
    {
        return collect([
            ShippingOption::make($this)
                ->name(__('Standard pakke'))
                ->price(9900)
                ->acceptsPaymentOnDelivery(true),

            ShippingOption::make($this)
                ->name(__('Stor pakke'))
                ->price(19900)
                ->acceptsPaymentOnDelivery(true),
        ]);
    }
}