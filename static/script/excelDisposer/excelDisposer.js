

    $('#uploadFile').on('click',function(){
        alert();
        $upload_excel = $('#myfile');
        //创建FormData对象
        var formData = new FormData($('#myform')[0]);
        $.ajax({
            url:"?c=excelDisposer&a=getFile" ,
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false, //不可缺
            processData: false, //不可缺
            success: function(data) {

            }

        });
    });


