/**
 * 单例模式
 */
$(function() {
    var page = {
        init : function(){
            this.bindEvent(); 

        },


        bindEvent : function(){
    
        },/* ending for page.bindEvent */

        ajax:{
            //确认提现密码
            checkPass:function(){
        
                $.ajax({
                    url:"",
                    type: "post",
                    dataType: "json",
                    data: {
                        
                    },
                    success: function(data){
                    }

                });
            }
        }
page.init();
})