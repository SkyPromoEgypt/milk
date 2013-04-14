<!-- Container Wrapper -->
<div id="mws-container" class="clearfix">

	<!-- Main Container -->
	<div class="container">
		<?php User::authenticate(); ?>
		<?php if(!User::isLoggedIn()) { ?>
		<div id="mws-login" style="margin-top: 100px;">
			<h1>Login</h1>
			<div class="mws-login-lock">
				<img src="css/icons/24/locked-2.png" alt="" />
			</div>
			<div id="mws-login-form">
				<form class="mws-form" action="" method="post">
					<div class="mws-form-row">
						<div class="mws-form-item large">
							<input type="text" name="username" class="mws-login-username mws-textinput"
								placeholder="username" />
						</div>
					</div>
					<div class="mws-form-row">
						<div class="mws-form-item large">
							<input type="password" name="password" class="mws-login-password mws-textinput"
								placeholder="password" />
						</div>
					</div>
					<div class="mws-form-row">
						<input type="submit" value="Login" name="login"
							class="mws-button green mws-login-button" />
					</div>
				</form>
			</div>
		</div>
		<?php } else { Helper::render (); } ?>
	</div>
	<!-- End Main Container -->

	<!-- Footer -->
	
	<!-- End Footer -->

</div>
<!-- End Container Wrapper -->