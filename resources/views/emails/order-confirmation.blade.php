<x-mail::message>
# Bestilling #{{ $order->orderNumber }} er bekreftet

Bestillingen din er bekreftet. Vi gir beskjed når den er på vei.

<x-mail::table>
| Produktbeskrivelse   |               |
| :------------------- | ------------: |
@foreach($order->lineItems() as $lineItem)
@php
$hasDownloads = $lineItem->hasDownloads();
$downloadUrl = URL::signedRoute('statamic.cargo.download', [
    'orderId' => $order->id(),
    'lineItem' => $lineItem->id(),
]);
@endphp
| {{ $lineItem->quantity }}x {{ $lineItem->product()->title }} @if($hasDownloads) <br><br> [Last ned]({{ $downloadUrl }}) @endif | {{ $lineItem->sub_total }} |
@endforeach
</x-mail::table>

<x-mail::table>
|                    |               |
| -----------------: | ------------: |
| **Subtotal** | {{ $order->sub_total }} |
@if($order->discounts)
| **Rabatter** | -{{ $order->discount_total }}|
@endif
@if($order->shippingOption)
| **Levering** ({{ $order->shippingOption()->name }}) | {{ $order->shipping_total }} |
@endif
@unless(config('statamic.cargo.taxes.price_includes_tax'))
| **Skatt** | {{ $order->tax_total }} |
@endunless
| **Total** | **{{ $order->grand_total }}** |
</x-mail::table>

<x-mail::panel>
@if($order->shippingOption)
**Fraktmetoder:** {{ $order->shippingOption()->name() }}
@endif

@if($order->hasShippingAddress())
**Leveringsadresse:** {{ $order->shippingAddress() }}
@endif

**Faktueringsadresse:** {{ $order->billingAddress() }}

**Kunde:** {{ $order->customer()->name }} ({{ $order->customer()->email }})
</x-mail::panel>

Takk for bestillingen!<br>
{{ config('app.name') }}
</x-mail::message>
