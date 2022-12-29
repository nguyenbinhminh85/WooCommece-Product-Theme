jQuery(document).ready(function($){

    $(".add_more_service").on("click", function(e){

        e.preventDefault();
        $(".about-card-standard").clone(true).removeClass("about-card-standard").addClass("about-card").css({"display":"block"}).prependTo(".service-section-front-page");

    });


    $(".service-section-front-page").on("click", ".delete-about-card div", function(e){

        e.preventDefault();
        $(this).parent().parent().remove();

    });

    $(".save_data_service").on("click" , function(e){

        e.preventDefault();
        let data_field = [];

        $(".service-section-front-page").find(".about-card").each(function(){

            let icon = $(this).find(".card_icon").val();
            let title = $(this).find(".card_title").val();
            let content = $(this).find(".card_content").val();
          
            // if(!icon || !title || !content){
            //     alert("Please fill up the Field!");
            //     return false;
            // }

            let item = {
                icon: icon,
                title: title,
                content: content,
            };

            data_field.push(item);

        });

        sendAjax(data_field);

    });

    function sendAjax(data){
        
        let ajax_url = add_service.ajaxurl;
        let nonce    = $("#service_front_page_nonce_name").val();

        let transfer_data = {
            action: "setting_service_provide_front_page",
            nonce: nonce,
            values: data,
        }

        $.ajax({
            method: "POST",
            url: ajax_url,
            data: transfer_data,
        }).done(res => {
            if(res){
                $("#service_front_page_value").val(res);
                $("#service_front_page_value").change();
            }
        })
    }


});