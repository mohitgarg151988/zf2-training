function confirmDelete (){
	if(confirm('Do you want to delete this record?')) 
		return true; 
	else 
		return false;
}

function editEmployeeData(id, pageNumber) {
   var url = '/employee/employee/add';
  	//return false;
   jQuery.ajax({
       url: url,
       type: 'GET',
       dataType: 'html',
       data: {'id': id, 'page' : pageNumber},
       success: function(result){
           jQuery('#modelDialog').html('<div class="modal-dialog"><div class="modal-content"></div></div>');
           jQuery('#modelDialog').find('.modal-content').html(result);
           $( "#modelDialog" ).modal('show');
       },
       error: function(data, status){
           jQuery('#modelDialog').html('<p>ERROR OCCURRED</p>');
           $( "#modelDialog" ).modal('show');
       }
   });
  return false;
}

function customSave(){
	
	var url = '/employee/employee/add';
	//console.log($('#id').val(),$('#empId').val(),$('#empEmail').val(),$('#empRole').val());
	//return false;
	jQuery.ajax({
       url: url,
       type: 'POST',
       data: {
    	   'id' : $('#id').val(),
    	   'page' : $('#pageNumber').val(),
    	   'empId' : $('#empId').val(),
    	   'empEmail': $('#empEmail').val(),
    	   'empRole': $('#empRole').val(),
       },
       success: function(result){
    	   if(typeof result == "object") {
    		   if(result.success) {
                	window.location.replace("/employee/employee/index/"+$('#id').val()+"/"+$('#pageNumber').val());
               }
               else {
            	   return false;
               }
           }
           else {
               $(".modal-content").html(result);
           }	    	    	    	  
       },
       error: function(data, status){
           return false;
       }
   });
	
}


function closeModal(){
    jQuery('#modelDialog').modal('hide');
    return false;
}