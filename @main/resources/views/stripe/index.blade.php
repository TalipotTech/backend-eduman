<x-guest-layout>
    <div class="eduman-login-area flex justify-center items-center w-full h-full">
        <div class="panel panel-default credit-card-box">
            <div class="eduman-login-wrapper">
                <div class="panel-heading" >
                    <div class="row">
                        <h3>Secure Payment Info</h3>
                        @if($amt)
                        <p>Payable amount: {{$amt}}</p>
                        @endif
                    </div>
                </div>
                <div class="panel-body">
                    @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p><br>
                    </div>
                    @endif
                    <br>
                    <form role="form" action="{{ route('StripePay') }}" 
                        method="post" 
                        class="require-validation" 
                        data-cc-on-file="false" 
                        data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" 
                        id="payment-form">
                    @csrf

                    <input type="hidden" name="user_id" value="{{$user->id}}" />
                    <input type="hidden" name="order_id" value="{{$order_id}}" />

                    <div class="eduman-select-field mb-5">
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <x-text-input class="block mt-1 w-full" type="text" :placeholder="__('Name on Card')" value="{{$user->last_name}} {{$user->last_name}}" required autofocus />
                            </div>
                            <span class="input-icon">
                            <i class="fa-light fa-user"></i>
                            </span>
                        </div>
                    </div>

                    <div class="eduman-select-field mb-5">
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full">
                                <x-text-input class="block mt-1 w-full card-number" type="text" :placeholder="__('Card Number')" autocomplete='off' required autofocus />
                            </div>
                            <span class="input-icon">
                            <i class="fa-light fa-credit-card"></i>
                            </span>
                        </div>
                    </div>

                    <div class="eduman-select-field mb-5">
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full cvc">
                                <x-text-input class="block mt-1 w-full card-cvc" type="text" :placeholder="__('CVC')" autocomplete='off' required autofocus />
                            </div>
                            <span class="input-icon">
                            <i class="fa-light fa-credit-card"></i>
                            </span>
                        </div>
                    </div>

                    <div class="eduman-select-field mb-5">
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full expiration">
                                <x-text-input class="block mt-1 w-full card-expiry-month" type="text" :placeholder="__('Expiration Month')" autocomplete='off' required autofocus />
                            </div>
                            <span class="input-icon">
                            <i class="fa-light fa-calendar"></i>
                            </span>
                        </div>
                    </div>

                    <div class="eduman-select-field mb-5">
                        <div class="eduman-input-field-style">
                            <div class="single-input-field w-full expiration">
                                <x-text-input class="block mt-1 w-full card-expiry-year" type="text" :placeholder="__('Expiration Year')" autocomplete='off' required autofocus />
                            </div>
                            <span class="input-icon">
                            <i class="fa-light fa-calendar"></i>
                            </span>
                        </div>
                    </div>
                      
                    <div class="eduman-login-btn mb-7">
                        <div class="eduman-login-btn-full default-light-theme">
                            <x-primary-button class="btn-primary">{{ __('Pay Now') }}</x-primary-button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@section('js')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
$(function() {
  var $form = $(".require-validation");
  $('form.require-validation').bind('submit', function(e) {
    var $form = $(".require-validation"),
    inputSelector = ['input[type=email]', 'input[type=password]', 'input[type=text]', 'input[type=file]', 'textarea'].join(', '),
    $inputs = $form.find('.required').find(inputSelector),
    $errorMessage = $form.find('div.error'),
    valid = true;
    $errorMessage.addClass('hide');
    $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
        var $input = $(el);
        if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('hide');
            e.preventDefault();
        }
    });
    if (!$form.data('cc-on-file')) {
      e.preventDefault();
      Stripe.setPublishableKey($form.data('stripe-publishable-key'));
      Stripe.createToken({
          number: $('.card-number').val(),
          cvc: $('.card-cvc').val(),
          exp_month: $('.card-expiry-month').val(),
          exp_year: $('.card-expiry-year').val()
      }, stripeResponseHandler);
    }
  });

  function stripeResponseHandler(status, response) {
      if (response.error) {
          $('.error')
              .removeClass('hide')
              .find('.alert')
              .text(response.error.message);
      } else {
          /* token contains id, last4, and card type */
          var token = response['id'];
          $form.find('input[type=text]').empty();
          $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
          $form.get(0).submit();
      }
  }
});
</script>
@endsection
</x-guest-layout>