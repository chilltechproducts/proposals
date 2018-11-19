var ALERT_TITLE = "Oops!";
var ALERT_BUTTON_TEXT = "Ok";
var dbg = function(){

}
window.onload = function(){
function createCustomAlert(txt,noFade, alert_title) {
  
    var d = document;

    if(d.getElementById("modalContainer")){
    removeCustomAlert();
    return createCustomAlert(txt,noFade, alert_title);
    }

    mObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
    mObj.id = "modalContainer";
    mObj.style.height = d.documentElement.scrollHeight + "px";

    alertObj = mObj.appendChild(d.createElement("div"));
    alertObj.id = "alertBox";
    if(d.all && !window.opera) alertObj.style.top = document.documentElement.scrollTop + "px";
    alertObj.style.left = (d.documentElement.scrollWidth - alertObj.offsetWidth)/2 + "px";
    alertObj.style.visiblity="visible";

    h1 = alertObj.appendChild(d.createElement("h1"));
    h1.appendChild(d.createTextNode(alert_title));

    msg = alertObj.appendChild(d.createElement("p"));
    //msg.appendChild(d.createTextNode(txt));
    msg.innerHTML = '<img src="/public/images/alert.png" />' + txt;

    btn = alertObj.appendChild(d.createElement("a"));
    btn.id = "closeBtn";
    btn.appendChild(d.createTextNode(ALERT_BUTTON_TEXT));
    btn.href = "#";
    btn.focus();
    btn.onclick = function() { removeCustomAlert();return false; }
//parseScript(txt);
    alertObj.style.display = "block";
    if(noFade ==0){
        setTimeout(function(){ removeCustomAlert(); }, 5000);
    } 
    
}

function removeCustomAlert() {
    $("#modalContainer").remove();
}

if(document.getElementById) {
    
    window.alert = function(txt, alert_title, noFade) {
      if(!alert_title){
        alert_title = ALERT_TITLE;
      }  
      if(!noFade){
        createCustomAlert(txt, 0, alert_title);
      }else{
        createCustomAlert(txt,  1, alert_title);
       } 
    }
    
}
}
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
    $('input.name, input.number').each(function(i, item){
            var id=$(this).attr('id');
             patt = new RegExp(/_name$/ig);
                if(id.match(patt)){
                  $('#' + id.replace(patt, '_id') ).remove();
                  $(this).after('<input type="text" id="' + id.replace(patt, '_id') + '" name="' + id.replace(patt, '_id') + '" value="" />'); 
                }  
    })
            
    $.ajax({
           url: '/ajax/add_part/' + lid ,
           type: 'post',
           dataType: 'json',
           data: {json: 1 },
           success: function(response){
                $.each(response.data.part_data, function(i,item){
                    $('#' + i).val(item);
                    console.log(item);
                })
                $.each(response.data.warranty_data, function(i,item){
                    $('#' + i).val(item);
                    
                })
           }
    });     
}
function show_diagnostic_data(lid, sid){
    $.ajax({
           url: '/ajax/show_diagnostic_data/' + lid + '/' + sid,
           success: function(response){
               $('#show_diagnostic_data_' + sid).html(response);
               
           }
    })
    
}
function add_service_entry(lid){
        $.ajax({
           url: '/ajax/add_service_entry/' + lid ,
           type: 'post',
           dataType: 'html',
           data: {json: 1 },
           success: function(response){
                $('#service_entry_box').html(response)
           }
    });     

}
function save_diagnotics(lid, sid){
     $.ajax({
           url: '/ajax/save_diagnotics/' + lid  + '/' + sid,
           type: 'post',
           dataType: 'html',
            data: $('#show_diagnostic_data_' + sid + ' .form-group input, #show_diagnostic_data_' + sid + ' .form-group select').serialize(),
            success:function(response){
                $('#show_diagnostic_data_' + sid).html(response);
            }
     });
    
}
function add_diagnostic_row(lid, sid){
  console.log(sid)
    console.log($('#show_diagnostic_data_' + sid + ' .form-group').length );
     $.ajax({
           url: '/ajax/add_record/' + lid  + '/' + sid,
           type: 'get',
           dataType: 'html',
            data: { i: $('#show_diagnostic_data_' + sid + ' .form-group').length },
            success:function(response){
                $('#show_diagnostic_data_' + sid + ' .fa-save').before(response);
            }
     });
}
function service_history(lid){
    //alert('test');
    $('.ajax').html('');
    $('#part_data_' + lid + ' .ajax').html('<ul class="hundred block"></ul>');
    $.ajax({
         url: '/ajax/service_history',
         data: { lid: lid },
         dataType: 'json',
         success: function(response){
             if(!response.error){
                 $.each(response.data, function(i, item){
                     html = '<li class="service_entry block hunderd"><span class="fifty">date: <i>' + item.service_date + '</i><br />description: <i>' + item.service_performed + '</i><br />technician" <i>' + item.company_name + '</span><span class="hundred block show_diagnostic_data" id="show_diagnostic_data_' + item.id + '">';
                 
                      html += '<i class="fa fa-eye" onclick="show_diagnostic_data(' + lid + ', ' + item.id + ');"></i>';
                    html += '</span></li>';
                    $('#part_data_' + lid + ' .ajax ul').append(html);
                 });
                 $('#part_data_' + lid + ' .ajax').append('<div id="service_entry_box"></div><a class="button" onclick="add_service_entry(' + lid + ');">Add Service Entry</a></span>');
             }else{
               alert(response.error);   
             }
         }
    });   
    
}
function get_parts(uid){
    
      $.ajax({
         url: '/ajax/get_parts',
         data: { uid: uid },
         dataType: 'json',
         success: function(response){
             $.each(response.part_data, function(i, item){
                if(i%2==0){
                    odd_even='even';
                }else{
                    odd_even='odd';
                }
                html = '<li class="block row ' + odd_even + '"><span class="name inline" id="part_data_' + item.location_id + '">' + item.location_name + '<br />' + item.part_name + '<br />company: <i>' + item.company_name + '</i><br />client name: <i>' + item.first_name + ' ' + item.last_name + '</i><br />install date: <i>' + item.install_date + '</i><br />last service date: <i>' + item.last_service_date + '</i><br /><span class="inline buttons"><i class="fa fa-close"></i><i class="fa fa-pencil" onclick="add_part();lookup_part_data(' + item.location_id + ')"></i><i class="fa fa-eye"></i><i class="fa fa-cog" onclick="service_history(' + item.location_id + ');"></i></span><span class="ajax"></span></span><span class="qrcode inline"><img src="/QRCodeCreator/create/"' + item.location_id + '" /></span></li>';
                $('#content_box > ul.parts').append(html); 
                 
             });    
         }
      });
}
function my_parts(uid){
if(!uid){
    uid = '';
}    
$('#content_box').html('')
  $.ajax({
         url: '/ajax/my_parts',
         data: { uid: uid },
         success: function(response){
             $('#content_box').html(response);
             if($('#email_form').length>0){
                  return;
             }
             get_parts($('#user_id').val());
         }
  });      
}   
function part_submit(){
    $.ajax({
        url: '/ajax/part_submit',
       
        type: 'post',
        data: $('#registration_form').serialize(),
         dataType: 'json',
        cache: false,
        success: function(response){
            $('#content_box').html(response)
            
        }
    })
}

  function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        alert('Location not found');
      }
function login_form(){
      $.ajax({
        url: '/main/login?ajax=1',
        
        type: 'get',
         dataType: 'html',
        cache: false,
        success: function(response){
            //alert(1)
          $('#content_box').html(response);
          
        }
      });  
    
}
function add_part(serial_no){
    
    $.ajax({
        url: '/ajax/add_part',
        
        type: 'get',
         dataType: 'html',
        cache: false,
        success: function(response){
            //alert(1)
          $('#content_box').html(response);
          
          // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

           $('#latitude').val(pos.lat);
           $('#longitude').val(pos.lng);
          }, function() {
            handleLocationError();
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError();
        }
      

    

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
