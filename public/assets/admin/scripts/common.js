$('document').ready(function(){
    
    $('.ViewInDetail').on('click',function(){

        let section = $(this).attr('data-section');
        let rec_id = $(this).attr('data-rec-id');

        if(section=='pageDetail'){

            let actionUrl = base_url + 'admin/cms/page_details';
            
            let form_data ={'page_id':rec_id};

            $.ajax({  
                url:actionUrl,
                type: 'post',
                dataType:'json',
                data:form_data,
                success:function(data){
                    let resp = data;                    
                    if(resp.status){

                        $('#pageTitle').html(resp.data.page_title);
                        $('#pageDesc').html(resp.data.page_content);
                        $('#modal-detail').modal('show');
                    }
                    
                }  
            });
        }else if(section=='enquiriesDetail'){

            let actionUrl = base_url + 'admin/enquiries/enquiries_details';
            
            let form_data ={'id':rec_id};

            $.ajax({  
                url:actionUrl,
                type: 'post',
                dataType:'json',
                data:form_data,
                success:function(data){
                    let resp = data;                    
                    if(resp.status){

                        $('#fname').html(resp.data.first_name);
                        $('#lname').html(resp.data.last_name);
                        $('#mobile').html(resp.data.mobile_number);
                        $('#email').html(resp.data.email);
                        $('#address').html(resp.data.address);
                        $('#message').html(resp.data.requirements);
                        $('#enquiry_date').html(resp.data.created_at);
                        $('#modal-detail').modal('show');
                    }
                    
                }  
            });
        }else if(section=='requestQuoteDetail'){

            let actionUrl = base_url + 'admin/enquiries/requestquote_details';
            
            let form_data ={'id':rec_id};

            $.ajax({  
                url:actionUrl,
                type: 'post',
                dataType:'json',
                data:form_data,
                success:function(data){
                    let resp = data;                    
                    if(resp.status){

                        $('#first_name').html(resp.data.first_name);
                        $('#last_name').html(resp.data.last_name);
                        $('#mobile').html(resp.data.country_code+resp.data.mobile_number);
                        $('#email').html(resp.data.email);
                        $('#workshop').html(resp.data.workshop);
                        $('#travel_location').html(resp.data.travel_location);
                        $('#enquiry_date').html(resp.data.created_at);
                        $('#modal-detail').modal('show');
                    }
                    
                }  
            });
        }else if(section=='postDetail'){

            let actionUrl = base_url + 'admin/blog/post_details';
            
            let form_data ={'id':rec_id};

            $.ajax({  
                url:actionUrl,
                type: 'post',
                dataType:'json',
                data:form_data,
                success:function(data){
                    let resp = data;                    
                    if(resp.status){

                        $('#postTitle').html(resp.data.b_title);
                        $('#postDesc').html(resp.data.b_content);
                        $('#modal-detail').modal('show');
                    }
                    
                }  
            });
        }else if(section=='orderDetail'){

            let actionUrl = base_url + 'admin/orders/details';
            
            let form_data ={'id':rec_id};

            $.ajax({  
                url:actionUrl,
                type: 'post',
                dataType:'json',
                data:form_data,
                success:function(data){
                    let resp = data;                    
                    if(resp.status){
                        let order_status = 'Draft';
                        if(resp.data.order_status == 1){
                            order_status = 'Pending';
                        }else if(resp.data.order_status == 2){
                            order_status = 'Paid';
                        }

                        $('#order_id').html(resp.data.id);
                        $('#pkg_payment_type').html((resp.data.order_id==1)?'Full Payment':'Down Payment');
                        $('#order_price').html('$'+resp.data.order_price);
                        $('#coupon_discount').html('$'+resp.data.coupon_discount);  
                        $('#order_status').html(order_status);
                        
                        $('#workshop_name').html(resp.data.workshop_name);
                        $('#workshop_location').html(resp.data.workshop_location);
                        $('#workshop_date').html(resp.data.workshop_date); 

                        $('#bill_name').html(resp.data.bill_name);
                        $('#bill_email').html(resp.data.bill_email); 
                        $('#bill_phone').html(resp.data.bill_phone); 
                        $('#bill_address').html(resp.data.bill_address); 
                        $('#bill_city').html(resp.data.bill_city); 
                        $('#bill_state').html(resp.data.bill_state); 
                        $('#bill_zip_code').html(resp.data.bill_zip_code);
                        $('#bill_country').html(resp.data.country_name);
                        $('#created_at').html(resp.data.created_at);
                        $('#comments').html(resp.data.comments); 

                        $('#modal-detail').modal('show');
                    }
                    
                }  
            });
        }

    });

    
});