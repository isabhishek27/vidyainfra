$('document').ready(function(){
    /** Email validation fun */
    function validateEmail(emailaddress){  
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;  
        if(!emailReg.test(emailaddress)) {  
             return false;
        }else{
            return true;
        }       
     }

    /** Request a quote form submit */
    $('.rqSubmit').on('click', function(){

        let v_errors = false;

        let validation_fields=[];

        let first_name=$('#ffirst_name').val();
        let last_name=$('#flast_name').val();
        let email=$('#femail').val();
        let mobile_number=$('#fmobile_number').val();
        let workshop = $('#fworkshop').val();;
        let travel_location = $('#ftravel_location').val();
        
        $('#ffirst_name_error').text('');
        $('#flast_name_error').text('');        
        $('#femail_error').text('');
        $('#fmobile_number_error').text('');
        $('#fworkshop_error').text('');
        $('#ftravel_location_error').text('');
        
        

        if(first_name==''){
            $('#ffirst_name_error').text('Please enter your first name.');
            validation_fields.push('ffirst_name');
            v_errors = true;
        }
        if(last_name==''){
            $('#flast_name_error').text('Please enter your last name.');
            validation_fields.push('flast_name');
            v_errors = true;
        }
        if(email==''){
            $('#femail_error').text('Please enter email address.');
            validation_fields.push('femail');
            v_errors = true;
        }
        if(email!=='' && !validateEmail(email)){
            $('#femail_error').text('Please enter valid email address.');
            validation_fields.push('femail');
            v_errors = true;
        }
        if(mobile_number==''){
            $('#fmobile_number_error').text('Please enter mobile number.');
            validation_fields.push('fmobile_number');
            v_errors = true;
        }
        if(workshop==''){
            $('#fworkshop_error').text('Please select workshop requirements.');            
            validation_fields.push('fworkshop');
            v_errors = true;
        }
        
        if(travel_location==''){
            $('#ftravel_location_error').text('Please enter comments.');
            validation_fields.push('ftravel_location');
            v_errors = true;
        }       
        
        if(validation_fields.length > 0){
            let first_ele = validation_fields[0];
            $('#'+first_ele).focus();
        }

        if(!v_errors){
            
            let actionUrl = base_url + 'post-request-a-quote';
            //let form_data = $('form#getquote').serialize();
            
            let form_data ={'first_name':first_name,'last_name':last_name,'email':email,'mobile_number':mobile_number,'workshop':workshop,'travel_location':travel_location};

            $.ajax({  
                url:actionUrl,
                type: 'post',
                dataType:'json',
                data:form_data,
                success:function(data){
                    let resp = data;                    
                    if(resp.status){
                        location.href=base_url + 'thanks';
                        return;
                    }
                    
                }  
            });
        }

    });

    /** Contact us form submit */
    $('.cSubmit').on('click', function(){

        let v_errors = false;

        let validation_fields=[];

        let first_name=$('#first_name').val();
        let last_name=$('#last_name').val();        
        let email=$('#email').val();
        let mobile_number=$('#mobile_number').val();
        let address=$('#address').val();
        let message=$('#message').val();
                

        $('#first_name_error').text('');
        $('#last_name_error').text('');        
        $('#email_error').text('');
        $('#mobile_error').text('');
        $('#address_error').text('');
        $('#message_error').text('');
        
        

        if(first_name==''){
            $('#first_name_error').text('Please enter your first name.');
            validation_fields.push('first_name');
            v_errors = true;
        }
        if(last_name==''){
            $('#last_name_error').text('Please enter your first name.');
            validation_fields.push('last_name');
            v_errors = true;
        }
        if(email==''){
            $('#email_error').text('Please enter email address.');
            validation_fields.push('email');
            v_errors = true;
        }
        if(email!=='' && !validateEmail(email)){
            $('#email_error').text('Please enter valid email address.');
            validation_fields.push('email');
            v_errors = true;
        }
        if(mobile_number==''){
            $('#mobile_number_error').text('Please enter mobile number.');
            validation_fields.push('mobile_number');
            v_errors = true;
        }
        /*
        if(address==''){
            $('#address_error').text('Please enter your address.');
            validation_fields.push('address');
            v_errors = true;
        }*/
        if(message==''){
            $('#message_error').text('Please enter your comments.');            
            validation_fields.push('message');
            v_errors = true;
        }
        
        if(validation_fields.length > 0){
            let first_ele = validation_fields[0];
            $('#'+first_ele).focus();
        }

        if(!v_errors){

            /*alert(first_name + '---'+email + '----'+ mobile_number+'----'+address+'----'+message);
            return;*/

            let actionUrl = base_url + 'post-contact-us';
            let form_data = $('form#contactus').serialize();
            
            $.ajax({  
                url:actionUrl,
                type: 'post',
                dataType:'json',
                data:form_data,
                success:function(data){
                    let resp = data;                    
                    if(resp.status){
                        location.href=base_url + 'thanks';
                        return;
                    }
                    
                }  
            });
        }

    });

    /** Testimonial form submit */
    $('.tSubmit').on('click', function(){

        let v_errors = false;

        let validation_fields=[];

        let t_name=$('#t_name').val();        
        let email=$('#email').val();        
        let testimonial=$('#testimonial').val();
                

        $('#t_name_error').text('');        
        $('#email_error').text('');
        $('#testimonial_error').text('');
        
        

        if(t_name==''){
            $('#t_name_error').text('Please enter your name.');
            validation_fields.push('t_name');
            v_errors = true;
        }       

        if(email==''){
            $('#email_error').text('Please enter email address.');
            validation_fields.push('email');
            v_errors = true;
        }
        if(email!=='' && !validateEmail(email)){
            $('#email_error').text('Please enter valid email address.');
            validation_fields.push('email');
            v_errors = true;
        }
       

        if(testimonial==''){
            $('#testimonial_error').text('Please enter your comments.');            
            validation_fields.push('testimonial');
            v_errors = true;
        }
        
        if(validation_fields.length > 0){
            let first_ele = validation_fields[0];
            $('#'+first_ele).focus();
        }
       
        if(!v_errors){
            
            let actionUrl = base_url + 'post-testimonials';
            let form_data = $('form#testimonials').serialize();
            
            $.ajax({  
                url:actionUrl,
                type: 'post',
                dataType:'json',
                data:form_data,
                success:function(data){
                    let resp = data;                    
                    if(resp.status){
                        location.href=base_url + 'thanks';
                        return;
                    }
                    
                }  
            });
        }

    });

    /** Coupon form submit */
    $('.couponSubmit').on('click', function(){

        let v_errors = false;

        let validation_fields=[];

        let coupon_code=$('#coupon_code').val();

        $('#coupon_code_error').text('');        
        

        if(coupon_code==''){
            $('#coupon_code_error').text('Please enter coupon code.');
            validation_fields.push('coupon_code');
            v_errors = true;
        }
       
        
        if(validation_fields.length > 0){
            let first_ele = validation_fields[0];
            $('#'+first_ele).focus();
        }
       
        if(!v_errors){
            
            let actionUrl = base_url + 'workshops/payment/verify-coupon';
            let form_data = $('form#coupon').serialize();
            
            $.ajax({  
                url:actionUrl,
                type: 'post',
                dataType:'json',
                data:form_data,
                success:function(data){
                    let resp = data;                    
                    if(resp.status){
                        $('.net_payable').html(resp.price);
                        $('#coupon_code_error').html('');
                        $('#coupon_code_success').html(resp.msg);
                        return;
                    }else{
                        $('#coupon_code_success').html('');
                        $('#coupon_code_error').html(resp.msg);
                    }
                    
                }  
            });
        }

    });

    /** Notify me */    
    $('.notifySubmit').on('click', function(){

        let v_errors = false;

        let validation_fields=[];

        let nname=$('#nname').val();
        let nemail=$('#nemail').val();
        let nphone=$('#nphone').val();
        let nworkshopid=$('#nworkshopid').val();
                

        $('#nname_error').text('');        
        $('#nemail_error').text('');
        $('#nphone_error').text('');        
        
        

        if(nname==''){
            $('#nname_error').text('Please enter your name.');
            validation_fields.push('nname');
            v_errors = true;
        }
        if(nemail==''){
            $('#nemail_error').text('Please enter email address.');
            validation_fields.push('nemail');
            v_errors = true;
        }
        if(nemail!=='' && !validateEmail(nemail)){
            $('#nemail_error').text('Please enter valid email address.');
            validation_fields.push('nemail');
            v_errors = true;
        }
        if(nphone==''){
            $('#nphone_error').text('Please enter mobile number.');
            validation_fields.push('nphone');
            v_errors = true;
        }
        
        if(validation_fields.length > 0){
            let first_ele = validation_fields[0];
            $('#'+first_ele).focus();
        }

        if(!v_errors){

            /*alert(first_name + '---'+email + '----'+ mobile_number+'----'+address+'----'+message);
            return;*/

            let actionUrl = base_url + 'workshops/post-notifyme';
            let form_data = $('form#notifyme').serialize();
            $('#nemail_error').text('');
            $.ajax({  
                url:actionUrl,
                type: 'post',
                dataType:'json',
                data:form_data,
                success:function(data){
                    let resp = data;                    
                    if(resp.status){
                        location.href=base_url + 'thanks';
                        return;
                    }else{
                         $('#nemail_error').text(resp.msg);
                    }
                    
                }  
            });
        }

    });

    
});