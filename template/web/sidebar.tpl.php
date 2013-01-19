<!-- Necessary markup, do not remove -->
<div id="mws-sidebar-stitch"></div>
<div id="mws-sidebar-bg"></div>

<!-- Sidebar Wrapper -->
<div id="mws-sidebar">

	<!-- Search Box -->
	<div id="mws-searchbox" class="mws-inset">
		<form action="" method="post">
			<input type="text" class="mws-search-input" /> <input type="submit"
				class="mws-search-submit" />
		</form>
	</div>

	<!-- Main Navigation -->
	<div id="mws-navigation">
		<ul>
			<li><a href="" class="mws-i-24 i-list">Data Center</a>
				<ul>
					<li><a <?php Helper::activeItem("data-farmers"); ?> href="/data-farmers">Farmers</a></li>
					<li><a <?php Helper::activeItem("data-agents"); ?> href="/data-agents">Agnets / Factories</a></li>
					<li><a <?php Helper::activeItem("data-cars"); ?> href="/data-cars">Delivery Cars</a></li>
					<li><a <?php Helper::activeItem("data-drivers"); ?> href="/data-drivers">Drivers</a></li>
					<li><a <?php Helper::activeItem("data-animalfood"); ?> href="/data-animalfood">Animal Food</a></li>
				</ul></li>
			<li><a href="" class="mws-i-24 i-list">Transactions</a>
				<ul>
					<li><a <?php Helper::activeItem("trans-distributor"); ?> href="/trans-distributor">The Distributor</a></li>
					<li><a <?php Helper::activeItem("trans-freezingcenter"); ?> href="/trans-freezingcenter">Freezing Center</a></li>
					<li><a <?php Helper::activeItem("trans-agents"); ?> href="/trans-agents">Agents / Factories</a></li>
					<li><a <?php Helper::activeItem("trans-saftybox"); ?> href="/trans-saftybox">Daily Transaction</a></li>
				</ul></li>
			<li><a href="#" class="mws-i-24 i-list">Reporting</a>
				<ul>
					<li><a href="/reporting-farmers">Farmers</a></li>
					<li><a href="/reporting-dcenter">Distribution Center</a></li>
					<li><a href="/reporting-fcenter">Freezing Center</a></li>
					<li><a href="/reporting-agents">Agnets / Factories</a></li>
					<li><a href="/reporting-cars">Delivery Cars</a></li>
					<li><a href="/reporting-drivers">Drivers</a></li>
				</ul></li>
			<li><a href="/settings" class="mws-i-24 i-list">General Setting</a></li>
		</ul>
	</div>
	<!-- End Navigation -->

</div>