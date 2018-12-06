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
    //    setTimeout(function(){ removeCustomAlert(); }, 5000);
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
function submit_diagnostics2(lid, sid){
    if(!sid){
        url = '/ajax/service_entry_date/' + lid; // + '/' + sid
    }else{
        url = '/ajax/service_entry_date/' + lid + '/' + sid;
        
    }
    $.ajax({
           url: url,
           data: $('#diagnostics_form').serialize(),
           type:'post',
           cache: false,
     
           success: function(response){
               service_history(lid);
               show_diagnostic_data(lid, response.sid);
                $([document.documentElement, document.body]).animate({
                    scrollTop: $("#show_diagnostic_data_" + response.sid).offset().top
                }, 2000);
           }
    })      
    
}
function submit_diagnostics(lid, sid){
    if(!sid){
        sid='';
    }
    $.ajax({
           url: '/ajax/add_service_entry/' + lid + '/' + sid,
           data: $('#diagnostics_form').serialize(),
           type:'post',
           dataType: 'json',
           cache: false,
           success: function(response){
               if(response.success==true){
                   //add_service_entry(lid);
               }
           }
    })      
    
}
function get_clients(){
    $.ajax({
        url: '/main/client_listings/?ajax_set=1',
        type: 'post',
        dataType: 'html',
        data: $('#registration_form').serialize(),
        beforeSend: function() {
            $('#content_box').html('<img src="public/images/loading.gif" class="loading" />').fadeIn();
        },           
        success: function(response){
             $('#content_box').html(response);
        }     
    })
}
function find_clients(){
    
    data = $('#registration_form').serialize();
    data.ajax_set = 1;
     $.ajax({
        url: '/main/client_listings/?ajax_set=1',
        type: 'post',
        beforeSend: function() {
            $('#content_box').html('<img src="public/images/loading.gif" class="loading" />').fadeIn();
        },
        
        dataType: 'html',
        data: data,
        success: function(response){
             $('#content_box').html(response);
        }     
    })
}
function load_proposals(uid, cid, pid){
    if(!pid){
        url = '/main/create_proposal/2/' + uid + '/?ajax_set=1';
    }else{
        url = '/main/create_proposal/2/' + uid + '/' + pid + '/?ajax_set=1';
    }
    
 $.ajax({
        url: url,
        type: 'post',
        dataType: 'html',
        data: $('#registration_form').serialize(),
        beforeSend: function() {
            $('#content_box').html('<img src="public/images/loading.gif" class="loading" />').fadeIn();
        },        
        success: function(response){
             $('#content_box').html(response);
        }     
 }) 
    
}
function edit_warranty(pid){
  CKEDITOR.disableAutoInline = true;
    CKEDITOR.inline( 'company_warranty' );
    if($('#company_warranty .buttons').length==0){
         
    }    
}   
function load_proposal_details(cid, did, pid){
 
        url = '/main/create_proposal/3/' + cid + '/' + pid + '/?ajax_set=1';
        
    
 $.ajax({
        url: url,
        type: 'post',
        dataType: 'html',
        data: $('#registration_form').serialize(),
        beforeSend: function() {
            $('#content_box').html('<img src="public/images/loading.gif" class="loading" />').fadeIn();
        },        
        success: function(response){
             $('#content_box').html(response);
                add_part_to_proposal('parts', pid);
                add_part_to_proposal('labor', pid);
             $('#company_warranty' ).click(function(){
                try{
                    CKEDITOR.disableAutoInline = true;
                    CKEDITOR.inline( 'company_warranty' );
                   
                    }catch(err){}
             })
            
        }     
 }) 
    
}
function add_client(cid){
    if(!cid){
        url = '/main/create_proposal/1/?ajax_set=1';
    }else{
        url = '/main/create_proposal/1/' + cid + '/?ajax_set=1';
        
    }
 $.ajax({
        url: url,
        type: 'post',
        dataType: 'html',
        data: $('#registration_form').serialize(),
        beforeSend: function() {
            $('#content_box').html('<img src="public/images/loading.gif" class="loading" />').fadeIn();
        },        
        success: function(response){
             $('#content_box').html(response);
        }     
 })
}
function submit_part_to_server(part_id, pid, alt){
   
    $.ajax({
           url : '/proposals/submit_new_part/' + pid + '/' + part_id + '/' + alt,
           data: $('#parts_info .form-control[alt="' + alt + '"] input').removeAttr('disabled').serialize(),
           type: 'post',
           success: function(response){
            add_part_to_proposal('parts', pid);
           }
    });      
}  
function submit_labor_to_server(part_id, pid, alt){
   
    $.ajax({
           url : '/proposals/submit_new_labor/' + pid + '/' + alt,
           data: $('#labor_info .form-control[alt="' + alt + '"] input').removeAttr('disabled').serialize(),
           type: 'post',
           success: function(response){
            add_part_to_proposal('labor', pid);
           }
    });      
}    
function add_part_to_proposal(type, pid){
    $.ajax({
        url: '/proposals/add_part_to_proposal/' + pid + '/' + type,
        type: 'post',
        dataType: 'html',
     
        beforeSend: function() {
            $('#' + type + '_info > div').html('<img src="public/images/loading.gif" class="loading" />').fadeIn();
        },        
        success: function(response){
             $('#' + type + '_info > div').html(response);
             
             if(type == 'parts'){
                  $('#' + type + '_info .form-control .qty').bind('blur change', function(ui){
                                   alt= $(this).attr('alt');
                                    part_id = $('#part_id_' + alt).val();
                                 
                                    submit_part_to_server(part_id, pid, alt);
                        })
                    
                        $('#' + type + '_info .form-control .inline.name input').each(function(i, item){
                            var alt=$(this).attr('alt');
                            console.log(alt)
                            $('#' + type + '_info .form-control[alt="' + alt + '"] .fa-close').click(function(){
                                
                                $('#' + type + '_info .form-control[alt="' + alt + '"]').remove();
                            });    
                            
                                
                                $('#' + type + '_info .form-control .inline.name input[alt="' + alt + '"]').autocomplete({
                                                        minLength: 1,
                                                        source: '/ajax/find_part/?q=' + $('.form-control .inline.name input[alt="' + alt + '"]').val(),
                                                        focus: function( event, ui ) {
                                                        
                                                        return false;
                                                        },
                                                        select: function( event, ui ) {
                                                            
                                                                    $('#' + type + '_info .form-control input[id="part_id_' + alt + '"]').val(ui.item.part_id)
                                                                    $('#' + type + '_info .form-control .inline.model_number input[alt="' + alt + '"]').val( ui.item.model_number );
                                                                    $('#' + type + '_info .form-control .inline.name input[alt="' + alt + '"]').val( ui.item.part_name );
                                                                    if($('#' + type + '_info .form-control .inline.quantity input[alt="' + alt + '"]').val() == ''){
                                                                        $('#' + type + '_info .form-control .inline.quantity input[alt="' + alt + '"]').val(1);
                                                                    }
                                                                        setTimeout(function(){ submit_part_to_server(ui.item.id, pid, alt); }, 500);
                                                                    return false;
                                                        }
                                                        })
                                                        .autocomplete( "instance" )._renderItem = function( ul, item ) {
                                                        return $( "<li>" )
                                                        .append( "<a>" + item.part_name + "</a>" )
                                                        .appendTo( ul );
                                                        };


                                });
             }else{
                 
                  $('#' + type + '_info .form-control .qty').bind('blur change', function(ui){
                                   alt= $(this).attr('alt');
                                    part_id = $('#part_id_' + alt).val();
                                 
                                    submit_labor_to_server(part_id, pid, alt);
                        })
                    
                        $('#' + type + '_info .form-control .inline.name input').each(function(i, item){
                            var alt=$(this).attr('alt');
                            console.log(alt)
                            $('#' + type + '_info .form-control[alt="' + alt + '"] .fa-close').click(function(){
                                
                                $('#' + type + '_info .form-control[alt="' + alt + '"]').remove();
                            });    
                            
                                
                                $('#' + type + '_info .form-control .inline.name input[alt="' + alt + '"]').autocomplete({
                                                        minLength: 1,
                                                        source: '/ajax/find_service/?q=' + $('.form-control .inline.name input[alt="' + alt + '"]').val(),
                                                        focus: function( event, ui ) {
                                                        
                                                        return false;
                                                        },
                                                        select: function( event, ui ) {
                                                            
                                                                    $('#' + type + '_info .form-control  input[id="service_id_' + alt + '"]').val(ui.item.id)
                                                                    $('#' + type + '_info .form-control .inline.model_number input[alt="' + alt + '"]').val( ui.item.service_rate );
                                                                    $('#' + type + '_info .form-control .inline.name input[alt="' + alt + '"]').val( ui.item.service_name );
                                                                    if($('#' + type + '_info .form-control .inline.quantity input[alt="' + alt + '"]').val() == ''){
                                                                        $('#' + type + '_info .form-control .inline.quantity input[alt="' + alt + '"]').val(1);
                                                                    }
                                                                        setTimeout(function(){ submit_labor_to_server(ui.item.id, pid, alt); }, 500);
                                                                    return false;
                                                        }
                                                        })
                                                        .autocomplete( "instance" )._renderItem = function( ul, item ) {
                                                        return $( "<li>" )
                                                        .append( "<a>" + item.service_name + "</a>" )
                                                        .appendTo( ul );
                                                        };


                                });
                 
             }
             
             parts_total = Number($('#parts_info > div .final_total').html());
             labor_total = Number($('#labor_info > div .final_total').html());
             
             total_over = labor_total + parts_total;
             $('#total_over').html(total_over);
            // alert(total_over);
        
        }
 })
    
}
function add_proposal_data(cid, pid){
    
        url = '/main/create_proposal/3/' + cid + '/' + pid + '/?ajax_set=1';
        data = $('#registration_form').serialize();
        
       try{ data += '&warranty=' +CKEDITOR.instances.company_warranty.getData() + '&salesman_warranty=' + CKEDITOR.instances.salesman_warranty.getData(); }catch(err){}
        console.log(data);
        
       
 $.ajax({
        url: url,
        type: 'post',
        dataType: 'html',
        data: data,
        beforeSend: function() {
            $('#content_box').html('<img src="public/images/loading.gif" class="loading" />').fadeIn();
        },        
        success: function(response){
             $('#content_box').html(response);
             
        }     
 })
}
function add_proposal(cid, pid){
    if(!pid){
    if(!cid){
        url = '/main/create_proposal/2/?ajax_set=1';
    }else{
        url = '/main/create_proposal/2/' + cid + '/?ajax_set=1';
        
    }
    }else{
        if(!cid){
            url = '/main/create_proposal/2/?ajax_set=1';
        }else{
            url = '/main/create_proposal/2/' + cid + '/' + pid + '/?ajax_set=1';
            
        }
        
        
    }
 $.ajax({
        url: url,
        type: 'post',
        dataType: 'html',
        data: $('#registration_form').serialize(),
        beforeSend: function() {
            $('#content_box').html('<img src="public/images/loading.gif" class="loading" />').fadeIn();
        },        
        success: function(response){
             $('#content_box').html(response);
        }     
 })
}
function load_profile(user_id){
    if(!user_id){
      user_id = 0;   
    }
    $.ajax({
          url: '/ajax/myprofile',
          type: 'get',
          data: { user_id: user_id, ajax: true },
        beforeSend: function() {
            $('#content_box').html('<img src="public/images/loading.gif" class="loading" />').fadeIn();
        },           
          success: function(response){
              $('#content_box').html(response);
          }
    });
}    
function get_form_data_and_submit(){
  var data = $('#registration_form').serialize();
  $.ajax({
        url: '/ajax/myprofile',
        data: data,
        type: 'post',
         dataType: 'json',
        cache: false,
        success: function(response){
            if(response.error == true){
                    $('#alert-error').show();
                 //   $('#alert-error').html(response.error):
                    $('#alert-success').hide();
                    alert(response.error);
             }else if(response.success == true){
                    $('#alert-error').hide();
                   // $('#alert-success').html(    response.error  ):
                    $('#alert-success').show();
                    alert('Profile Submitted Successfully!');
             
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
        beforeSend: function() {
            $('#content_box').html('<img src="public/images/loading.gif" class="loading" />').fadeIn();
        },        
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
function add_service_entry(lid, sid){
    if(!sid){
        sid = '';
    }
        $.ajax({
           url: '/ajax/add_service_entry/' + lid + '/' + sid,
           type: 'get',
           dataType: 'html',
           
           success: function(response){
                $('#service_entry_box').html(response)
                $('#technician_name').autocomplete({
                                                            minLength: 1,
                                                            source: '/ajax/user_lookup/',
                                                            focus: function( event, ui ) {
                                                            
                                                            return false;
                                                            },
                                                            select: function( event, ui ) {
                                                                 $('#technician_id').val(ui.item.user_id);
                                                                 $('#technician_name').val(ui.item.user_name);
                                                            return false;
                                                            }
                                                            })
                                                            .autocomplete( "instance" )._renderItem = function( ul, item ) {
                                                            return $( "<li>" )
                                                            .append( "<a><img src=\"" + item.avatar + "\" class=\"left avatar\" /> " + item.user_name + "<br />" + (item.company_name?item.company_name:'') + "</a>" )
                                                            .appendTo( ul );
                                                            };

           
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
                    $('#part_data_' + lid + ' .ajax ul').append(html );
                 });
                 $('#part_data_' + lid + ' .ajax ul').append('<li id="service_entry_box"></li>');
                 $('#part_data_' + lid + ' .ajax').append('<span><a class="button" onclick="add_service_entry(' + lid + ');">Add Service Entry</a></span>');
             }else{
               alert(response.error);   
             }
         }
    });   
    
}
function nav_diagnostics(){
    alt= parseInt($('.chart-holder-box:visible').attr('alt'));
    next = alt + 1;
    if(next >= $('.chart-holder-box').length){
       next = 0;   
    }    
    $('.chart-holder-box').hide();
    $('.chart-holder-box[alt="' + next + '"]').show();
}
function show_data_sheet(lid){
    
    
    
}
function ajax_page(url){

  $.ajax({
      url: url, 
      dataType: 'html',
      beforeSend: function() {
            $('#content_box').html('<img src="public/images/loading.gif" class="loading" />').fadeIn();
        },   
      success: function(response){
        
        $('#content_box').html(response);     
      }
  });  
    
}
function find_parts_json(uid){
     data = $('#registration_form').serialize();
                $.ajax({
                    url: '/ajax/find_parts_json',
                    data: data,
                    dataType: 'json',
                    type: 'post',
                    success: function(response){
                        if(response.part_data.length==0){
                            $('#content_box ul.parts').html('<li>No Parts Found</li>');
                            return;
                        }
                            $.each(response.part_data, function(i, item){
                                if(i%2==0){
                                    odd_even='even';
                                }else{
                                    odd_even='odd';
                                }
                                html = '<li class="block row ' + odd_even + '"><span class="name inline" id="part_data_' + item.part_id + '">' + item.part_name + '<br />manufacturer: <i>' + item.manufacturer_name + '</i><br />part: <i>' + item.part_name + '</i><br /><br />model #: <i>' + item.model_number + '</i><br /><span class="inline buttons"><i class="fa fa-close"></i><i class="fa fa-pencil" onclick="add_part(' + item.location_id + ');lookup_part_data(' + item.location_id + ')"></i><i class="fa fa-eye" onclick="show_data_sheet(' + item.location_id + ');"></i><i class="fa fa-cog" onclick="service_history(' + item.location_id + ');"></i></span><div id="chartContainer_' + item.location_id + '" class="right line-chart"></div><span class="ajax"></span></span><span class="qrcode inline"><img src="/QRCodeCreator/create/' + item.location_id + '" /><i class="fa fa-print" onclick="print_qrcode(' + item.location_id + ');"></i></span></li>';
                                $('#content_box > ul.parts').append(html); 
                            })
                            
                    }
                });
}                
function find_parts(uid){
 
    
      $.ajax({
         url: '/ajax/find_parts',
         data: { uid: uid},
         dataType: 'html',
         type: 'post',
        beforeSend: function() {
            $('#content_box').html('<img src="public/images/loading.gif" class="loading" />').fadeIn();
        },         
         success: function(response){
             
             
            $('#content_box').html(response + '<ul class="parts"></ul>');
            //find_parts_json();
             
         }   
      })
}  
function get_parts(uid){
    data = $('#registration_form').serialize();
      $.ajax({
         url: '/ajax/get_parts',
         data: { uid: uid, search_data: data },
         dataType: 'json',
         type: 'post',
         success: function(response){
            $('#content_box ul.parts').html('');
            if(response.part_data.length==0){
                $('#content_box ul.parts').html('<li>No Parts Found</li>');
                return;
            }    
             $.each(response.part_data, function(i, item){
                if(i%2==0){
                    odd_even='even';
                }else{
                    odd_even='odd';
                }
                html = '<li class="block row ' + odd_even + '"><span class="name inline" id="part_data_' + item.location_id + '">' + item.location_name + '<br />' + item.part_name + '<br />company: <i>' + item.company_name + '</i><br />client name: <i>' + item.customer_name + '</i><br />manufacturer: <i>' + item.manufacturer_name + '</i><br />part: <i>' + item.part_name + '</i><br />serial #: <i>' + item.serial_number + '</i><br />model #: <i>' + item.model_number + '</i><br />install date: <i>' + item.install_date + '</i><br />last service date: <i>' + item.last_service_date + '</i><br /><span class="inline buttons"><i class="fa fa-close"></i><i class="fa fa-pencil" onclick="add_part(' + item.location_id + ');lookup_part_data(' + item.location_id + ')"></i><i class="fa fa-eye" onclick="show_data_sheet(' + item.location_id + ');"></i><i class="fa fa-cog" onclick="service_history(' + item.location_id + ');"></i></span><div id="chartContainer_' + item.location_id + '" class="right line-chart"></div><span class="ajax"></span></span><span class="qrcode inline"><img src="/QRCodeCreator/create/' + item.location_id + '" /><i class="fa fa-print" onclick="print_qrcode(' + item.location_id + ');"></i></span></li>';
                $('#content_box > ul.parts').append(html); 
/*var jsdata = {};
$.each(item.json, function(j, js){
    [{
		type: "line",
		showInLegend: true,
		name: "Projected Sales",
		markerType: "square",
		xValueFormatString: "DD MMM, YYYY",
		color: "#F08080",
		yValueFormatString: "#,##0K",
		dataPoints: [
			{ x: new Date(2017, 10, 1), y: 63 },
			{ x: new Date(2017, 10, 2), y: 69 },
			{ x: new Date(2017, 10, 3), y: 65 },
			{ x: new Date(2017, 10, 4), y: 70 },
			{ x: new Date(2017, 10, 5), y: 71 },
			{ x: new Date(2017, 10, 6), y: 65 },
			{ x: new Date(2017, 10, 7), y: 73 },
			{ x: new Date(2017, 10, 8), y: 96 },
			{ x: new Date(2017, 10, 9), y: 84 },
			{ x: new Date(2017, 10, 10), y: 85 },
			{ x: new Date(2017, 10, 11), y: 86 },
			{ x: new Date(2017, 10, 12), y: 94 },
			{ x: new Date(2017, 10, 13), y: 97 },
			{ x: new Date(2017, 10, 14), y: 86 },
			{ x: new Date(2017, 10, 15), y: 89 }
		]
	},
	{
		type: "line",
		showInLegend: true,
		name: "Actual Sales",
		lineDashType: "dash",
		yValueFormatString: "#,##0K",
		dataPoints: [
			{ x: new Date(2017, 10, 1), y: 60 },
			{ x: new Date(2017, 10, 2), y: 57 },
			{ x: new Date(2017, 10, 3), y: 51 },
			{ x: new Date(2017, 10, 4), y: 56 },
			{ x: new Date(2017, 10, 5), y: 54 },
			{ x: new Date(2017, 10, 6), y: 55 },
			{ x: new Date(2017, 10, 7), y: 54 },
			{ x: new Date(2017, 10, 8), y: 69 },
			{ x: new Date(2017, 10, 9), y: 65 },
			{ x: new Date(2017, 10, 10), y: 66 },
			{ x: new Date(2017, 10, 11), y: 63 },
			{ x: new Date(2017, 10, 12), y: 67 },
			{ x: new Date(2017, 10, 13), y: 66 },
			{ x: new Date(2017, 10, 14), y: 56 },
			{ x: new Date(2017, 10, 15), y: 64 }
		]
	}]
    
});    */

                    $.ajax({
                        url: '/ajax/diag_json/' + item.location_id,
                        dataType:'json',
                        success: function(jsdata){
                            t=0;
                            var patt = new RegExp(/[a-z]+[0-9]+?$/i);
                            $.each(jsdata.services, function(j, js){
                               
                               var dataPoints = []
                               var title;
                                   $.each(js, function(o, row){
                                       
                                       dataPoints[o] = {}
                                       $.each(row, function(o2, row2){
                                            if(row2){
                                                dates = o2.split(' ')[0].split('-')
                                                dataPoints[o].x = new Date(dates[0], dates[1], dates[2], o2.split(' ')[1].split(':')[0], o2.split(' ')[1].split(':')[1]);
                                                    var val = Number(row2.toString().replace(/[a-z]+([0-9]+)?$/i, ''));
                                                    var title = row2.toString().replace(/^[0-9]+/i, '')
                                                    console.log(title)
                                                    dataPoints[o].y = val;
                                            }
                                       });
                                   });  
                                  console.log(JSON.stringify(dataPoints))
                                 
                                var options = {
                                    animationEnabled: true,
                                    theme: "light2",
                                    title:{
                                        text: j
                                    },
                                    axisX:{
                                        valueFormatString: "DD MMM YYYY"
                                    },
                                    axisY: {
                                        title: title,
                                        suffix: ""
                                    },
                                     
                                    legend:{
                                        cursor:"pointer",
                                        verticalAlign: "bottom",
                                        horizontalAlign: "left",
                                        dockInsidePlotArea: true,
                                        itemclick: toogleDataSeries
                                    },
                                   data: [{
                                            type: "line",
                                            showInLegend: true,
                                            name: j,
                                            markerType: "circle",
                                            xValueFormatString: "DD MMM, YYYY HH:MM",
                                            color: "#F08080",
                                            yValueFormatString: "#,##0K",
                                            dataPoints: dataPoints
                                   }]
                                
                                };
                                $("#chartContainer_" + item.location_id ).append('<div id="chart-' + t + '" alt="' + t + '" class="chart-holder-box"></div>')
                                
                                $("#chartContainer_" + item.location_id + ' #chart-' + t ).CanvasJSChart(options);
                               t++;
                            });
                            $("#chartContainer_" + item.location_id ).append('<i class="fa fa-arrow-right" onclick="nav_diagnostics();"></i>');
                        }
                    });  
                    function toogleDataSeries(e){
                        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                            e.dataSeries.visible = false;
                        } else{
                            e.dataSeries.visible = true;
                        }
                        e.chart.render();
                    }


                 
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
        beforeSend: function() {
            $('#content_box').html('<img src="public/images/loading.gif" class="loading" />').fadeIn();
        },         
         success: function(response){
             $('#content_box').html(response);
             if($('#email_form').length>0){
                  return;
             }
             get_parts($('#user_id').val());
              $('.search_parts input.name, .search_parts input.number').click(function(){
                            $('.search_parts input.name, .search_parts input.number').each(function(i, item){
                                var id=$(this).attr('id');
                            
                                if(id=='serial_number'){
                                    return;
                                }   
                                $(this).keydown(function(){
                                    $('#' + id.replace(/name$/ig, 'id') ).remove();
                                })
                                
                                
                                
                            
                                

                            
                                                                    $('#' + id).autocomplete({
                                                                                minLength: 1,
                                                                                source: '/ajax/product_lookup/' + id + '/',
                                                                                focus: function( event, ui ) {
                                                                                
                                                                                return false;
                                                                                },
                                                                                select: function( event, ui ) {
                                                                                    patt = new RegExp(/(name)$/ig);
                                                                                        if(id.match(patt)){
                                                                                            if($('#' + id.replace(/name$/ig, 'id') ).length>0){
                                                                                                $('#' + id.replace(/name$/ig, 'id') ).remove();
                                                                                            }   
                                                                                          $(this).after('<input type="hidden" id="' + id.replace(/(name)$/ig, 'id') + '" name="' + id.replace(/(name)$/ig, 'id') + '" value="" class="hidden" />');   
                                                                                        }
                                                                                        $('#' + id).val(ui.item.value);
                                                                                        $('#' + id.replace(/name$/ig, 'id') ).val(ui.item.id);  
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
                })     
         }
  });      
}  
function delete_image(iid, confirmed){
    if(!confirmed){
        $.ajax({
              url :'/ajax/delete_image/' + iid,
               success: function (response){
                   alert(response);
                   $('#closeBtn').attr('href', 'javascript:;');
                   $('#closeBtn').attr('onclick', 'delete_image(' + iid + ',' + 1 + ');')
               }
        });
    }else{
         $.ajax({
              url :'/ajax/delete_image/' + iid + '/1',
               success: function (response){
                   $('.thumbnail[alt="' + iid + '"]').remove();
                   $('#modalContainer').remove();
               }
        });
        
    }
}    
                   
    
function createUploaderProduct(elem, type, model_number, lid){ 
    if(elem.length==0){
        return;
    }
            var ajaxuploader = new qq.FineUploader({
                element: document.getElementById(elem),
                template: 'qq-template-gallery',
                multiple: false,
              //  ios: true,
             //   allowXdr: true,
             //   sendCredentials: true,
                
                request: {
                    forceMultipart: true,
                    params: {  which: type, table: 'part_photos', 'model_number':  model_number},
                    endpoint: "/Uploader/upload_product"
                },
                thumbnails: {
                    placeholders: {
                        waitingPath: '/public/js/placeholders/waiting-generic.png',
                        notAvailablePath: '/public/js/placeholders/not_available-generic.png'
                    }
                },
                validation: {
                    allowedExtensions: ['jpeg', 'jpg', 'gif', 'png', 'avi', 'pdf']
                },
                onComplete: function(response){
                    alert(lid)
                  $.ajax({
                          url: '/ajax/product_photos/' + lid,
                          cache: false,
                          dataType: 'json',
                          success: function(response){
                            $('#image_uploader').replace(response);
                          }
                      });    
                }, 
                onError: function(response){
                
                
                }

            });           
        }
       
function part_submit(){
    $.ajax({
        url: '/ajax/part_submit',
       
        type: 'post',
        data: $('#registration_form').serialize(),
         dataType: 'html',
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
        url: '/main/login?ajax_set=1',
        
        type: 'get',
         dataType: 'html',
        cache: false,
        beforeSend: function() {
            $('#content_box').html('<img src="public/images/loading.gif" class="loading" />').fadeIn();
        },
        success: function(response){
            //alert(1)
          $('#content_box').html(response);
          
        }
      });  
    
}

function ajax_register(){
      $.ajax({
        url: '/main/register?ajax_set=1',
        
        type: 'get',
         dataType: 'html',
        cache: false,
        beforeSend: function() {
            $('#content_box').html('<img src="public/images/loading.gif" class="loading" />').fadeIn();
        },        
        success: function(response){
            //alert(1)
          $('#content_box').html(response);
          
        }
      });  
    
}
function ajax_recover(){
      $.ajax({
        url: '/main/forgot?ajax_set=1',
        
        type: 'post',
        data: $('#recover').serialize(),
         dataType: 'html',
        cache: false,
        beforeSend: function() {
            $('#content_box').html('<img src="public/images/loading.gif" class="loading" />').fadeIn();
        },        
        success: function(response){
            //alert(1)
          $('#content_box').html(response);
          
        }
      });  
    
}
function lookup_geo_location(){
      // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            //alert(pos.lat)
            if($('#latitude').val() == '' & $('#longitude').val() == ''){
                $('#latitude').val(pos.lat);
                $('#longitude').val(pos.lng);
            }
          }, function() {
            handleLocationError();
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError();
        }
      
}      
function add_part(serial_no){
    
    $.ajax({
        url: '/ajax/add_part/' + serial_no,
        
        type: 'get',
         dataType: 'html',
        cache: false,
        success: function(response){
            //alert(1)
          $('#content_box').html(response);
          if($('#image-uploader').length >0 ){
            createUploaderProduct('image-uploader', 'product', $('#model_number').val(), $('#location_id').val());
          }
        lookup_geo_location();

    

          $('input.name, input.number').each(function(i, item){
            var id=$(this).attr('id');
            if(id=='serial_number'){
                return;
            }   
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
