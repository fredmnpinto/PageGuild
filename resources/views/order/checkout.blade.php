@extends('layouts.app')

@section('title')
    LabWeb | Index
@endsection

@section('content')
    {{-- Shopping Cart --}}
    <div class="card">
        <div class="card-header"><h1>{{ __("Checkout") }}</h1></div>
        <div class="card-body">
            <h2>{{__("Itens a Comprar")}}</h2>
            <table class="table rounded">
                <thead>
                    <tr>
                        <th>{{ __("Item") }}</th>
                        <th>{{ __("Quantidade") }}</th>
                        <th>{{ __("Total com iva") }}</th>
                        <th class="text-secondary">{{ __("Total sem iva") }}</th>
                    </tr>
                </thead>
                @foreach($shoppingCartItems as $item)
                    <tr>
                        <td><a class="book-link" href="{{ route('showDetails', ['id' => $item->id]) }}">{{ /* Põe a primeira letra de cada palavra em maiúscula */ ucwords(__($item->name), ' ') }}</a></td>
                        <td>
                            <form class="no-background" method="post">
                                @csrf
                                <span class="input-group-btn btn-group-sm">
                                    <button type="submit" class="quantity-left-minus btn btn-danger btn-number btn-sm"
                                            data-type="minus" data-field="" formaction="{{ route('order.remove_from_cart', ['item_id' => $item->id]) }}">
                                        <span>-</span>
                                    </button>
                                </span>

                                <span class="number">{{ $item->qty }}</span>

                                <span class="input-group-btn btn-group-sm">
                                    <input type="submit" class="quantity-right-plus btn btn-success btn-number btn-sm"
                                            data-type="plus" formaction="{{ route('order.add_to_cart', ['item_id' => $item->id]) }}" value="+">
                                </span>
                            </form>
                        <td>{{ $item->total }}€</td>
                        <td class="text-secondary">{{ $item->subtotal }}€</td>
                    </tr>
                @endforeach
                <tr class="secondary-color row-highlight">
                    <td>{{ __('Total') }}</td>
                    <td>{{ $total_qty }}</td>
                    <td>{{ $total_amount_tax_included }}€</td>
                    <td>{{ $total_amount }}€</td>
                </tr>
            </table>
        </div>
        {{-- Payment --}}
        <div class="card-body">
            <form method="POST" action="{{ route('order.purchase') }}" class="card-form rounded mt-3 mb-3 my-4">
                @csrf
                <input type="hidden" name="payment_method" class="payment-method">
                <h2>{{ __("Informações do cartão") }}</h2>
                <input class="StripeElement mb-3" name="card_holder_name" placeholder="{{ __("Nome no Cartão") }}" required>
                    <div class="col-lg-4 col-md-6">
                        <div id="card-element"></div>
                    </div>
                    <div id="card-errors" role="alert">
                        @if(session('error'))
                            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                        @endif
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary pay">
                            Purchase
                        </button>
                        @if(session('message'))
                            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                        @endif
                    </div>
            </form>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }
        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }
        .StripeElement--invalid {
            border-color: #fa755a;
        }
        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        let stripe = Stripe("{{ env('STRIPE_KEY') }}")
        let elements = stripe.elements()
        let style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        }
        let card = elements.create('card', {style: style})
        card.mount('#card-element')
        let paymentMethod = null
        $('.card-form').on('submit', function (e) {
            $('button.pay').attr('disabled', true)
            if (paymentMethod) {
                return true
            }
            stripe.confirmCardSetup(
                "{{ $intent->client_secret }}",
                {
                    payment_method: {
                        card: card,
                        billing_details: {name: $('.card_holder_name').val()}
                    }
                }
            ).then(function (result) {
                if (result.error) {
                    $('#card-errors').text(result.error.message)
                    $('button.pay').removeAttr('disabled')
                } else {
                    paymentMethod = result.setupIntent.payment_method
                    $('.payment-method').val(paymentMethod)
                    $('.card-form').submit()
                }
            })
            return false
        })
    </script>
@endsection
