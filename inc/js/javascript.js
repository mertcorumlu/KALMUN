function logout(){

    $.ajax({
        url:"/inc/ajax/logout",
        type:"post",
        success :function () {
            location.reload();
        }
    });

}