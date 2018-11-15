function load_profile(user_id){
    if(!user_id){
      user_id = 0;   
    }
    $.ajax({
          url: '/ajax/myprofile',
          type: 'get',
          data: { user_id: user_id, ajax: true },
          success: function(response){
              $('#content_box').html(response);
          }
    });
}    
function get_form_data_and_submit(){
  var data = $('#registration_form').serialize();
  $.ajax({
        url: '/ajax/register',
        data: data,
        type: 'post',
         dataType: 'json',
        cache: false,
        success: function(response){
            if(response.error == true){
                    $('#alert-error').show();
                 //   $('#alert-error').html(response.error):
                    $('#alert-success').hide();
             }else if(response.success == true){
                    $('#alert-error').hide();
                   // $('#alert-success').html(    response.error  ):
                    $('#alert-success').show();
             
             }
         }
      });
}  
function sales_staff(){
    $.ajax({
        url: '/ajax/sales_staff',
       
        type: 'post',
         dataType: 'json',
        cache: false,
        success: function(response){
            $('#content_box').html('<ul class="hundred"></ul>');
            $.each(response.data, function(i, item){
                console.log(item);
                if(i%2==0){
                    idd_even = 'even';
                }else{
                    idd_even = 'odd';
                }    
                html = '<li class="row ' + idd_even + '"><span class="name inline">' + item.first_name + ' ' + item.last_name + '</span><span class="name email">' + item.email + '<br /> ' + item.street_address + ' ' + item.city + ', ' + item.state_province_code + ' ' + item.postal_code + '<br /> ' + item.business_phone + '</span><span class="inline status">' + item.status + '</span><span class="inline buttons"><i class="fa fa-close"></i><i class="fa fa-pencil" onclick="load_profile(' + item.user_id + ')"></i><i class="fa fa-eye"></i></span></li>';
                $('#content_box ul').append(html);
                
            });
         }
      });
    
    
    
}
function lookup_part_data(lid){
    $.ajax({
           url: '/ajax/add_part/' + lid ,
           type: 'post',
           dataType: 'json',
           data: {json: 1 },
           success: function(){
                $.each(response.data.part_data, function(i,item){
                    $('#' + i).val(item);
                    
                })
                $.each(response.data.warranty_data, function(i,item){
                    $('#' + i).val(item);
                    
                })
           }
    });     
}
function part_submit(){
    $.ajax({
        url: '/ajax/part_submit',
       
        type: 'post',
         dataType: 'json',
        cache: false,
        success: function(response){
            $('#content_box').html(response)
            
        }
    })
}
function add_part(serial_no){
    
    $.ajax({
        url: '/ajax/add_part',
        
        type: 'get',
         dataType: 'html',
        cache: false,
        success: function(response){
          $('#content_box').html(response);
          $('input.name, input.number').each(function(i, item){
            var id=$(this).attr('id');
              $(this).keydown(function(){
                  $('#' + id.replace(/[_name]$/ig, '_id') ).remove();
              })
            
            
            
           
            

         
                                                $('#' + id).autocomplete({
                                                            minLength: 1,
                                                            source: '/ajax/product_lookup/' + id + '/',
                                                            focus: function( event, ui ) {
                                                            
                                                            return false;
                                                            },
                                                            select: function( event, ui ) {
                                                                 patt = new RegExp(/[_name]$/ig);
                                                                    if(id.match(patt)){
                                                                        if($('#' + id.replace(/[_name]$/ig, '_id') ).length>0){
                                                                            $('#' + id.replace(/[_name]$/ig, '_id') ).remove();
                                                                        }   
                                                                        $(this).after('<input type="hidden" id="' + id.replace(/[_name]$/ig, '_id') + '" name="' + id.replace(/[_name]$/ig, '_id') + '" value="" />');   
                                                                    }
                                                                    $('#' + id).val(ui.item.value);
                                                                    $('#' + id.replace(/[_name]$/ig, '_id') ).val(ui.item.id);  
                                                                    if(id == 'location_name'){
                                                                      lookup_part_data(ui.item.id)   
                                                                        
                                                                    }    
                                                            return false;
                                                            }
                                                            })
                                                            .autocomplete( "instance" )._renderItem = function( ul, item ) {
                                                            return $( "<li>" )
                                                            .append( "<a>" + item.description + "</a>" )
                                                            .appendTo( ul );
                                                            };
                                            });
            		

         }
      });
    
}
