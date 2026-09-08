<?php

namespace App\Providers;

use App\Mail\OrderConfirmation;
use App\Mail\OrderNotification;
use DuncanMcClean\Cargo\Events\OrderCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bekreftelse til kunden ved bestilling
        Event::listen(OrderCreated::class, function ($event) {
            // Safely grab the email from either the customer object or the top-level order data
            $customerEmail = $event->order->customer()?->email ?? $event->order->get('email');

            if ($customerEmail) {
                Mail::to($customerEmail)
                    ->locale($event->order->site()->shortLocale())
                    ->send(new OrderConfirmation($event->order));
            }
        });

        // Varsel til kontakt@gulvverket.no ved ny bestilling
        Event::listen(OrderCreated::class, function ($event) {
            if ($email = env('ORDER_NOTIFICATION_EMAIL')) {
                Mail::to($email)
                    ->locale($event->order->site()->shortLocale())
                    ->send(new OrderNotification($event->order));
            }
        });
    }
}