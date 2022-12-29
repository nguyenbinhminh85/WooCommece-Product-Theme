jQuery(document).ready(function($){

    $(".add_more_icon").on("click", function(e){

        e.preventDefault();
        $(".icon-media-standard").clone(true).removeClass("icon-media-standard").addClass("icon-media").css({"display":"block"}).prependTo(".add_social_media_section");

    });


    $(".add_social_media_section").on("click", ".delete_media_icon div", function(e){

        e.preventDefault();
        $(this).parent().parent().remove();

    });

    $(".save_icon_data").on("click" , function(e){

        e.preventDefault();
        let data_field = [];

        $(".add_social_media_section").find(".icon-media").each(function(){

            let icon = $(this).find(".icon").val();
            let icon_color = $(this).find(".icon_color").val();
            let icon_url = $(this).find(".icon_url").val();
          
            // if(!icon || !title || !content){
            //     alert("Please fill up the Field!");
            //     return false;
            // }

            let item = {
                icon: icon,
                icon_color: icon_color,
                icon_url: icon_url,
            };

            data_field.push(item);

        });
        
        sendAjax(data_field);

    });

    function sendAjax(data){
        
        let ajax_url = add_social.ajaxurl;
        let nonce    = $("#add_social_media_nonce_name").val();

        let transfer_data = {
            action: "add_social_media",
            nonce: nonce,
            values: data,
        }

        $.ajax({
            method: "POST",
            url: ajax_url,
            data: transfer_data,
        }).done(res => {
            if(res){
                $("#social_icon_output_value").val(res);
                $("#social_icon_output_value").change();
            }
        })
    }


});