<?php
include('lib/base.php');
if(isset($_SESSION['username'])&&$_SESSION['username']!="") { header('Location: home.php'); }
?>
	<img id="title-img" src="img/title.png" alt="title">
	<div class="login">
		<form method="post" action="login.php">
			<input type="text" id="username" name="username" placeholder="Pseudo">
			<input type="password" id="password" name="password" placeholder="Mot de passe">
			<input type="submit" id="connect" value="Connexion">
		</form>
	</div>
</body>