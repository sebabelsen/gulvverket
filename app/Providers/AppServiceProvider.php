<?php

namespace App\Providers;

use App\Mail\OrderConfirmation;
use App\Mail\OrderNotification;
use DuncanMcClean\Cargo\Events\OrderCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

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
            Mail::to($event->order->customer())
                ->locale($event->order->site()->shortLocale())
                ->send(new OrderConfirmation($event->order));
        });

        // Varsel til Tom ved ny bestilling
        Event::listen(OrderCreated::class, function ($event) {
            if ($email = env('ORDER_NOTIFICATION_EMAIL')) {
                Mail::to($email)
                    ->locale($event->order->site()->shortLocale())
                    ->send(new OrderNotification($event->order));
            }
        });
    }
}