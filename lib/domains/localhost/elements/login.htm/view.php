<script type="text/javascript">
$(document).ready(function()
{   
    $("#username").focus();
	$("#login_form").submit(function()
	{
		$("#msgbox").removeClass().addClass('messagebox').text('Validating....').fadeIn(1000);
		$.post(<? echo '\'' . urlRequest() . '\''; ?>,{ username:$('#username').val(),password:$('#password').val(),rand:Math.random() } ,function(data)
        {
		  if(data=='yes') //if correct login detail
		  {
		      $("#login_form").hide();
		      $("#message").html("<h1>Initializing Session</h1>");
              $("#message").css('color','green');
              setTimeout("locationhome()",3000);
		  }
		  if(data=='no') 
		  {
		      $("#login_form").hide();
		      $("#message").html("<h1>Invalid Details</h1>");
              $("#message").css('color','red');
              setTimeout("locationlogin()",3000);		
          }
				
        });
 		return false;
	}); 
	$("#password").blur(function()
	{
		$("#login_form").trigger('submit');
	});
});

function locationhome () {
    window.location.replace("<? echo url('home');?>");
}

function locationlogin() {
    window.location.replace("<? echo url('login');?>");
}

</script>
<h1>Royal Square Login</h1>
<div id="msgbox"></div>
<form method="post" action="" id="login_form">
<input name="username" type="text" id="username" value="" maxlength="20" /><br /><br />
<input name="password" type="password" id="password" value="" maxlength="20" /><br /><br />
<input name="Submit" type="submit" id="submit" value="Login" />
</form >
<div id="message"></div>