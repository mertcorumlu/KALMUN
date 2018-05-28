function logout(){

    $.ajax({
        url:"/inc/ajax/logout",
        type:"post",
        success :function () {
            location.reload();
        }
    });

}

$("button.delete-button").on("click",function () {

   if( $(this).data("id") !== "" && $(this).data("type") !== ""){

       if(!confirm("Are you sure you want to delete this " + $(this).data("type") + "?" )){
           return;
       }
       $.ajax({
           method:"GET",
           url:"/inc/ajax/delete",
           data:{
               "type": $(this).data("type"),
               "id" : $(this).data("id")
           },
           error:function () {
               alert("An Error Occured.Please Contact Administrator.");
           },
           success:function (data) {

               if(data !== "" ){
                   alert(data.message);
                   window.location.reload();
               }

           }

       });

   }



});