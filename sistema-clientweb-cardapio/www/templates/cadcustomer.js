function loadCountryCli(){
   var ausername = getCookie("username");
   var apassword = getCookie("password");
   var aurl = '';
   if(ausername != '' && apassword !=''){
     aurl =  './index?dwmark:dwcbpaises';
    }
   $.ajax({
                   type: "post",
                   url: aurl,
                   contentType: false,
                   data: jQuery.param({username: getCookie("username"), password: getCookie("password")}),
                   contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                   success: function (data) {
					                         $select = $('#JOB_COUNTRYCLI');
											 $.each(data, function(key, value) {
																				var i = value.UF;
																				var b = value.COUNTRY;
																				$select.append( $("<option value=" + i + ">" + b + "</option>"));
																				});
                   },
                   error: function(result) {
                             swal("Atenção", "Erro na autenticação.", "warning");
                   }
			});
}

function newClientes(){
       var mydiv = document.getElementById("dataFrame");
       var mydt  = document.getElementById("employeeresult");
	   loadClientes();
	   $('#employeeresult').hide();
       mydt.style.visibility="hidden";
	   $("#CUSTOMER").val('');
       $("#CONTACT_FIRST").val('');
       $("#CONTACT_LAST").val('');
       $("#PHONE_NO").val('');
	   loadCountryCli();
       $("#JOB_COUNTRYCLI").val('');
	   $("#ADDRESS_LINE1").val('');
       $("#POSTAL_CODE").val('');
       $('.operacao').val('insert');
       mydiv.style.visibility="visible";
       $('#dataFrame').slideDown("slow");
};
 
function loadClientes(){
 MyHtml("cadCustomer");
};
 
function myActionCli(id){
   var url = '';
   var myParams = {username: getCookie("username"),
                              password: getCookie("password")};
    if(id != '' && id !=undefined && id != null){
        url =  './www/index?dwmark:editmodal&id='+id;
    } else {
       url = './www/index?dwmark:editmodal';
    }

   $('#SAVE').attr('idd',id);
   $.getJSON(
                     url,
                     myParams,
                     function(j){
                                 var mydiv = document.getElementById("dataFrame");
                                 var mydt  = document.getElementById("employeeresult");
                                 $('#employeeresult').hide();
                                 mydt.style.visibility="hidden";
                                      if(j.length > 0){
                                       for (var i = 0; i < j.length; i++) {
                                        $("#CUSTOMER").val(j[i].CUSTOMER);
                                        $("#CONTACT_FIRST").val(j[i].CONTACT_FIRST);
                                        $("#CONTACT_LAST").val(j[i].CONTACT_LAST);
                                        $("#PHONE_NO").val(j[i].PHONE_NO);
										$("#ADDRESS_LINE1").val(j[i].ADDRESS_LINE1);
										loadCountry();
                                        $("#JOB_COUNTRYCLI").val(j[i].JOB_COUNTRY);
                                        $("#POSTAL_CODE").val(j[i].POSTAL_CODE);
                                        $('.operacao').val('edit');
                                       }
                                        mydiv.style.visibility="visible";
                                        $('#dataFrame').slideDown("slow");
                                      } else {
                                      reloadDatatable(true);
                                      }
          });
  
};

function cancelClientes(){
  reloadDatatable(true);
};

function canceldeleteCli(){
    $('#modal_apagar').modal('hide');
};

function myActionCli(id, name){
      $('#nome_empregado').html(name);
      $('#ok').attr('idd', id);     
      $('#modal_apagar').modal('show');     
};

function deleteClientes(){
     var id = $(this).attr('idd');
     $.ajax(
                {
                    type: "post",
                    contentType: false,                    
                    data: {username: getCookie("username"),
                              password: getCookie("password")},
                    url: './www/index?dwmark:operation&id='+id+'&operation=delete',
                    success: function (data) {
                        if (data) {
                            $('#modal_apagar').modal('hide');
                            reloadDatatable();
                            reloadDatatable(true);
                        } else {
                                    swal("Erro...", "Não foi possível excluir o registro", "error");                            
                        }
                    }
     });
};

function saveClientes(){
    var id = $(this).attr('idd');
    var sendInfo = {
                             username: getCookie("username"),
                             password: getCookie("password"),
                             CUSTOMER:$("#CUSTOMER").val(),
                             CONTACT_FIRST:$("#CONTACT_FIRST").val(),
                             CONTACT_LAST:$("#CONTACT_LAST").val(),
                             PHONE_NO:$("#PHONE_NO").val(),
							 ADDRESS_LINE1:$("#ADDRESS_LINE1").val(),
                             JOB_COUNTRY:$("#JOB_COUNTRY").val(),
                             POSTAL_CODE:$("#POSTAL_CODE").val(j[i].POSTAL_CODE)
					};
       $.ajax({
           type: "POST",
           url: './www/index?dwmark:operation&id='+id,
           contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
           dataType: "json",
           data: sendInfo,
           success: function (msg) {
                    if (msg) {
                         if($('.operacao').val('edit') == 'edit'){
                           swal("Sucesso", "Empregado editado com sucesso", "warning");                               
                         }else{
                           swal("Sucesso", "Cadastro realizado com sucesso", "warning");
                         }
                    reloadDatatable();
                    reloadDatatable(true);
                   }
                 else {
                           swal("Erro...", "Não foi possível finalizar a operação", "error");
               }
		   }});
};