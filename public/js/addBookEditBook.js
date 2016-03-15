$(function () {

    $('.yearContent').keyup(function (){
        $('#errYear').remove()
        var yearContent = $('.yearContent').val()
        validateYear(yearContent)
    })

    $('.yearContent').blur(function (){
        if(!$('.yearContent').val() == 4 || $('.yearContent').val() == 0 ) {
            $('#errYear').remove()
        }
    })

    $('#form').submit(function () {
        $('.err').remove()
        var requiredContent = $('.requiredContent').val()
        var requiredTitle = $('.required-title').val()
        var requiredAuthor = $('.required-author').val()
        var category = $('.required-category').val()
        var description = $('.required-description').val()
        var publisher = $('.required-publisher').val()
        var stockContent = $('.stockContent').val()
        var costPrice = $('.required-cost-price').val()
        var sellPrice = $('.required-sell-price').val()
        var yearContent = $('.yearContent').val()
        var notes = $('.required-notes').val()

        if(validateTitle(requiredTitle) &&
            validateAuthor(requiredAuthor) &&
            validateCategory(category) &&
            validateDescription(description) &&
            validatePublisher(publisher) &&
            validateCostPrice(costPrice) &&
            validateSellPrice(sellPrice) &&
            validateStockLevel(stockContent)) {
            return true
        } else {
            return false
        }
    })
})
