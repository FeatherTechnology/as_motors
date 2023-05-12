// Document is ready
$(document).ready(function () {
	
	// Validate username
	$('#usernamecheck').hide();	
	let usernameError = true;
	$('#lusername').keyup(function () {		
	validateusername();
	});
	
	function validateusername() {
		let usernameValue = $('#lusername').val();	
		if (usernameValue.length == '') {
		$('#usernamecheck').show();
		usernameError = false;
			return false;
		}
		else {
			$('#usernamecheck').hide();
			usernameError = true;	
		}
	}


	// Validate password
	$('#passwordcheck').hide();	
	let passwordError = true;
	$('#lpassword').change(function () {	
	validatepassword();
	});

	function validatepassword() {
		let passwordValue = $('#lpassword').val();	
		if (passwordValue.length == '') {
		$('#passwordcheck').show();
		passwordError = false;
			return false;
		}
		else {
			$('#passwordcheck').hide();
			passwordError = true;	
		}
	}
// Validate Branch
$('#companycheck').hide();	
let companyError = true;
$('#company').change(function () {	
validatecompany();
});

function validatecompany() {
let companyValue = $('#company').val();	
if (companyValue.length == '') {
$('#companycheck').show();
companyError = false;
	return false;
}
else {
	$('#companycheck').hide();
	companyError = true;	
}
}
	// Submit Button Onclick
	$('#lbutton').click(function () {				
		validateusername();					
		validatepassword();	
		validatecompany();		


		if (usernameError == true && passwordError == true && companyError == true) 
			{	
			return true;
			} 
			else 
			{
			return false;
			}
	});
	

});

	