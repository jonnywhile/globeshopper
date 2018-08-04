<form action="/charges/create/{{ $request->id }}" method="POST">
    <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{ $request->globshopper->stripe_public_key }}"
            data-amount="{{ $request->offer->price }}"
            data-name="Demo Site"
            data-description="Widget"
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="auto">
    </script>
</form>