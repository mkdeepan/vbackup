var FormWizard = function () {
	"use strict";
	 $("#reg-submit").attr("disabled", true);
	 var limit = 100;
 	 var end_date = (new Date).getFullYear();
 	 var start_date = end_date - limit; 
 	 var currentYear = (new Date).getFullYear();
 	 var currentMonth = (new Date).getMonth()+1;  
 	 var currentDay = (new Date).getDate(); 
    var wizardContent = $('#wizard');
    var wizardForm = $('#form');
    var numberOfSteps = $('.swMain > ul > li').length;
    var initWizard = function () {
        // function to initiate Wizard Form
        wizardContent.smartWizard({
            selected: 0,
            keyNavigation: false,
            onLeaveStep: leaveAStepCallback,
            onShowStep: onShowStep,
        });
        var numberOfSteps = 0;
        initValidator();
    };
    
    $('#terms_cond').click(function(){
    	if($('#terms_cond').is(':checked')){
    		$("#reg-submit").removeAttr("disabled");
    	}else{
    		$("#reg-submit").attr("disabled", true);
    	}
    });
     
    var initValidator = function () {
        
        $.validator.setDefaults({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
                    error.insertAfter($(element).closest('.form-group').children('div').children().last());
                } else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
                    error.insertAfter($(element).closest('.form-group').children('div'));
                } else {
                    error.insertAfter(element);
                    // for other inputs, just perform default behavior
                }
            },
            ignore: ':hidden:not(".agender")',
            rules: {
                afname: {
                    minlength: 2,
                    alpha:true,
                    required: true
                },
                alname: {
                    alpha:true,           
                    required: true
                },
                amobile: {                   
                    required: true
                },
                agender: {                    
                    required: true
                },
                acountry: {                    
                    required: true
                },
                 aemail: {
                    required: true,
                    email: true,
                    remote:{
								url: "http://192.168.1.58/vbackup/login/checkEmail",
								type: "post",
								data: {
									username: function() {
									  return $( "#aemail" ).val();
									}
								}
							}
                },
                apassword: {
                    minlength: 6,
                    required: true,
                    pwcheck:true
                },
                apassword2: {
                    required: true,
                    minlength: 6,
                    equalTo: "#apassword"
                },
                pfname: {
                	  alpha:true,
                    minlength: 2,
                    required: true
                },
                pmname:{
                	alpha:true
                },
                plname: {
                	  alpha:true,                  
                    required: true
                },
                pbday: {
                	  day:true,
                    number: true,
                    required: true,
                    cday:true
                },
                pbmonth: {
                    number: true,
                    required: true,
                    range:[1,12],
                    cmon:true
                },
                pbyear: {
                    number: true,
                    required: true,
                    range:[start_date,end_date]
                },
                pmobile: {                    
                    required: true
                },
                pgender: {                    
                    required: true
                },               
                pemail: {
                    required: true,
                    email: true
                }
                
            },
            messages: {
            	afname: {                 
                    alpha:"Only alphabets are allowed",
                    required: "You can't leave this empty"
                },
                alname: {
                    alpha:"Only alphabets are allowed",                   
                    required: "You can't leave this empty"
                },
                amobile: {                   
                    required: "You can't leave this empty"
                },
                agender: {                    
                    required: "You can't leave this empty"
                },
                acountry: {                    
                    required: "You can't leave this empty"
                },
                 aemail: {
                    required: "You can't leave this empty", 
                    remote: "Email id already exist"                   
                },  
                apassword:{
                	pwcheck:"Enter atleast 1 number, 1 Uppercase, 1 Lowercase"
                },            
                apassword2: {
                    required: "You can't leave this empty"                  
          
                },
                pfname: {     
                    alpha:"Only alphabets are allowed",              
                    required: "You can't leave this empty"
                },
                pmname:{
                	alpha:"Only alphabets are allowed"
                },
                plname: {    
                    alpha:"Only alphabets are allowed",
                    required: "You can't leave this empty"
                },
                pbday: {
                	  day: "Not a valid day",
                    number: "Only digits are allowed",
                    required: "You can't leave this empty",
                    cday:"Not a valid day"
                },
                pbmonth: {
                    number: "Only digits are allowed",
                    required: "You can't leave this empty",
                    cmon: "Not a valid month",
                },
                pbyear: {
                    number: "Only digits are allowed",
                    required: "You can't leave this empty"
                },
                pmobile: {                    
                    required: "You can't leave this empty"
                },
                pgender: {                    
                    required: "You can't leave this empty"
                },               
                pemail: {
                    required: "You can't leave this empty",
                    email: "Enter valid email address"
                }
                
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
            }
        });
    };
    var displayConfirm = function () {
        $('.display-value', form).each(function () {
            var input = $('[name="' + $(this).attr("data-display") + '"]', form);
            if (input.attr("type") == "text" || input.attr("type") == "email" || input.is("textarea")) {
                $(this).html(input.val());
            } else if (input.is("select")) {
                $(this).html(input.find('option:selected').text());
            } else if (input.is(":radio") || input.is(":checkbox")) {

                $(this).html(input.filter(":checked").closest('label').text());
            } else if ($(this).attr("data-display") == 'card_expiry') {
                $(this).html($('[name="card_expiry_mm"]', form).val() + '/' + $('[name="card_expiry_yyyy"]', form).val());
            }
        });
    };
    var assignReview = function (){
    	var afname = $('#afname').val();
    	var alname = $('#alname').val();
    	var aemail = $('#aemail').val();
    	var amobile = $('#amobile').val();
    	var pfname = $('#pfname').val();
    	var plname = $('#plname').val();
    	$('#review_acc_name').html(afname+' '+alname);
    	$('#review_acc_email').html(aemail);
    	$('#review_acc_mob').html(amobile);
    	$('#review_pro_name').html(pfname+' '+plname);
    };
    var onShowStep = function (obj, context) {
    	if(context.toStep == numberOfSteps){
    		$('.anchor').children("li:nth-child(" + context.toStep + ")").children("a").removeClass('wait');
            displayConfirm();
    	}
        $(".next-step").unbind("click").click(function (e) {
            e.preventDefault();
            assignReview();
            wizardContent.smartWizard("goForward");
        });
        $(".back-step").unbind("click").click(function (e) {
            e.preventDefault();
            wizardContent.smartWizard("goBackward");
        });
        $(".go-first").unbind("click").click(function (e) {
            e.preventDefault();
            wizardContent.smartWizard("goToStep", 1);
        });
        $(".finish-step").unbind("click").click(function (e) {
            e.preventDefault();
            onFinish(obj, context);
        });
    };
    var leaveAStepCallback = function (obj, context) {
        return validateSteps(context.fromStep, context.toStep);
        // return false to stay on step and true to continue navigation
    };
    var onFinish = function (obj, context) {
        if (validateAllSteps()) {
            alert('form submit function');
            $('.anchor').children("li").last().children("a").removeClass('wait').removeClass('selected').addClass('done').children('.stepNumber').addClass('animated tada');
            //wizardForm.submit();
        }
    };
    var validateSteps = function (stepnumber, nextstep) {
        var isStepValid = false;
        
        
        if (numberOfSteps >= nextstep && nextstep > stepnumber) {
        	
            // cache the form element selector
            if (wizardForm.valid()) { // validate the form
                wizardForm.validate().focusInvalid();
                for (var i=stepnumber; i<=nextstep; i++){
        		$('.anchor').children("li:nth-child(" + i + ")").not("li:nth-child(" + nextstep + ")").children("a").removeClass('wait').addClass('done').children('.stepNumber').addClass('animated tada');
        		}
                //focus the invalid fields
                isStepValid = true;
                return true;
            };
        } else if (nextstep < stepnumber) {
        	for (i=nextstep; i<=stepnumber; i++){
        		$('.anchor').children("li:nth-child(" + i + ")").children("a").addClass('wait').children('.stepNumber').removeClass('animated tada');
        	}
            
            return true;
        } 
    };
    var validateAllSteps = function () {
        var isStepValid = true;
        // all step validation logic
        return isStepValid;
    };
    return {
        init: function () {
            initWizard();
        }
    };
}();
