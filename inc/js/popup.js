
function open_popup(url){
        $("body").append("        <div class=\"popup\" style=\"display:block\"><div class=\"popup-background\"><button type=\"button\" class=\"btn btn-default popup-close\"><i class=\"fa fa-window-close\"></i></button><div class=\"popup-outer\"><div class=\"popup-content\"></div></div></div></div>");
        var a = $("div.popup");
        a.fadeIn(300);
        get_data(url,a);


    a.find(".popup-background button.btn").bind("click",function () {
        close_popup(a)
    });



    }

    function get_data(url,b){

        $.ajax({
            method:"GET",
            url: url,
            crossDomains:true,
            beforeSend:function () {
                b.find(".popup-content").html("<div class=\"popup-loader\" ></div>");
            },
            success: function (data) {
                b.find(".popup-content").html(data);
            },
            error:function () {
                b.find(".popup-content").html('<div class="alert alert-danger text-center">An Error Occured.Please Contact Administrator.</div>');
            }
        });

    }



function close_popup(b,c){
    b.fadeOut(300);
    b.remove();
    if(c===true){
        location.reload();
    }

    }

function disableScrolling(){
    var x=window.scrollX;
    var y=window.scrollY;
    window.onscroll=function(){window.scrollTo(x, y);};
}

function enableScrolling(){
    window.onscroll=function(){};
}
