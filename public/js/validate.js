/**
 * validates the required content field
 * @param   string  required     content provided by the user
 * @return  bool                 true if valid characters
 */
function validateCharacters(required) {
    var requiredField = /[a-zA-Z0-9\.\'\s\-\!\@\£\$\%\&()\/\,]+/;
    if (!requiredField.test(required)) {
        return false
    } else {
        return true
    }
}

/**
 * validates the title content field
 * @param   string  title        title provided by the user
 * @return  bool                 true if valid postcode
 */
function validateTitle(title) {
    var requiredTitle = /^[a-zA-Z0-9\.\'\s\-\!\@\£\$\%\&()\/\,]{0,300}$/;
    if (!requiredTitle.test(title)) {
        $('.required-title').after(
            '<div class="err" id="errTitle">' +
            'Valid Characters Only/Max 300 Characters' +
            '</div>');
        $('#errTitle').slideDown('slow');
        return false
    } else {
        return true
    }
}

/**
 * validates the author content field
 * @param   string  author        author provided by the user
 * @return  bool                 true if valid author
 */
function validateAuthor(author) {
    var requiredAuthor = /^[a-zA-Z0-9\.\'\s\-\!\@\£\$\%\&()\/\,]{0,300}$/;
    if (!requiredAuthor.test(author)) {
        $('.required-author').after(
            '<div class="err" id="errAuthor">' +
            'Valid Characters Only/Max 300 Characters' +
            '</div>');
        $('#errAuthor').slideDown('slow');
        return false
    } else {
        return true
    }
}

/**
 * validates the required content field
 * @param   string  category     content provided by the user
 * @return  bool                 true if valid category
 */
function validateCategory(category) {
    var requiredCategory = /[0-9]{0,50}$/;
    if (!requiredCategory.test(category)) {
        $('.required-category').after(
            '<div class="err" id="errCategory">' +
            'Valid Characters Only/Max 300 Characters' +
            '</div>');
        $('#errCategory').slideDown('slow');
        return false
    } else {
        return true
    }
}

/**
 * validates the required content field
 * @param   string  description    description provided by the user
 * @return  bool                   true if valid description
 */
function validateDescription(description) {
    var requiredDescription = /[a-zA-Z0-9\.\'\s\-\!\@\£\$\%\&()\/\,]{0,1000}$/;
    if (!requiredDescription.test(description)) {
        $('.required-description').after(
            '<div class="err" id="errDescription">' +
            'Valid Characters Only/Max 1000 Characters' +
            '</div>');
        $('#errDescription').slideDown('slow');
        return false
    } else {
        return true
    }
}

/**
 * validates the publisher content field
 * @param   string  publisher      publisher provided by the user
 * @return  bool                   true if valid publisher
 */
function validatePublisher(publisher) {
    var requiredPublisher = /^[a-zA-Z0-9\.\'\s\-\!\@\£\$\%\&()\/\,]{0,50}$/;
    if (!requiredPublisher.test(publisher)) {
        $('.required-publisher').after(
            '<div class="err" id="errPublisher">' +
            'Valid Characters Only/Max 50 Characters' +
            '</div>');
        $('#errPublisher').slideDown('slow');
        return false
    } else {
        return true
    }
}

/**
 * validates the required cost price field
 * @param   string  cost price   cost price provided by the user
 * @return  bool                 true if valid cost price
 */
function validateCostPrice(costPrice) {
    var requiredCostPrice = /^[0-9\.]{1,6}$/;
    if (!requiredCostPrice.test(costPrice)) {
        $('.required-cost-price').after(
            '<div class="err" id="errCostPrice">' +
            'Valid Price Only' +
            '</div>');
        $('#errCostPrice').slideDown('slow');
        return false
    } else {
        return true
    }
}

/**
 * validates the required sell price field
 * @param   string  sell price   sell price provided by the user
 * @return  bool                 true if valid sell price
 */
function validateSellPrice(sellPrice) {
    var requiredSellPrice = /^[0-9\.]{1,6}$/;
    if (!requiredSellPrice.test(sellPrice)) {
        $('.required-sell-price').after(
            '<div class="err" id="errSellPrice">' +
            'Valid Price Only' +
            '</div>');
        $('#errSellPrice').slideDown('slow');
        return false
    } else {
        return true
    }
}

/**
 * validates the notes content field
 * @param   string  notes        notes provided by the user
 * @return  bool                 true if valid notes
 */
function validateNotes(notes) {
    var requiredNotes = /^[a-zA-Z0-9\.\'\s\-\!\@\£\$\%\&()\/\,]{0,1000}$/;
    if (!requiredNotes.test(notes)) {
        $('.required-notes').after(
            '<div class="err" id="errNotes">' +
            'Valid Characters Only/Max 1000 Characters' +
            '</div>');
        $('#errNotes').slideDown('slow');
        return false
    } else {
        return true
    }
}

/**
 * validates the email content field
 * @param   string  email        content provided by the user
 * @return  bool                 true if valid email
 */
function validateEmail(email) {
    //please note: email regex from http://emailregex.com/
    var requiredEmail = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/;
    if (!requiredEmail.test(email)) {
        $('.required-email').after(
            '<div class="err" id="errEmail">' +
            'Valid Email Only' +
            '</div>');
        $('#errEmail').slideDown('slow');
        return false
    } else {
        return true
    }
}

/**
 * validates the postcode content field
 * @param   string  postcode     content provided by the user
 * @return  bool                 true if valid postcode
 */
function validatePostcode(postcode) {
    //please note: email regex from https://gist.github.com/simonwhitaker/5748487
    var requiredPostcode = /[A-Z]{1,2}[0-9][0-9A-Z]?\s?[0-9][A-Z]{2}/gi;
    if (!requiredPostcode.test(postcode)) {
        $('.required-postcode').after(
            '<div class="err" id="errPostcode">' +
            'Valid Postcode Only' +
            '</div>');
        $('#errPostcode').slideDown('slow');
        return false
    } else {
        return true
    }
}

/**
 * validates the card number content field
 * @param   string  cardNumber     card Number provided by the user
 * @return  bool                   true if valid card number
 */
function validateCardNumber(cardNumber) {
    var requiredCardNumber = /^([0-9]){16}$/;
    if (!requiredCardNumber.test(cardNumber)) {
        $('.required-card-number').after(
            '<div class="err" id="errCardNumber">' +
            'Valid Card Number Only' +
            '</div>');
        $('#errCardNumber').slideDown('slow');
        return false
    } else {
        return true
    }
}

/**
 * validates the cvs number content field
 * @param   string  cvsNumber      cvs Number provided by the user
 * @return  bool                   true if valid cvs number
 */
function validateCvsNumber(cvsNumber) {
    var requiredCvsNumber = /^([0-9]){3}$/;
    if (!requiredCvsNumber.test(cvsNumber)) {
        $('.required-cvs-number').after(
            '<div class="err" id="errCvsNumber">' +
            'Valid CVS Number Only' +
            '</div>');
        $('#errCvsNumber').slideDown('slow');
        return false
    } else {
        return true
    }
}

/**
 * validates the cvs number content field
 * @param   string  cvsNumber      cvs Number provided by the user
 * @return  bool                   true if valid cvs number
 */
function validateExpiryMonth(month) {
    var requiredExpiryMonth = /^([0-9]){1}$|^([0-9]){2}$/;
    if (!requiredExpiryMonth.test(month)) {
        $('.required-expiry-month').after(
            '<div class="err" id="errExpiryMonth">' +
            'Valid Month Number Only' +
            '</div>');
        $('#errExpiryMonth').slideDown('slow');
        return false
    } else {
        return true
    }
}


/**
 * validates the required year format
 * @param  string  year      year provided by the user
 * @return         bool      true if valid year
 */
function validateYear(year) {
    var yearFormat = /^\d{4}$/;
    if (!yearFormat.test(year) || year.length == 0) {
        $('.yearContent').after(
            '<div class="err" id="errYear">' +
            'Valid Year Required' +
            '</div>');
        $('#errYear').slideDown('slow');
        return false
    } else {
        return true
    }
}

/**
 * turns validation on when optional address fields are used
 */
function toggleValidationOn() {
    $('#addressBanking').addClass("requiredContent")
    $('#cityBanking').addClass("requiredContent")
    $('#postcodeBanking').addClass("required-postcode")
}

/**
 * turns validation off when optional address fields are not being used
 */
function toggleValidationOff() {
    $('#addressBanking').removeClass("requiredContent")
    $('#cityBanking').removeClass("requiredContent")
    $('#postcodeBanking').removeClass("required-postcode")
}

/**
 * validates the required stock level format
 * @param   int  stockContent    stock level provided by the user
 * @return  bool                 true if valid stock level
 */
function validateStockLevel(stockContent) {
    var stockLevel = /^[0-9]{1,3}$/;
    if (!stockLevel.test(stockContent)) {
        $('.stockContent').after(
            '<div class="err" id="errStock">' +
            'Valid Number between 0-999' +
            '</div>');
        $('#errStock').slideDown('slow');
        return false
    } else {
        return true
    }
}

/**
 * validates backoffice login form
 * @param    string   required    name provided by the user
 * @return   bool                 false if required length is 0 or greater than 100, or if validateCharacters fail.
 */
function validateRequired(required) {
    var result = true
    $('.err').remove()
    if (required.length == 0) {
        $('.requiredContent').after(
            '<div class="err" id="err1">' +
            'Required field' +
            '</div>');
        $('#err1').slideDown('slow');
        result = false
    }

    if (required.length > 100) {
        $('.requiredContent').after(
            '<div class="err" id="err3">' +
            'Max length is 100' +
            '</div>');
        $('#err3').slideDown('slow');
        result = false
    }
    if (required.length > 0 && !validateCharacters(required)) {
        $('.requiredContent').after(
            '<div class="err" id="err4">' +
            'Letters, fullstops and _ only' +
            '</div>');
        $('#err4').slideDown('slow');
        result = false
    }

    return result
}