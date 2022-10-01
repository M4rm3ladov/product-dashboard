function validateEmail($obj) {
    var regEx = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return regEx.test($obj.val());
}

function swapClass($obj, beforeClass, afterClass) {
    $obj.removeClass(beforeClass);
    $obj.addClass(afterClass);
}

function passwordsMatch($obj) {
    return $obj.val() == $('#password').val() || $obj.val() == $('#new-password').val();
}

function hasPresence($obj) {
    return $obj.val() !== "" && $obj.val() !== null;
}

function meetsLengthRequirements($obj, minLength) {
    return $obj.val().length > minLength;
}

function fail($obj) {
    swapClass($obj, 'pass', 'fail');
}

function success($obj) {
    swapClass($obj, 'fail', 'success');
}

$(document).ready(function() {
    $('#first-name, #last-name').focusout(function(){
        hasPresence($(this)) ? success($(this)) : fail($(this));
    });

    $('#email').focusout(function(){
        validateEmail($(this)) ? success($(this)) : fail($(this));
    });

    $('#password').focusout(function(){
        meetsLengthRequirements($(this), 7) ? success($(this)) : fail($(this));
    });

    $('#confirm-password').focusout(function(){
        passwordsMatch($(this)) ? success($(this)) : fail($(this));
    });
    
    $('#old-password').focusout(function(){
        hasPresence($(this)) ? success($(this)) : fail($(this));
    });

    $('#new-password').focusout(function(){
        meetsLengthRequirements($(this), 7) ? success($(this)) : fail($(this));
    });
});
