<!-- Header Wrapper -->
<div id="mws-header" class="clearfix">

	<!-- Logo Wrapper -->
	<div id="mws-logo-container">
		<div id="mws-logo-wrap">
			<img src="images/mws-logo.png" alt="mws admin" />
		</div>
	</div>
        
        <?php if(User::isLoggedIn()) { ?>
        <!-- User Area Wrapper -->
	<div id="mws-user-tools" class="clearfix">
		<!-- User Functions -->
		<div id="mws-user-info" class="mws-inset">
			<div id="mws-user-photo">
				<img src="example/profile.jpg" alt="User Photo" />
			</div>
			<div id="mws-user-functions">
				<div id="mws-username">Hello, <?php echo User::theUser()->username; ?></div>
				<ul>
					<li><a href="resetpassword">Change Password</a></li>
					<li><a href="/logout">Logout</a></li>
				</ul>
			</div>
		</div>
		<!-- End User Functions -->
	</div>
        <?php  } ?>
    </div>

<!-- Main Wrapper -->
<div id="mws-wrapper">