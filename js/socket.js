/**
 * Created by sbrilenko on 7/1/15.
 */

if (!window.WebSocket) {
    //window.location.reload();
    } else {
    //create a new WebSocket object.
    var wsUri = "ws://"+document.location.hostname+":1600";
//            var wsUri = "ws://0.0.0.0:1500";
    websocket = new WebSocket(wsUri);

    // ----------------------------------------------------
    websocket.onopen = function(ev) { // connection is open
    var msg = {
    type: 'system.init_user_online',
    from_user_id: authorizateduserid
    };
console.log(msg);
try{ websocket.send(JSON.stringify(msg));console.log('send')}
catch(ex){
    console.log(ex.data);
    return false}
};
//Connection close
websocket.onclose = function(ev) {

    console.log('Disconnected',ev)
    };

//Message Receved
websocket.onmessage = function(ev) {
    console.log('Message ',ev)
    var msg = JSON.parse(ev.data); //PHP sends Json data
    console.log(msg)
    var type = msg.type; //message type
    switch (type) {
    case 'system.message':
        if(msg.to==authorizateduserid)
        {
            if(!msg.error)
            {
            //if page not messages
                $('.top-menu .messages-icon').next().text(msg.count).show();
            }
        }
        else
        if(msg.from==authorizateduserid)
                                {
                                    if(!msg.error)
                                    {
        //                            <?php if(Yii::app()->controller->id=="site" && Yii::app()->controller->action->id=="messages") { ?>
                                    var mess="";
                                    mess+='<table style="padding-right: 20px;"><tbody><tr><td class="padding-zero wall-avatar-td">&nbsp;</td>';
                                    mess+='<td class="padding-zero">';
                                    mess+='<div class="message-buble">';
                                    mess+='<div class="message-buble-triangle-back"></div>';
                                    mess+='<div class="comment-owner f-l">'+msg.from_name+'</div><div class="f-r">'+msg.date+'</div>';
                                    mess+='<div class="clear"></div>';
                                    mess+='<div class="comment">'+msg.message+'</div>';
                                    mess+='</div></td></tr></tbody></table>';
                                    $('.dialog-messages').append(mess);
                                    setTimeout(function(){$(".nano").nanoScroller();$(".nano").nanoScroller({ scroll: 'bottom' });}, 100);
                                    //clear the form
                                    $('#newmessage-send-form input[name*=message]').val('');
                                    //<?php } ?>
                                    }
                                }
        break;
        case 'system.quickmessage':
            if(msg.to==authorizateduserid)
                                {
                                    if(!msg.error)
                                    {
                                        //if page not messages
                                        $('.top-menu .messages-icon').next().text(msg.count).show();
                                        $('.get-message').each(function()
                                            {
                                                var form=$(this).find('form');
                                                if(form.find('input[name*=from_user_id]').val()==msg.from || form.find('input[name*=to_user_id]').val()==msg.from)
                                                {

                                                $('.message-block-user-time',this).text(msg.date)
                                                $('.message-block-user-message',this).text(msg.message)
                                                $('.message-new-message').text(msg.count).show()
                                                }
                                        })
                                    }
                            }
            else
            if(msg.from==authorizateduserid)
                        {
                            if(!msg.error)
                            {
//                            <?php if(Yii::app()->controller->id=="site" && Yii::app()->controller->action->id=="messages") { ?>
                            //clear quickmessage form
                            $('#message-to-user input[name=to_user],#message-to-user textarea,#message-to-user input[name=user]').val('');
                            $('.quick-message-user-icon').empty();
                            $('.get-message').each(function()
                            {
                            var form=$(this).find('form');
                            if((form.find('input[name*=from_user_id]').val()==msg.from && form.find('input[name*=to_user_id]').val()==msg.to) ||
                            (form.find('input[name*=from_user_id]').val()==msg.to && form.find('input[name*=to_user_id]').val()==msg.from))
                            {
                            $('.message-block-user-time',this).text(msg.date);
                            $('.message-block-user-message',this).text(msg.message);

                            if ($('.dialog-messages').attr('id') === msg.to ) {
                            var mess = '';
                            mess += '<table style="padding-right: 30px; margin-top:25px; margin-bottom:25px;">';
                            mess += '<tbody>';
                            mess += '<tr><td class="padding-zero wall-avatar-td">&nbsp;</td>';
                            mess += '<td class="padding-zero" style="padding-left: 10%;">';
                            mess += '<div class="message-buble">';
                            mess += '<div class="message-buble-triangle-back"></div>';
                            mess += '<div class="comment-owner f-l" style="font-size: 16px; font-weight: 500;">' + $('.avatar-name-style').text() + '</div>';
                            mess += '<div class="f-r" style="color: #959595; font-size: 12px;">' + msg.date + '</div>';
                            mess += '<div class="clear"></div>';
                            mess += '<div class="comment">' + msg.message + '</div>';
                            mess += '</div></td></tr>';
                            mess += '</tbody>';
                            mess += '</table>';

                            $('.dialog-messages').append(mess);

                            setTimeout(function(){$(".nano").nanoScroller();$(".nano").nanoScroller({ scroll: 'bottom' });}, 100);
                            }
                            }
                            })
                            //<?php } ?>
        }
        }
        break;
        case 'system.friendmessage':
        if(msg.send_to == authorizateduserid) {
        // if(!msg.error) {
        //<?php if(Yii::app()->controller->id=="site" && Yii::app()->controller->action->id=="messages") { ?>

                if ($('.dialog-messages').attr('id') == msg.from) {
                $('.dialog-messages').append(msg.html);
                setTimeout(function(){$(".nano").nanoScroller();$(".nano").nanoScroller({ scroll: 'bottom' });}, 100);
        }
        $('.get-message').each(function() {
            var form=$(this).find('form');
            if((form.find('input[name*=from_user_id]').val()==msg.from && form.find('input[name*=to_user_id]').val()==msg.send_to) ||
            (form.find('input[name*=from_user_id]').val()==msg.send_to && form.find('input[name*=to_user_id]').val()==msg.from)) {

            $('.message-block-user-time',this).text(msg.date);
            if (msg.text == '') {
            $('.message-block-user-message',this).text("Image file");
            } else {
            $('.message-block-user-message',this).text(msg.text);
            }
        }
        })
        //<?php } ?>
        // }
        }
        break;
}
};

//Error
websocket.onerror = function(ev) {
    console.log('Error ',ev)
    };
}
$(document).ready(function()
        {
            $(document).on('click','.tri',function()
            {

            }).on('click',function(el)
            {
                $(el.target).hasClass("triangle")?$('.triangle-menu').is(":visible")?$('.triangle-menu').removeAttr("style"):$('.triangle-menu').show():$('.triangle-menu').removeAttr("style");
                }).on('keydown',function(el)
            {
                if(el.keyCode==27)
                {
                $('.triangle-menu').removeAttr("style");
                }
})
$('.left-columb-icon').parent().on('click',function()
                {
                    if(!$(".left-block").hasClass("close") && !$(".left-block").is(":animated"))
                    {
                    $(".left-block").animate({width:0,maxWidth:0,minWidth:0},500,function(){$(".left-block").addClass("close");})
}
else
                    {
                        $(".left-block").show().animate({width:314,maxWidth:314,minWidth:314},500,function(){$(".left-block").removeClass("close")})
}
})
})
