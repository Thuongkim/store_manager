<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Send Contact Feedback Email</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<div class="row" style="margin-top: 50px; border: 1px solid black; padding: 50px 50px">
			<h1 style="font-family: tahoma; margin-bottom: 50px;"><center>Send Feedback Content Email</center></h1>
			<div class="col-sm-7 col-sm-offset-2">
				@if(count($errors) > 0)
				<div class="alert alert-danger">
					<strong><big><span class="glyphicon glyphicon-remove-sign"></span> Error Detected!</big></strong>
					<ul>
						@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif
				@if($message = Session::get('success'))
				<div class="alert alert-success">
					<strong><big><span class="glyphicon glyphicon-ok-sign"></span> Sending Completed!</big></strong>
					<p style="margin-left: 20px">{{ $message }}</p>
				</div>
				@endif
				<form method="post" action="{{ url('sendemail/send') }}">
					{{ csrf_field() }}
					<div class="form-group">
						<label>Enter Your Name</label>
						<input type="text" class="form-control" name="name">
					</div>
					<div class="form-group">
						<label>Enter Your Email</label>
						<input type="text" class="form-control" name="email">
					</div>
					<div class="form-group">
						<label>Enter Your Message</label>
						<textarea class="form-control" name="message"></textarea>
					</div>
					<div class="form-group">
						<input class="btn btn-primary" type="submit" name="send" value="Send Email">
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>