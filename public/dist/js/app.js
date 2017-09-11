$(function(){
  var $form = $('payment-form');
  $form.submit(function(event){
    //disable the submit button to prevent repeated clicks
    $form.find('.submit').prop('disabled',true);

    //request a token from stripe
    Stripe.card.createToken($form,stripeResponseHandler);

    //prevent the form from being submitted
    return false;   

  });
});


function stripeResponseHandler(status, response) {

  // Grab the form:
  var $form = $('#payment-form');

  if (response.error) { // Problem!

    // Show the errors on the form
    $form.find('.payment-errors').text(response.error.message);
    $form.find('button').prop('disabled', false); // Re-enable submission

  } else { // Token was created!

    // Get the token ID:
    var token = response.id;

    // Insert the token into the form so it gets submitted to the server:
    $form.append($('<input type="hidden" name="stripeToken" />').val(token));

    // Submit the form:
    $form.get(0).submit();

  }
}