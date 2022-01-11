//Date of Birth 
$(function() {
    $('.dob').daterangepicker({
         singleDatePicker: true,
         showDropdowns: true,
          maxDate: new Date(),		 
		 opens: "right",
		 drops: "down"
    });
	
	
	 // shop opening time
 $('#shopopening_time').timepicker({
	   showPeriod: true,
       showLeadingZero: true
        
   });
   //shop closing time
   $('#shopclosing_time').timepicker({
        showPeriod: true,
       showLeadingZero: true 
   });
	
	
	
	
	
	
    });
		
			 