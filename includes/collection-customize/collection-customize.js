jQuery(document).ready(function($){

    $(".collection-section-front-page").on("click", ".field_button_add", function(e){
           e.preventDefault();

           let image_id = $(this).parent().find(".image-id");
           let image = $(this).parent().find(".image img");
           let image_box = $(this).parent().find(".image");
           let field_button_add = $(this).parent().find(".field_button_add");
           let field_button_remove = $(this).parent().find(".field_button_remove");

           var frame;

           if(frame){
                frame.open()
                return;
           };

           frame = wp.media({
                title: "Select a Image for your Collection Field",
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
                field_button_add.hide();
                field_button_remove.show()
           });

           frame.open();
    });

    $(".collection-section-front-page").on("click", ".field_button_remove", function(e){
        e.preventDefault();

        let image_id = $(this).parent().find(".image-id");
        let image = $(this).parent().find(".image img");
        let image_box = $(this).parent().find(".image");
        let field_button_add = $(this).parent().find(".field_button_add");
        let field_button_remove = $(this).parent().find(".field_button_remove");

        image_id.val("");

        image.attr({src: ""});
        image_box.hide();
        field_button_add.show();
        field_button_remove.hide()

    });  
    
    
    $(".add_more_field").on("click", function(e){
        e.preventDefault();
        $(".collection-default-item").clone(true).removeClass("collection-default-item").addClass("collection-item").prependTo(".collection-section-front-page").show();
    });


    $(".collection-section-front-page").on("click", ".delete-collection-item", function(e){
        e.preventDefault();
        $(this).parent().remove();
    });


    $(".save_data_field").on("click" , function(e){
            e.preventDefault();
            let data_field = [];
            $(".collection-section-front-page").find(".collection-item").each(function(){
                let Title = $(this).find(".field-title").val();
                let Text = $(this).find(".field-text").val();
                let Slug = $(this).find(".field-slug").val();
                let Image_Id = $(this).find(".image-id").val();

                if(!Title || !Text || !Slug || !Image_Id){
                    alert("Please fill up the Field!");
                    return false;
                }

                let item = {
                    title: Title,
                    text: Text,
                    slug: Slug,
                    image_id: Image_Id,
                };

                data_field.push(item);

            });

            sendAjax(data_field);
    });

    function sendAjax(data){
        
        let ajax_url = add_collection.ajaxurl;
        let nonce    = $("#collection_front_page_nonce_name").val();

        let transfer_data = {
            action: "setting_collection_front_page",
            nonce: nonce,
            values: data,
        }

        $.ajax({
            method: "POST",
            url: ajax_url,
            data: transfer_data,
        }).done(res => {
            if(res){
                $("#collection_front_page_value").val(res);
                $("#collection_front_page_value").change();
            }
        })
    }

});