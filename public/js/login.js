$(function () {

    $('#form').submit(function () {
        var requiredContent = $('.requiredContent').val()

        if(validateRequired(requiredContent)) {
            return true
        } else {
            return false
        }
    })
})

