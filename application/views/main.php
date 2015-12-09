<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Logins</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

</head>
<body>
	<h2>Welcome</h2>

	<h3>Register</h3>
	<form action="/register_user" method="POST">
		<p>Name:<input type="text" name="name"></p>
		<p>Alias:<input type="text" name="alias"></p>
		<p>Email:<input type="email" name="email"></p>
		<p>Password:<input type="password" name="password"></p>
		<p>*Password should be at least 8 characters</p>
		<p>Confirm PW:<input type="password" name="password_rpt"></p>
		<input type="hidden" name="action">
		<input type="submit" name="submit" value="register">
	</form>
	<?= $this->session->flashdata('errors'); ?>
	<h3>Login</h3>
	<form action="/login_user" method="POST">
		<p>Email:<input type="email" name="email"></p>
		<p>Password:<input type="password" name="password"></p>
		<input type="hidden" name="action">
		<input type="submit" value="login">
	</form>	
	<?= $this->session->flashdata('whoops'); ?>
</body>
</html>

<style>
*{
	margin-left: 2%;
}
