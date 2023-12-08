@extends('admin.layouts.master')
@push('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('body')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>{{$title}}</h1>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-12 col-12">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show">{{ $error }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
          <div class="card col-xs-6 col-md-6 offset-2">
            <div class="card-body pt-3">
              <div class="tab-content pt-2">
                <div class="t" id="profile-edit">
                  <!-- Profile Edit Form -->
                  <div class="panel-body">
                    <br>
                    <form role="form" action="{{ route('admin.payment.stripe') }}" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ config('app.stripe_key') }}" id="payment-form">
                       @csrf
                       <div class='form-row row'>
                          <div class='col-xs-12 col-md-12 form-group required'>
                             <label class='control-label'>Name on Card</label>
                             <input class='form-control' size='4' type='text'>
                          </div>
                          <div class='col-xs-12 col-md-12 form-group required'>
                             <label class='control-label'>Card Number</label>
                             <input autocomplete='off' class='form-control card-number' size='20' type='text'>
                          </div>
                          <div class='col-xs-12 col-md-12 form-group cvc required'>
                             <label class='control-label'>CVC</label>
                             <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='3' maxlength="3" type='text'>
                          </div>
                          <div class='col-xs-12 col-md-12 form-group expiration required'>
                             <label class='control-label'>Expiration Month</label>
                             <input class='form-control card-expiry-month' placeholder='MM' size='2' maxlength="2" type='text'>
                          </div>
                          <div class='col-xs-12 col-md-12 form-group expiration required'>
                             <label class='control-label'>Expiration Year</label>
                             <input class='form-control card-expiry-year' placeholder='YYYY' size='4' maxlength="4" type='text'>
                          </div>
                       </div>
                       <br>
                       <div class="form-row row">
                          <div class="col-xs-12">
                             <button class="btn btn-primary btn-md btn-block" type="submit">Pay Now</button>
                          </div>
                       </div>
                    </form>

      </div>
    </section>

  </main><!-- End #main -->
@push('script')
    <script src="https://js.stripe.com/v2/"></script>
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
@endpush
@endsection
