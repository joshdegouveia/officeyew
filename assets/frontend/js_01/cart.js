function cardValidation() {
    var valid = true;
    var name = $('#card_name').val();
    // var email = $('#email').val();
    var cardNumber = $('#card_no').val();
    var month = $('#month').val();
    var year = $('#year').val();
    var cvc = $('#cvc').val();

    $("#error-message").html("").hide();

    if (name.trim() == "") {
        valid = false;
    }
    // if (email.trim() == "") {
    //     valid = false;
    // }
    if (cardNumber.trim() == "") {
        valid = false;
    }

    if (month.trim() == "") {
        valid = false;
    }
    if (year.trim() == "") {
        valid = false;
    }
    if (cvc.trim() == "") {
        valid = false;
    }

    if (valid == false) {
        // $("#error-message").html("All Fields are required").show();
        setAlert('danger', 'All fields are required.');
    }

    return valid;
}
//set your publishable key
Stripe.setPublishableKey(pk);

//callback to handle the response from stripe
function stripeResponseHandler(status, response) {
    // $('#frmStripePayment .submit').removeAttr('disabled');
    if (response.error) {
        //enable the submit button
        // $("#submit-btn").show();
        // $("#loader").css("display", "none");
        //display the errors on the form
        setAlert('danger', response.error.message);
        // $("#error-message").html(response.error.message).show();
       // return false;
    } else {
        //get token id
        var token = response['id'];
        //insert the token into the form
        $("#payment").append("<input type='hidden' name='token' value='" + token + "' />");
        //submit form to the server
        // $('#frmStripePayment .submit').removeAttr('disabled');
        // alert($('#payment #cvc').val());
        // $("form#payment").submit();
        $('#submit').trigger('click');
    }
}

function stripePay() {
    // e.preventDefault();
    var valid = cardValidation();
    
    if (valid == true) {
        $('.overlay').show();
        // $("#submit-btn").hide();
        // $("#loader").css("display", "inline-block");
        // $('#payment .submit').attr('disabled', 'disabled');
        Stripe.createToken({
            number: $('#card_no').val().trim(),
            cvc: $('#cvc').val().trim(),
            exp_month: $('#month').val().trim(),
            exp_year: $('#year').val().trim(),
            name: $('#card_name').val(),
            address_line1: 'kolkata',
            address_city: 'San Francisco',
            address_state: 'CA',
            address_zip: '98140',
            address_country: 'US'
        }, stripeResponseHandler);
        //submit from callback
        return false;
    }
    // return false;
}