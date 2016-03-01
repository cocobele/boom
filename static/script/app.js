

    /*
     send form data via ajax and return the data to callback function
     */
    function send_form( name , func )
    {
        var url = $('#'+name).attr('action');

        var params = {};
        $.each( $('#'+name).serializeArray(), function(index,value)
        {
            params[value.name] = value.value;
        });

        $.post( url , params , func );
    }


    /*
     提交注册成员
     */
    function send_form_in( name )
    {
        return send_form( name , function( data ){ refresh_form( name , data ) } );
    }
    /*
     处理各类报销有关表单
     */
    function   send_account(name){
        return send_form(name,function(data){
                alert(data);
            }

        )
    }
    /*
     更新成员列表
     */
    function refresh_form(name,data){
        if(name=="register"){
            if(data){
                $('#user_list').html(data);

                dragit();
            }
        }

    }
    /*
     批次提交报名成员
     */
  function  send_bill(name){
      var url = $('#'+name).attr('action');
      var a = [];
      $('summary').each(function(){
          a.push($(this).text());
      })
       var str=JSON.stringify(a);
      var params={};
      params['list']=str;
      $.post( url ,params , function(data){
        alert(data);
          $('#dropzone').html('');
      } );
  }




    $(document).ready(dragit);

    /*
     绑定拖拽方法
     */
    function dragit(){

        $('.drag').draggable({
            appendTo: 'body',
            helper: 'clone'
        });

        $('#dropzone').droppable({
            activeClass: 'active',
            hoverClass: 'hover',
            drop:  function(e,ui){
                var $el = $('<div class="drop-item"><details><summary>' + ui.draggable.text() + '</summary><div><label>备注</label><input type="text" /></div></details></div>');
                $el.append($('<button type="button" class="btn btn-default btn-xs remove"><span>删除 </span> </button>').click(function () { $(this).parent().detach(); }));
                $(this).append($el);
            }
        });

    }



    /*
     send form data via ajax and show the return content to pop div
     */
/*

    function send_form_pop( name )
    {
        return send_form( name , function( data ){ show_pop_box( data ); } );
    }



    function set_form_notice( name , data )
    {
        data = '<span class="label label-important">' + data + '</span>';

        if( $('#form_'+name+'_notice').length != 0 )
        {
            $('#form_'+name+'_notice').html(data);
        }
        else
        {
            var odiv = $( "<div class='form_notice'></div>" );
            odiv.attr( 'id' , 'form_'+name+'_notice' );
            odiv.html(data);
            $('#'+name).prepend( odiv );
        }

    }


    function show_pop_box( data , popid )
    {
        if( popid == undefined ) popid = 'lp_pop_box'
        //console.log($('#' + popid) );
        if( $('#' + popid).length == 0 )
        {
            var did = $('<div><div id="' + 'lp_pop_container' + '"></div></div>');
            did.attr( 'id' , popid );
            did.css( 'display','none' );
            $('body').prepend(did);
        }

        if( data != '' )
            $('#lp_pop_container').html(data);

        var left = ($(window).width() - $('#' + popid ).width())/2;

        $('#' + popid ).css('left',left);
        $('#' + popid ).css('display','block');
    }

    function hide_pop_box( popid )
    {
        if( popid == undefined ) popid = 'lp_pop_box'
        $('#' + popid ).css('display','none');
    }
*/



    /* post demo
     $.post( 'url&get var'  , { 'post':'value'} , function( data )
     {
     var data_obj = jQuery.parseJSON( data );
     console.log( data_obj  );

     if( data_obj.err_code == 0  )
     {

     }
     else
     {

     }
     } );

     */

