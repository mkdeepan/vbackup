$.validator.addMethod("alpha", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
});
$.validator.addMethod("emails", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z0-9@-_.\s]+$/);
});
$.validator.addMethod("school", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z.-_\s]+$/);
});
$.validator.addMethod("day", function(value, element) {
   	var arr_months = {1:31,2:28,3:31,4:30,5:31,6:30,7:31,8:31,9:30,10:31,11:30,12:31};
	   if(parseInt($('#pbyear').val()) % 4 == 0 && $('#pbyear').val() != ""){ arr_months[2] = 29; }
    	var mon = $('#pbmonth').val(); 
      return !isNaN(value) && !(value <= 0) && !(value > arr_months[mon]);
});
$.validator.addMethod("pwcheck", function(value) {
   return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
       && /[a-z]/.test(value) // has a lowercase letter
       && /[A-Z]/.test(value) // has a lowercase letter
       && /\d/.test(value) // has a digit
});
var currentYear = (new Date).getFullYear();
 	var currentMonth = (new Date).getMonth()+1;  
 	var currentDay = (new Date).getDate(); 
 	
  $.validator.addMethod("cday", function(value, element) {
  	if(parseInt($('#pbyear').val())>currentYear)
  	{
  		return false;
  	}
   else if(parseInt($('#pbyear').val())==currentYear)
   {
   	if(parseInt($('#pbmonth').val())>currentMonth)
   	{
   		return false;
   	}
      else if(parseInt($('#pbmonth').val())==currentMonth)
      {
      	return (value <= currentDay);
      }
      else 
      return true;
   }
   else return true;
  });
  $.validator.addMethod("cmon", function(value, element) {
  	if(parseInt($('#pbyear').val())>currentYear)
  	{
  		return false;
  	}
   else if(parseInt($('#pbyear').val())==currentYear)
   {
      return (value <= currentMonth);
   }
   else return true;
  });
