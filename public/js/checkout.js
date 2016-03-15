$(function () {

    $('.different-billing-button').click(function () {
        $('.different-billing').toggle();
        toggleValidationOn()
        if($('.different-billing').css("display") == "none"){
            toggleValidationOff()
        }
    })

    $('form').submit(function () {
        var requiredContent = $('.requiredContent').val()
        var requiredCharacters = $('.requiredCharacters').val()
        var requiredEmail = $('.required-email').val()
        var requiredPostcode = $('.required-postcode').val()
        var requiredCardNumber = $('.required-card-number').val()
        var requiredCvsNumber = $('.required-cvs-number').val()
        var requiredExpiryMonth = $('.required-expiry-month').val()
        var requiredExpiryYear = $('.yearContent').val()

        if( validateRequired(requiredContent) &&
            validateCharacters(requiredCharacters) &&
            validateEmail(requiredEmail) &&
            validatePostcode(requiredPostcode) &&
            validateCardNumber(requiredCardNumber) &&
            validateCvsNumber(requiredCvsNumber) &&
            validateExpiryMonth(requiredExpiryMonth) &&
            validateYear(requiredExpiryYear)) {
            return true
        } else {
            return false
        }
    })
})
