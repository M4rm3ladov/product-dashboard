$(document).ready(function(){
    $("#modal-remove").hide();

    $("input.remove").click(function(){
        $("#product-name").text($(this).attr("data-name") + "?");
        $("form").attr("action", "/products/remove/" + $(this).attr("data-id"));
        $("#modal-remove").show();
    });

    $("input.cancel").click(function(){
        $("#modal-remove").hide();
    })

    $("span.close").click(function(){
        $("#modal-remove").hide();
    })

    $("#modal-remove").click(function(e){
        if(e.target !== this) return;
        $(this).hide();
    });
});