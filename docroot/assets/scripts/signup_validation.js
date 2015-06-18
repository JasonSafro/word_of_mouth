jQuery(document).ready(function(){    
    $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[0-9a-zA-Z ]+$/.test(value);
    }, "Alphanumeric only.");
    
    $.validator.addMethod("emailValidate", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,6}$/i.test(value);
    }, "Please enter a valid email address.");
    
    $.validator.addMethod("unameRegex", function(value, element) {
        return this.optional(element) || /^[0-9a-zA-Z ]{0,32}$/.test(value);
    }, "Alphanumeric only.");
    
    $.validator.addMethod("noSpace1", function(value, element) { 
        return value.indexOf(" ") < 0 && value != ""; 
    }, "Space are not allowed");
  
    $.validator.addMethod("pwdRegex1", function(value, element) {
        return this.optional(element) || /^[0-9a-zA-Z ]{6,12}$/.test(value);
    }, "Password field must be at least 6 to 12 characters in length.");
    
    /* #################### User Signup Form Validation Functionality Start (views/services_view.php)###################### */
    $("#frmSignup_basic").validate({
        errorElement: 'div',            
        highlight: function (element, errorClass, validClass) {
            return false;  // ensure this function stops
        },
        unhighlight: function (element, errorClass, validClass) {
            return false;  // ensure this function stops
        },
        rules: {
            username:{
                required: true, 
                unameRegex:true, 
                noSpace1:true,
                remote: {
                    url: SITE_URL+"services/check_uname_dup",
                    type: "post",
                    data: {
                        username: function() 
                        {                                                                                                                     
                            return $("#username").val();
                        }
                    }
                }
            },
            user_password:{
                required: true,
                loginRegex: true,
                pwdRegex:true
                                                                                                
            },
            cpassword:{
                required: true,
                loginRegex: true,
                equalTo:'#user_password'
            },
            user_email:{
                required: true,
                emailValidate:true,
                remote: {
                    url: SITE_URL+"services/check_email_dup",
                    type: "post",
                    data: {
                        user_email: function() {
                            return $("#user_email").val();
                        }
                    }
                }
            },
            fname: {
                required: true
            },
            lname: {
                required: true
            },
            address: {
                required: true
            },
            zip_code:{
                required: true
            },
            city: {
                required: true
            }, 
            userState: {
                required: true
            }, 
            Items: {
                required: true
            }
			
        },
        messages: {	
				
            username:{
                required :"Please enter Username", 
                unameRegex:"Alphanumeric, 4 to 32 characters only",
                remote:"This Username is already in use."
            },
            user_password:{
                required :"Please enter Password"
            },
            cpassword:{
                required :"Please Repeat Your Password"
            },
            user_email:{
                required: "Please enter email",                                                                                                
                remote:"This email is already in use."
            },
            fname: {
                required: "Please enter First Name"
            },
            lname: {
                required: "Please enter Last Name"
            },
            address: {
                required: "Please enter Address"
            },
            zip_code:{
                required: "Please enter Zip Code"
            },
            city: {
                required: "Please enter City"
            }, 
            Items: {
                required: "Please Select Country"
            },
            userState: {
                required: "Please Select State"
            }
                                              
                                                
                        
        },
        success: function(label) {                                        
        //label.html("&nbsp;").addClass("error");
        }               
    });
            
    /* #################### User Signup Form Validation Functionality End ###################### */  
             
             
    /* #################### User Bussiness Signup Form Validation Functionality Start (views/services_view.php)###################### */
             
    $("#frmSignup_buss_basic").validate({
        errorElement: 'div',            
        highlight: function (element, errorClass, validClass) {
            return false;  // ensure this function stops
        },
        unhighlight: function (element, errorClass, validClass) {
            return false;  // ensure this function stops
        },
        rules: {
            buss_name:{
                required: true
            },
            buss_cont_name:{
                required: true
                                                                                                
            },
            buss_addr: {
                required: true
            },
            buss_city: {
                required: true
            },
            buss_zipcode: {
                required: true
            },
            buss_phone:{
                                                                                               
            },
            buss_fax: {
                                                                                               
            }, 
            buss_web_addr: {
                                                                                               
            }, 
            buss_email_addr:{
                required: true,
                emailValidate:true                                                                                                
            },
            buss_lice_num: {
                                                                                            
            },
            buss_sco_one:{},
            buss_sco_two:{},
            buss_sco_three:{},
            buss_sco_four:{}
                                                
			
        },
        messages: {	
				
            buss_name:{
                required :"Please enter Business Name"
                                                                                               
            },
            buss_cont_name:{
                required :"Please enter Contact Name"
            },
            buss_addr: {
                required: "Please enter Address"
            },
            buss_city: {
                required: "Please enter City"
            },
            buss_zipcode: {
                required: "Please enter Zip code"
            },
            buss_phone:{
                                                                                               
            },
            buss_fax: {
                                                                                               
            }, 
            buss_web_addr: {
                                                                                               
            }, 
            buss_email_addr:{
                required: "Please enter Email ",
                emailValidate:"Please enter valid Email"                                                                                                
            },
            buss_lice_num: {
                                                                                            
            },
            buss_sco_one:{},
            buss_sco_two:{},
            buss_sco_three:{},
            buss_sco_four:{}
                                              
                                                
                        
        },
        success: function(label) {                                        
        //label.html("&nbsp;").addClass("error");
        }               
    });
             
/* #################### User Bussiness Signup Form Validation Functionality End ###################### */  
          
}); // end document.ready