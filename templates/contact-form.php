<?php

add_shortcode( 'contact-form', 'create_form' );

function create_form(){

        $form = "";

        $form = '<section class="contact-form">
            <div class="form-wrapper">
                <div class="contact-form-title mb-4">
                    <h5>Please fill in your inquiry!</h5>
                </div>
                <div class="alert alert-warning errors pb-0"></div>
                <form id="contact-form" action="javascript:void(0)">
                    <div class="mb-3 row">
                        <div class="col-sm-3 text-start form-group"><label for="firstName" class="form-label required">First Name</label></div>
                        <div class="col-sm-9 form-group"><input type="text" class="form-control" name="first-name" id="firstName" placeholder="Your first name"></div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-sm-3 text-start form-group"><label for="lastName" class="form-label required">Last Name</label></div>
                        <div class="col-sm-9 form-group"><input  type="text" class="form-control lastName" name="last-name" id="lastName" placeholder="Your last name"></div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-sm-3 text-start form-group"><label for="email" class="form-label required">Email</label></div>
                        <div class="col-sm-9 form-group"><input type="email" class="form-control" name="email" id="email" placeholder="Your Email"></div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-sm-3 text-start form-group"><label for="company" class="form-label required">Company</label></div>
                        <div class="col-sm-9 form-groupr"><input value="" type="text" class="form-control" name="company" id="company" placeholder="Your Company"></div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-sm-3 text-start form-group"><label for="message" class="form-label required">Your Message</label></div>
                        <div class="col-sm-9 form-group"> <textarea value="" name="message" class="form-control" id="message" rows="5" placeholder="Your Message"></textarea></div>
                    </div>

                    <div class="mt-3 row">
                        <div class="col-sm-3 text-start form-group"></div>
                        <div class="col-sm-9 form-group"><button type="submit" class="btn btn-primary mt-3">Submit</button></div>
                    </div>
                </form>
            </div>
           
        </section>';

        return $form;
?>
        
    <?php

}
