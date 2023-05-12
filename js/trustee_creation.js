// Document is ready
$(document).ready(function () {
	
   	// Validate trust name
	$('#trusteenameCheck').hide();	
	let trusteenameError = true;
	$('#trustee_name').change(function () {	
		validateTrusteeName();
	});

	function validateTrusteeName() { 
		let trusteenameValue = $('#trustee_name').val();	
		if (trusteenameValue.length == '') {
			$('#trusteenameCheck').show();
			trusteenameError = false;
			return false;
		}
		else {
			$('#trusteenameCheck').hide();
			trusteenameError = true;	
		}
	}

	// Validate Mobile No
	$('#mobilenumbercheck').hide();  
	$("#mobilenumbercheck1").hide();
	let mobilenumbererror = true;
	$('#contact_no').keyup(function () {
		var contact_no = $('#contact_no').val(); 
		if(contact_no.length == 10){
		$.ajax({
			url: "ajax_getTrusteeEmailUnique.php",
			data: {"contact_no":contact_no},
			cache: false,
			type: "post",
			dataType: "json",
			success: function (data) {
			if(data == 1){
			$("#mobilenumbercheck").hide();
			$("#mobilenumbercheck1").show();
			mobilenumbererror = false;
			}
			else if(data == 0){
			$("#mobilenumbercheck1").hide();
			mobilenumbererror = true;
			}
			}
		});
		}if(contact_no.length != 10){
			$("#mobilenumbercheck1").hide();
			$('#mobilenumbercheck').show();
			mobilenumbererror = false;
		}   
		validateMobileNumber();
	});

	function validateMobileNumber(){

		var contact_no = $('#contact_no').val(); 
		if(contact_no.length < 10){
			$("#mobilenumbercheck1").hide();
			$('#mobilenumbercheck').show();
			mobilenumbererror = false;
			return false;
		}
		else
		{
			$('#mobilenumbercheck').hide();
			$.ajax({
				url: "ajax_getTrusteeEmailUnique.php",
				data: {"contact_no":contact_no},
				cache: false,
				type: "post",
				dataType: "json",
				success: function (data) {
					if(data == 1){
						$('#mobilenumbercheck').hide();
						$("#mobilenumbercheck1").show();
						mobilenumbererror = false;
					}else if(data == 0){
						$('#mobilenumbercheck').hide();
						$("#mobilenumbercheck1").hide();
						mobilenumbererror = true;
					}
				}
			});
		} 
	}

	// Validate Address 1
	$('#address1Check').hide();	
	let address1Error = true;
	$('#address1').change(function () {	
		validateAddress1();
	});

	function validateAddress1() {
		let address1Value = $('#address1').val();	
		if (address1Value.length == '') {
			$('#address1Check').show();
			address1Error = false;
			return false;
		}
		else {
			$('#address1Check').hide();
			address1Error = true;	
		}
	}

	// Validate Place
	$('#placeCheck').hide();	
	let placeError = true;
	$('#place').change(function () {	
		validatePlace();
	});

	function validatePlace() {
		let placeValue = $('#place').val();	
		if (placeValue.length == '') {
			$('#placeCheck').show();
			placeError = false;
			return false;
		}
		else {
			$('#placeCheck').hide();
			placeError = true;	
		}
	}


	// Validation Pincode
	$("#pincodeCheck").hide();
	var pincodeError = true;
	$("#pincode").keyup(function () {
		validatePincode();
	});
	function validatePincode() {
		let pincodeValue = $("#pincode").val();
		if(pincodeValue == ''){
			$("#pincodeCheck").show();
			pincodeError = false;
		}
		else if(pincodeValue.length != 6){
			$("#pincodeCheck").show();
			pincodeError = false;
			return false;
		}
		else{
			$("#pincodeCheck").hide();
			pincodeError = true;
		}
	}

	// Validate Email
	$("#emailidCheck").hide();
	let emailidError = true;
	$("#email_id").keyup(function() {
		validateEmail();
	});
	function validateEmail() {
		var email_id = $('#email_id').val(); 
		var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
		
		if(email_id.length == ''){ 
			$("#emailidCheck").show();
			emailidError = false;
		} 
		else if (!re.test(email_id)) {
			$("#emailidCheck").show();
			emailidError = false;
			return false;
		}else{
			$("#emailidCheck").hide();
			emailidError = true;
		}
	}

    // Validate PAN
    $('#panCheck').hide();	
    let panError = true;
    $('#pan_no').keyup(function () {			
        this.value = this.value.toUpperCase();
        validatePAN();
    });
    function validatePAN() {
        let panValue = $('#pan_no').val();
        var regpan = /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;

        if (!(panValue.match(regpan))) {
        $('#panCheck').show();
        panError = false;
            return false;
        }	
        else {
            $('#panCheck').hide();
            panError = true;
        }
    }

	// Submit Button 
	$('#submitTrusteeCreation').click(function () {	
        validateTrusteeName();	
        validateMobileNumber();
		validateAddress1();
		validatePlace();
		validatePincode();
		validateEmail();	
		validatePAN();	

		if(trusteenameError == true && mobilenumbererror == true && address1Error == true && placeError == true && pincodeError == true && emailidError == true 
            && panError == true ){    
			return true;
        } 
        else 
        {
            return false;
        }
	});
	

});

	