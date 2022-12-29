jQuery(document).ready(function($){

    let errors = [];
    
    $("#add_to_cart").on("submit",function(e){
        e.preventDefault();

        $(".add_to_cart_notices").html('');
        $(".add_to_cart_notices").hide();
        
        let product_q = $(".product-quantity").val();
        let product_id = $(".product-id").val();
        let product_nonce = $("#add_single_product_nonce").val();

        let variation_id = $(".variation-id").val();

       

        let data = {};

        if(variation_id){

            data = {
                product_quantity: product_q,
                product_id: product_id,
                product_variation_id: variation_id,
                action: 'product_cart',
                product_nonce:product_nonce
            }
        }else{

            data = {
                product_quantity: product_q,
                product_id: product_id,
                action: 'product_cart',
                product_nonce:product_nonce
            }

        }

        let status = checkError();
        
        if(status){
            $.ajax({

                method: "POST",
                url: add_single_product.ajaxurl,
                data: data,
                beforeSend:function(){
                    $(".btn-add-to-cart").hide();
                    $(".btn-add-to-cart.loading").fadeIn(200);
                }
        
            }).done(function(response){
    
                if(response.nonce_error){
                    $(".add_to_cart_notices").html(`<div class="add_to_cart_notices bg-warning">${response.message}</div>`);
                    return false;
                }
    
               $(".add_to_cart_notices").html(response.fragments.html_notices);
               $(".btn-add-to-cart").fadeIn(200);
               $(".btn-add-to-cart.loading").hide();
               $(".add_to_cart_notices").fadeIn(250);
    
                //console.log(response);
            
            }).fail(function(err){
                console.log(err);
            })
        }

    });


   
// });

// jQuery(document).ready(function($){

    let collection_var = [];
    let collection_var_ = [];


    $(".shop_page_nav_item").on("mouseenter",function(){
        $(this).find(".shop_page_list_content").fadeIn(300);
    });

    $(".shop_page_nav_item").on("mouseleave",function(){
        $(this).find(".shop_page_list_content").fadeOut(100);
       
    });

    $(".shop_page_nav_item").on("click", ".shop_product_item",function(){
        
        if(!$(this).find(".attr_product_item").prop("checked")){
            $(this).find(".attr_product_item").prop("checked", true);
        }else{
            $(this).find(".attr_product_item").prop("checked", false);
        }
        getCheckedVal();
        sendAjax_Filter();
    });

    function getCheckedVal(){
        collection_var = [];
        $(".shop_page_nav_item").find("input[type=checkbox]").each(function(){
            if($(this).prop("checked")){   
                let attr = $(this).data("attrKey");
                let value = $(this).val();
                let object = {};
                if(collection_var.length > 0){
                    for(let i = 0; i < collection_var.length; i++){
                       for(let key in collection_var[i]){
                            if(key == attr){
                                collection_var[i][key].push(value);
                                return true;
                            }
                       }
                    }
                    object[`${attr}`] = [value];
                    collection_var.push(object)
                }else{
                    object[`${attr}`] = [value];
                    collection_var.push(object)
                }
                
                
            }
        });
    }

    $(".variations-single").on("change","select", function(){
        getsinglePageCheckedVal();
        sendAjax_Filter_Single_Page();
    });

    
    function getsinglePageCheckedVal(){

        collection_var_ = [];

        $(".variations-single").find(".variations-single-item").each(function(){
             let attr = $(this).find("select option:checked").data("variation");
             let value = $(this).find("select option:checked").val();
             let object = {};
             
             if(value !== ""){
                if(collection_var_.length > 0){
                    for(let i = 0; i < collection_var_.length; i++){
                        for(let key in collection_var_[i]){
                            if(key == attr){
                                collection_var_[i][key].push(value);
                                return true;
                            }
                        }
                    }

                    object[`${attr}`] = [value];
                    collection_var_.push(object)

                }else{
                    object[`${attr}`] = [value];
                    collection_var_.push(object)
                }
             }
        })

        //console.log(collection_var_);
    }

    function sendAjax_Filter(){
        let url = $(".current_url").val();

        let data = {
            action: "filter_from_query",
            nonce: $("#add_filter_nonce_name").val(),
            info: collection_var,
            url:url,
        };

        $.ajax({
            method: "POST",
            url: add_single_product.ajaxurl,
            data:data
        }).done((res)=>{

           if(!res.data){

                window.location.href = url;
           }else{

                window.location.assign(res.url);
               // console.log(res.data);
           }

            
        });
    }

    function sendAjax_Filter_Single_Page(){
        let url = $(".single_page_url").val();

        let data = {
            action: "filter_from_query_single_page",
            nonce: $("#add_single_page_nonce_name").val(),
            info: collection_var_,
            url:url,
        };

        let status = checkError();

         if(status){
            $.ajax({
                method: "POST",
                url: add_single_product.ajaxurl,
                data:data
            }).done((res)=>{
    
               if(!res.data){
                    window.location.href = url;
               }else{
    
                    window.location.assign(res.url);
                   // console.log(res.data);
               }
    
            });
         }
           
    }

/* <-===================Shop Page Selection Variation===================-> */

    outputSelected();

    function outputSelected(){
        let selected = [];

        $(".selected_data").find(".select_filter_var").each(function(){

            let selected_val = $(this).val();
            let selected_key = $(this).data("selectedKey");
            let obj = {};
            obj[`${selected_key}`] = selected_val;
           
            selected.push(obj);
        });


        $(".shop_page_nav_item").find("input[type=checkbox]").each(function(){
             let attr = $(this).data("attrKey");
             let value = $(this).val();
        
             if(selected.length > 0){
                  for(let i = 0;i < selected.length; i++){
                       for(let key in selected[i]){
                          if(key == attr){
                              let newvalue = (selected[i][key]).split(",");
                             if(newvalue.includes(value)){
                                $(this).prop("checked", true);
                             }
                         }
                       } 
                  }
             }
        })
    }

    /* <-===================Single Page Selection Variation===================-> */

    outputSingleSelected();

    function outputSingleSelected(){
        let selected = [];

        $(".single_selected_data").find(".single_select_filter_var").each(function(){

            let selected_val = $(this).val();
            let selected_key = $(this).data("selectedKey");
            let obj = {};
            obj[`${selected_key}`] = selected_val;

            selected.push(obj);
        });

        //console.log(selected);


        $(".variations-single").find(".variations-single-item").each(function(){
          
           $(this).find("select option").each(function(){

               let attr = $(this).data("variation");
               let value = $(this).val();
               
               if(selected.length > 0){
                 for(let i = 0; i < selected.length; i++){
                    for(let key in selected[i]){
                        if(key == attr){
                            if(selected[i][key] == value){
                                $(this).prop("selected", true);
                            }else{
                                $(this).prop("selected", false);
                            }
                        }
                    }
                 }
               }else{
                    if(value === ""){
                        $(this).prop("selected", true);
                    }
               }
            });
           
        })
    }

       
   
    function checkError(){

        let check_variation = $(".variations-single").find(".variations-single-item").length;
        
        if(check_variation >= 1){

            errors =[];
            $(".variations-single").find(".variations-single-item").each(function(){
                let value = $(this).find("select option:checked").val();
                let attr = $(this).find("select option:checked").data("variation");
                console.log(value);
                if(!value){
                    errors.push(attr);
                    $(this).css({'border-color':'red'});
                    
                }else{
                    errors.filter(item => item != attr);
                    $(this).css({'border-color':'rgba(63, 112, 89, 1)'});
                    
                }
            });  
        }

        let error = "";
        if(errors.length > 0){
            
            for(let i = 0; i < errors.length; i++ ){
                error += `<p> Please select an Option for ${errors[i]} </> <br>`;
            }
           
            $(".variable-alert").html(error);

            $(".variable-alert").show();

            $(".btn-add-to-cart").prop('disabled', true);
            $(".btn-add-to-cart").css('background-color', 'grey');
            return false;

        }else{
            $(".variable-alert").html("");
            $(".variable-alert").hide();
            $(".btn-add-to-cart").prop('disabled', false)
            return true;
        }

        
    }


});

/* <-===================Front Page News Section===================-> */

jQuery(document).ready(function($){
    $(".news_list").find(".news_list_").each(function(){
        if($(this).hasClass('is_active')){
            $(this).show();
        }else{
            $(this).hide();
        }
    });

    $(".news_nav_list").find('a').each(function(){

        $(this).on("click", function(e){
            e.preventDefault();
            let value = "";

            $(this).children().addClass('active');
            $(this).siblings().children().removeClass('active');


            if(this.hash.indexOf("#") > -1){
                value = this.hash.replace("#", "");
            }

           if(value == 'all'){
                $(".news_list").find(".news_list_").filter("#all").show();
                $(".news_list").find(".news_list_").not("#all").hide();
           }else{
                $(".news_list").find(".news_list_").filter(`#${value}`).show();
                $(".news_list").find(".news_list_").not(`#${value}`).hide();
           }

        });

    });

    $(".news_nav_list_small").on('change', function(e){
        e.preventDefault();
        let value = $(".news_nav_list_small").val();
       
        
        if(value == 'all'){
            $(".news_list").find(".news_list_").filter("#all").show();
            $(".news_list").find(".news_list_").not("#all").hide();
       }else{
            $(".news_list").find(".news_list_").filter(`#${value}`).show();
            $(".news_list").find(".news_list_").not(`#${value}`).hide();
       }
    });

   
/* <-===================News Page===================-> */

    $(".news_nav_item_page").each(function(){
        $(this).on("click", function(e){

            e.preventDefault();
            let current_value = $(this).data("value");

            
                let data = {
                    news_info: current_value,
                    action: "get_news_info",
                    nonce: $("#news_info_nonce").val(),
                    url:$(".current_news_url").val()
                };

                console.log(add_single_product.ajaxurl);
            
                $.ajax({
                    url: add_single_product.ajaxurl,
                    method: "POST",
                    data: data,
                })
                .then(function(res){
                    window.location.assign(res.url);
                })
                ;
             

        });
    });

    $(".news_nav_list_small_page").on('change', function(e){
        e.preventDefault();
        let value = $(".news_nav_list_small_page").val();

        let data = {
            news_info: value,
            action: "get_news_info",
            nonce: $("#news_info_nonce").val(),
            url:$(".current_news_url").val()
        };

        console.log(add_single_product.ajaxurl);
    
        $.ajax({
            url: add_single_product.ajaxurl,
            method: "POST",
            data: data,
        })
        .then(function(res){
            window.location.assign(res.url);
            setActive();
        })
        ;
    });

    setActive();

    function setActive(){
        let active = $(".active_item").data("activeValue");
        let value = $(".news_nav_list_small_page option").val();
        $(".news_nav_list_small_page option").each(function(){
            if($(this).val() == active){
                $(this).prop('selected', true);
            }
        });


        $(".news_nav_item_page").each(function(){
            if($(this).data("value") == active){
                $(this).addClass("active");
            }else{
                $(this).removeClass("active");
            }
        });

       
    }

    
   
});

/* <-===================Fron Page Header Section===================-> */

jQuery(document).ready(function($){

    $(".search-icon .search_item").on("click", function(e){
        e.preventDefault();
        $(".search-form").slideToggle(500);
    });

    $(window).on("scroll", function(){

        if($(this).scrollTop() > 600){
            $(".to_the_top").fadeIn(300);
        }else{
            $(".to_the_top").fadeOut(300);
        }

    })

    $(window).on("scroll",function(){

        $height = $(".header_message").outerHeight(true);

        if($(this).scrollTop() > $height){
            $(".header_nav_bar").addClass('fixed');

            let header_p = $(".header_nav_bar").height();
            $(".search-form").css({'top':`${header_p}px`});

        }else{
            $(".header_nav_bar").removeClass('fixed');
            setSearchPosition();
        }
    })


    $(".to_the_top").on("click", function(){
        $("body,html").animate({
            scrollTop: 0
        },300);
    });

    setSearchPosition();

    function setSearchPosition(){
        let header_p = $(".header_nav_bar").offset().top + $(".header_nav_bar").height();
        $(".search-form").css({'top':`${header_p}px`});
    }

   
    if($("#search_result").length){
        $("html, body").animate({
            scrollTop: $("#search_result").offset().top - 210
        },300)
    }

/* <-================Full Screen Image Slider====================-> */

    $(".close-full-image").on("click", function(){
        $(this).parent().parent().hide();
    });

    $(".single-product-gallary-slider-full-size-image").on('click', function(){
        $(".single-product-full-screen-image").show();
    });

    initFullScreen();
    function initFullScreen(){
        let image_num = $(".single-product-image-content-gallary-slider-image-slide").length;
        $(".single-product-image-content-gallary-slider-move").css({"width":`${image_num * 100}%`});
        $(".single-product-image-content-gallary-slider-image-slide").each(function(){
            if($(this).data("id") == 0){
                $(this).addClass("active");
            }
        });

    }

    
    let current_active_num = 0;
    let image_num = 0;

    initHeadernum();
    function initHeadernum(){
        
        image_num = $(".single-product-image-content-gallary-slider-image-slide").length; 
        let current_num =  $(".single-product-image-content-gallary-slider-image-slide.active").data("id");
        
        $(".single-product-image-content-gallary-slider-move").css({"left": 0});
       
       $(".single-product-full-screen-header-number").html(`<h5>${parseInt(current_num) + 1}/${image_num}</h5>`);


    }

    $(".image-content .chervon-left").on("click", function(e){
        e.preventDefault();
        current_active_num -= 1;

        let current_W = $(".image-screen").width();
        if(current_active_num >= 0){
            $(".single-product-image-content-gallary-slider-move").animate({
                left: `+=${current_W}px`
            },500, function(){
                $(".single-product-full-screen-header-number").html(`<h5>${parseInt(current_active_num) + 1}/${image_num}</h5>`);
            });
        }else{
            current_active_num = 0;
            $(this).hide();
            $(".image-content .chervon-right").show();
            return current_active_num;
        }

    });

    $(".image-content .chervon-right").on("click", function(e){
        e.preventDefault();
        current_active_num += 1;

        let current_W = $(".image-screen").width();
        if(current_active_num < image_num){
            $(".single-product-image-content-gallary-slider-move").animate({
                left: `-=${current_W}px`
            },500, function(){
                $(".single-product-full-screen-header-number").html(`<h5>${parseInt(current_active_num) + 1}/${image_num}</h5>`);
            });
        }else{
            current_active_num = image_num - 1;
            $(this).hide();
            $(".image-content .chervon-left").show();
            return current_active_num;
            
        }
       
    });
    


   
  
});