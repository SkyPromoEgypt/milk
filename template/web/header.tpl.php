<!-- Header Wrapper -->
<div id="mws-header" class="clearfix">

	<!-- Logo Wrapper -->
	<div id="mws-logo-container">
		<div id="mws-logo-wrap">
			<a href="/"><img src="images/mws-logo.png" alt="mws admin" /></a>
		</div>
	</div>
        
        <?php if(User::isLoggedIn()) { ?>
        <!-- User Area Wrapper -->
	<div id="mws-user-tools" class="clearfix">
		<!-- User Functions -->
		<div id="mws-user-info" class="mws-inset">
			<div id="mws-user-photo">
				<img src="css/icons/32/user.png" alt="User Photo" />
			</div>
			<div id="mws-user-functions">
				<div id="mws-username">مرحبا <?php echo User::theUser()->username; ?></div>
				<ul>
					<li><a href="/logout">تسجيل خروج</a></li>
				</ul>
			</div>
		</div>
		<!-- End User Functions -->
	</div>
        <?php  } ?>
    </div>

<!-- Main Wrapper -->
<div id="mws-wrapper">