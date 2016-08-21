<p>
	
<button type="button" class="btn btn-primary btn-test-mail" ><span class="glyphicon glyphicon-comment"></span> Send Test Mail</button>
</p>

<form action="" method="post" enctype="multipart/form-data">	
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Mail Setting</h3>
  </div>
  <div class="panel-body">
<div class="row">
		<div class="col-lg-12">

			<p><strong>Send mail from local system or other system :</strong></p>
		  	<p>
			<select name="mail[send_method]" id="send_method" class="form-control">
			<option value="local">From local system</option>
				<option value="account">From other system</option>

			</select>
		  	</p>
			<p>Default sender name:</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="Sender name..." name="mail[fromName]" value="<?php echo $mail['fromName'];?>" />
		  	</p>

			<p>Default sender email:</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="Sender email..." name="mail[fromEmail]" value="<?php echo $mail['fromEmail'];?>" />
		  	</p>
			<p>SMTP Address:</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="SMTP address..." name="mail[smtpAddress]" value="<?php echo $mail['smtpAddress'];?>" />
		  	</p>
			<p>Username:</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="Username..." name="mail[smtpUser]" value="<?php echo $mail['smtpUser'];?>" />
		  	</p>
			<p>Password:</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="Password..." name="mail[smtpPass]" value="<?php echo $mail['smtpPass'];?>" />
		  	</p>
			<p>SMTP Port:</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="SMTP Port..." name="mail[smtpPort]" value="<?php echo $mail['smtpPort'];?>" />
		  	</p>
			<p>New user email content: (use {email}, {username}, {fullname}, {password}, {siteurl})</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="Subject..." name="mail[registerSubject]" value="<?php echo $mail['registerSubject'];?>" />
		  	</p>			
		  	<p>
		  	<textarea rows="10" class="form-control" name="mail[registerContent]"><?php echo $mail['registerContent'];?></textarea>
		  	</p>
			<p>New user email with verify code content: (use {email}, {username}, {fullname}, {password}, {siteurl}, {verify_code})</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="Subject..." name="mail[registerConfirmSubject]" value="<?php echo $mail['registerConfirmSubject'];?>" />
		  	</p>
		  	<p>
		  	<textarea rows="10" class="form-control" name="mail[registerConfirmContent]"><?php echo $mail['registerConfirmContent'];?></textarea>
		  	</p>		  	
			<p>Forgot password email content: (use {email}, {username}, {fullname}, {password}, {siteurl}, {verify_url})</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="Subject..." name="mail[forgotSubject]" value="<?php echo $mail['forgotSubject'];?>" />
		  	</p>			
		  	<p>
		  	<textarea rows="10" class="form-control" name="mail[forgotContent]"><?php echo $mail['forgotContent'];?></textarea>
		  	</p>

			<p>Forgot password send new password email content: (use {email}, {username}, {fullname}, {password}, {siteurl})</p>
		  	<p>
		  	<input type="text" class="form-control" placeholder="Subject..." name="mail[forgotNewPasswordSubject]" value="<?php echo $mail['forgotNewPasswordSubject'];?>" />
		  	</p>			
		  	<p>
		  	<textarea rows="10" class="form-control" name="mail[forgotNewPasswordContent]"><?php echo $mail['forgotNewPasswordContent'];?></textarea>
		  	</p>

		  	<p>
		  	<button type="submit" name="btnSave" class="btn btn-info">Save Changes</button>
		  	</p>			  	

		</div>

	</div>    

  </div>
</div>
</form>
<script>

var api_email_url='<?php echo System::getUrl();?>api/system/';

var send_email_status='none';

function send_test_mail(toEmail)
{
	if(toEmail.indexOf('a')==-1)
	{
		send_email_status='none';

		alert('Error!');

		return false;
	}

	$('title').text('Sending...');

    var request = new XMLHttpRequest();
    request.open('POST', api_email_url+'sendtestemail', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        // Success!
        // var data = JSON.parse(request.responseText);
        var msg = JSON.parse(request.responseText);

        if(msg['error']=='yes')
        {
        	alert(msg['message']);
        }
        else
        {
        	alert('Completed. Check your mail!');
        }

        send_email_status='none';

        $('title').text('Completed !');

      } else {
        // We reached our target server, but it returned an error
        send_email_status='none';

        $('title').text('Error !');

        alert(request.responseText);
        
        
      }
    };

    request.onerror = function() {
      // There was a connection error of some sort
       send_email_status='none';  
       
       $('title').text('Error !'); 

       alert('Error!');
    };

    request.send("send_email="+toEmail);	
}

$(document).ready(function(){

setSelect('send_method','<?php echo $mail["send_method"];?>');

	$('.btn-test-mail').click(function(){

		if(send_email_status=='start')
		{
			alert('Test mail sending...');
			return false;
		}

		var email=prompt('Type email that you will receive test mail:');

		if(email)
		{
			send_email_status='start';

			send_test_mail(email);
		}

	});

});

function setSelect(id,value)
{
	$('#'+id+' option').each(function(){
		var thisVal=$(this).val();

		if(thisVal==value)
		{
			$(this).attr('selected',true);
		}


	});
}
</script>