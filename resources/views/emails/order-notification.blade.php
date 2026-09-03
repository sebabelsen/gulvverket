<x-mail::message>
# Ny bestilling #{{ $order->orderNumber }}

En ny bestilling med faktura-betaling er mottatt. Lag faktura og send til kunden.

<x-mail::panel>
**Kunde:** {{ $order->customer()->name }}
**E-post:** [{{ $order->customer()->email }}](mailto:{{ $order->customer()->email }})
@if($order->get('company'))
**Bedrift:** {{ $order->get('company') }}
@endif
@if($order->get('phone'))
**Telefon:** {{ $order->get('phone') }}
@endif
</x-mail::panel>

## Leveringsadresse

@if($order->hasShippingAddress())
{{ $order->shippingAddress() }}
@else
*Ingen leveringsadresse oppgitt.*
@endif

## Fakturaadresse

{{ $order->billingAddress() }}

## Bestilling

<x-mail::table>
| Antall | Produkt | Sum |
| :----- | :------ | --: |
@foreach($order->lineItems() as $lineItem)
| {{ $lineItem->quantity }} | {{ $lineItem->product()->title }} | {{ $lineItem->sub_total }} |
@endforeach
</x-mail::table>

<x-mail::table>
|              |               |
| :----------- | ------------: |
| Delsum       | {{ $order->sub_total }} |
@if($order->shippingOption())
| Frakt ({{ $order->shippingOption()->name() }}) | {{ $order->shipping_total }} |
@endif
| **Total**    | **{{ $order->grand_total }}** |
</x-mail::table>

@if(config('statamic.cargo.taxes.price_includes_tax'))
*Mva (25%) er inkludert i totalen.*
@endif

<x-mail::button :url="config('app.url') . '/cp/cargo/orders/' . $order->id()">
Åpne ordre i Statamic CP
</x-mail::button>

---

{{ config('app.name') }}
</x-mail::message>