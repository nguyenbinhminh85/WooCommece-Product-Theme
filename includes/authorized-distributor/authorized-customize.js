jQuery(document).ready(function($){

    $(".authorized-section-front-page").on("click", ".authorized_button_add", function(e){
        e.preventDefault();

        let image_id = $(this).parent().find(".image-id");
        let image = $(this).parent().find(".image img");
        let image_box = $(this).parent().find(".image");
        let authorized_button_add = $(this).parent().find(".authorized_button_add");
        let authorized_button_remove = $(this).parent().find(".authorized_button_remove");

        var frame;

        if(frame){
             frame.open()
             return;
        };

        frame = wp.media({
             title: "Select a Image for your Authorized distributor",
             button:{
                 text: 'Add a Image',
             },
             multiple: false
        });

        frame.on('select', function(){
             var attachment = frame.state().get('selection').first().toJSON();
             image_id.val(attachment.id);

             image.attr({src: attachment.url});
             image_box.show();
             authorized_button_add.hide();
             authorized_button_remove.show()
        });

        frame.open();
    });

    $(".authorized-section-front-page").on("click", ".authorized_button_remove", function(e){
        e.preventDefault();

        let image_id = $(this).parent().find(".image-id");
        let image = $(this).parent().find(".image img");
        let image_box = $(this).parent().find(".image");
        let authorized_button_add = $(this).parent().find(".authorized_button_add");
        let authorized_button_remove = $(this).parent().find(".authorized_button_remove");

        image_id.val("");

        image.attr({src: ""});
        image_box.hide();
        authorized_button_add.show();
        authorized_button_remove.hide()

    }); 
    
    
    $(".add_more_authorized").on("click", function(e){
        e.preventDefault();
        $(".authorized-default-item").clone(true).removeClass("authorized-default-item").addClass("authorized-item").prependTo(".authorized-section-front-page").show();
    });


    $(".authorized-section-front-page").on("click", ".delete-authorized-item", function(e){
        e.preventDefault();
        $(this).parent().remove();
    });


    $(".save_data_authorized").on("click" , function(e){
        e.preventDefault();
        let data_field = [];
        $(".authorized-section-front-page").find(".authorized-item").each(function(){
    
            let Image_Id = $(this).find(".image-id").val();

            if(!Image_Id){
                alert("Please select an Image!");
                return false;
            }

            let item = {
                image_id: Image_Id,
            };

            data_field.push(item);

        });

        sendAjax(data_field);
    });

    function sendAjax(data){
        
        let ajax_url = add_authorized.ajaxurl;
        let nonce    = $("#authorized_front_page_nonce_name").val();

        let transfer_data = {
            action: "adding_authorized_on_front_page",
            nonce: nonce,
            values: data,
        }

        $.ajax({
            method: "POST",
            url: ajax_url,
            data: transfer_data,
        }).done(res => {
            if(res){
                $("#authorized_front_page_value").val(res);
                $("#authorized_front_page_value").change();
            }
        })
    }

    

});