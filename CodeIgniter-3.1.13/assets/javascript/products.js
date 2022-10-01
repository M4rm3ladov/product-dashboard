function swapClass($obj, beforeClass, afterClass) {
    $obj.removeClass(beforeClass);
    $obj.addClass(afterClass);
}

function hasPresence($obj) {
    return $obj.val() !== "" && $obj.val() !== null;
}

function fail($obj) {
    swapClass($obj, 'pass', 'fail');
}

function success($obj) {
    swapClass($obj, 'fail', 'success');
}

$(document).ready(function() {
    $('#name, #description, #price, #count').focusout(function(){
        hasPresence($(this)) ? success($(this)) : fail($(this));
    });
});
