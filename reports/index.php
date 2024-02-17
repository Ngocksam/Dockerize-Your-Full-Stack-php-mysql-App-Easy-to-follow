<?php
require 'authentication.php'; // admin authentication check 

// auth check
if(isset($_SESSION['admin_id'])){
  $user_id = $_SESSION['admin_id'];
  $user_name = $_SESSION['admin_name'];
  $security_key = $_SESSION['security_key'];
  if ($user_id != NULL && $security_key != NULL) {
    header('Location: task-info.php');
  }
}

if(isset($_POST['login_btn'])){
 $info = $obj_admin->admin_login_check($_POST);
}

$page_name="Login";
include("include/login_header.php");

?>
<style>
	html, body{
		height:100%;
		width:100%;
		margin:unset !important
	}
	.main{
		display:flex;
		align-items:center;
		justify-content:center;
		height:100%;
		width:100%;
		margin:unset !important
	}

  /* Ajouter le style pour le logo flottant */
  @keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
  }

  #logo {
    animation: float 2s ease-in-out infinite;
    position: absolute; /* Positionner le logo de façon absolue */
    top: 20px; /* Décaler le logo de 20px depuis le haut */
    left: 50%; /* Centrer le logo horizontalement */
    transform: translateX(-50%); /* Ajuster le logo horizontalement */
    z-index: 10; /* Mettre le logo au-dessus des autres éléments */
  }

  /* Supprimer le code qui rend transparent l'arrière-plan */
  /*
  header {
    height: 600px;
    width: 100vw;
    background: rgba (75,0,130,0.5); /* ceci est un arrière-plan transparent violet sombre */
    overflow: hidden;
  }
  */
</style>
<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="well rounded-0" style="background:#fff !important">
	<center><h2 style="margin-top:1px;">Ileadglobal Report and Task Management System</h2></center>
		<form class="form-horizontal form-custom-login" action="" method="POST">
			<div class="form-heading">
			<h2 class="text-center">Login Panel</h2>
			</div>
			
			<!-- <div class="login-gap"></div> -->
			<?php if(isset($info)){ ?>
			<h5 class="alert alert-danger"><?php echo $info; ?></h5>
			<?php } ?>
			<div class="form-group">
			<input type="text" class="form-control rounded-0" placeholder="Username" name="username" required/>
			</div>
			<div class="form-group" ng-class="{'has-error': loginForm.password.$invalid && loginForm.password.$dirty, 'has-success': loginForm.password.$valid}">
			<input type="password" class="form-control rounded-0" placeholder="Password" name="admin_password" required/>
			</div>
			<button type="submit" name="login_btn" class="btn btn-info pull-right">Login</button>
		</form>
	</div>
</div>

<?php

include("include/footer.php");

?>

<!-- Ajouter le logo flottant avec la balise img -->
<img id="logo" src="./assets/img/LogoIlead-removebg-preview.PNG" alt="LogoIlead-removebg-preview" style="height:50px;">
