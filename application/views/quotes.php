<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h2>Welcome <?= $this->session->userdata('name')."!"   ?><h2> <a href="/log_out">Logout</a>

		<form action="/create_newTeam" method="POST">
			<input type="text" name="team" placeholder="favorite team">
			<input type="submit">
		</form>

		<hr>
			
	<div id="left"><h3><?= $this->session->userdata('name')?>'s Teams</h3>
		<?php
		foreach ($my_teams as $my_team) 
		{
?>
			<form action='/remove' method='post'>
				<?=$my_team['name']?> 
				<input type='hidden' name='id' value='<?=$my_team['team_id']?>'>
				<input class="btn" type='submit' value='remove'>
			</form>
				
<?php				
		} 
?>
	</div>
	<div id="right"><h3>All Teams</h3>
		<?php
		

		foreach ($teams as $team)
		{
			echo "<h6>" . $team['name'] . "</h6>";

		}
		
		?> 
	</div>

</body>
</html>

<style type="text/css">
	
	.teams{
		width: 40%;
		height: 20%;
		display: block;
		border: 1px dotted purple;
	}
	#left{
		width: 45%;
		border: 1px dotted purple;
		display: inline-block;
		vertical-align: top;
	}
	#right{
		width: 45%;
		border: 1px dotted purple;
		display: inline-block;
		vertical-align: top;
	}
	.btn{
		float: right;
		margin-right: 5%;
		margin-top: 2%;
	}


</style>