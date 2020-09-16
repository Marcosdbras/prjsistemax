function loadCountry(){
   var ausername = getCookie("username");
   var apassword = getCookie("password");
   var aurl = '';
   if(ausername != '' && apassword !=''){
     aurl =  './index?dwmark:dwcbpaises';
    }
   $.ajax(
                {
                   type: "post",
                   url: aurl,
                   contentType: false,
                   data: jQuery.param({username: getCookie("username"), password: getCookie("password")}),
                   contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                   success: function (data) {
					                         $select = $('#JOB_COUNTRY');
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

function loadJobs(){
   var ausername = getCookie("username");
   var apassword = getCookie("password");
   var aurl = '';
   if(ausername != '' && apassword !=''){
     aurl =  './index?dwmark:dwcbcargos';
    }
   $.ajax(
                {
                   type: "post",
                   url: aurl,
                   contentType: false,
                   data: jQuery.param({username: getCookie("username"), password: getCookie("password")}),
                   contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                   success: function (data) {
					                         $select = $('#JOB_GRADE');
											 $.each(data, function(key, value) {
																				var i = value.JOB_GRADE;
																				var b = value.JOB_TITLE;
																				$select.append( $("<option value=" + i + ">" + b + "</option>"));
																				});
                   },
                   error: function(result) {
                             swal("Atenção", "Erro na autenticação.", "warning");
                   }
                   });
}

function newEmployee(){
       var mydiv = document.getElementById("dataFrame");
       var mydt  = document.getElementById("employeesresut");
	   loadEmployee();
	   $('#employeesresut').hide();
       mydt.style.visibility="hidden";
       $("#FIRST_NAME").val('');
       $("#LAST_NAME").val('');
       $("#PHONE_EXT").val('');
       $("#CAD_HIRE_DATEB").val('');
       $("#JOB_GRADE").val('');
	   loadJobs();
       $("#JOB_COUNTRY").val('');
	   loadCountry();
       $("#SALARY").val('');
       $('.operacao').val('insert');
       mydiv.style.visibility="visible";
       $('#dataFrame').slideDown("slow");
};
 
function loadEmployee(){
 MyHtml("cademployee");
};
 
function myActionE(id){
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
                                 var mydt  = document.getElementById("employeesresut");
                                 $('#employeesresut').hide();
                                 mydt.style.visibility="hidden";
                                      if(j.length > 0){
                                       for (var i = 0; i < j.length; i++) {
                                        $("#FIRST_NAME").val(j[i].FIRST_NAME);
                                        $("#LAST_NAME").val(j[i].LAST_NAME);
                                        $("#PHONE_EXT").val(j[i].PHONE_EXT);
                                        $("#CAD_HIRE_DATEB").val(j[i].HIRE_DATE);
                                        loadJobs();
										$("#JOB_GRADE").val(j[i].JOB_GRADE);
										loadCountry();
                                        $("#JOB_COUNTRY").val(j[i].JOB_COUNTRY);
                                        $("#SALARY").val(j[i].SALARY);
                                        $('.operacao').val('edit');
                                       }
                                        mydiv.style.visibility="visible";
                                        $('#dataFrame').slideDown("slow");
                                      } else {
                                      reloadDatatable(true);
                                      }
          });
  
};

function cancelemployee(){
  reloadDatatable(true);
};

function canceldelete(){
    $('#modal_apagar').modal('hide');
};

function myActionD(id, name){
      $('#nome_empregado').html(name);
      $('#ok').attr('idd', id);     
      $('#modal_apagar').modal('show');     
};

function deleteemployee(){
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

function saveemployee(){
    var id = $(this).attr('idd');
    var sendInfo = {
                             username: getCookie("username"),
                             password: getCookie("password"),
                             FIRST_NAME: $("#FIRST_NAME").val(),
                             LAST_NAME: $("#LAST_NAME").val(),
                             PHONE_EXT: $("#PHONE_EXT").val(),
                             HIRE_DATE: $("#CAD_HIRE_DATEB").val(),
                              JOB_GRADE: $("#JOB_GRADE").val(),
                              JOB_COUNTRY: $("#JOB_COUNTRY").val(),
                              SALARY: $("#SALARY").val(),
                              OPERATION:  $('.operacao').val() 
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