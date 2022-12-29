jQuery(document).ready(function($) {

    let infos = [];

    $('.add-more-company-item').on('click', function(e) {
        e.preventDefault();
        
        $('.item-address-contact-info-default').clone(true,true).removeClass('item-address-contact-info-default').addClass('item-address-contact-info').appendTo('.company-address-contact-info');
    });


    $('.company-address-contact-info').on('click','.delete-button', function(e) {
        $(this).parent().parent().remove();
        //console.log(infos);
    });


    $('.save-company-item').on('click', function(e) {
            e.preventDefault();
            getNewInfo();
            sendAjaxRequest();
            console.log(infos);
    });

    function getNewInfo() {

        infos = [];

        $('.company-address-contact-info .item-address-contact-info').each(function(i, val){
            let item = [
                {title:''},
                {addressIcon:'', addressInfo: ''},
                {phoneIcon:'', phoneInfo:''},
                {emailIcon:'', emailInfo:''},
            ];

            item[0].title = $(this).find('#title').val();

            item[1].addressIcon = $(this).find('#addressIcon').val();
            item[1].addressInfo = $(this).find('#addressInfo').val();

            item[2].phoneIcon = $(this).find('#phoneIcon').val();
            item[2].phoneInfo = $(this).find('#phoneInfo').val();

            item[3].emailIcon = $(this).find('#emailIcon').val();
            item[3].emailInfo = $(this).find('#emailInfo').val();

            infos.push(item);
            
        });
    }

    function sendAjaxRequest(){

        values = {
            action: 'add_company_address_info',
            nonce: $('#add_company_info_nonce_field').val(),
            data: infos
        }

        $.ajax({
            method: 'POST',
            url: add_company.ajaxurl,
            data: values,
        })
        .done((res)=>{

            $('#get_company_info').val(res);
            $('#get_company_info').change();

        })
        .fail((err)=>{
            console.log(err);
        });

    }

});