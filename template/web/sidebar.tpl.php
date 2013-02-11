<!-- Necessary markup, do not remove -->
<div id="mws-sidebar-stitch"></div>
<div id="mws-sidebar-bg"></div>

<!-- Sidebar Wrapper -->
<div id="mws-sidebar">

	<!-- Main Navigation -->
	<div id="mws-navigation">
		<ul>
			<li><a href="" class="mws-i-24 i-list">قواعد البيانات</a>
				<ul>
					<li><a <?php Helper::activeItem("data-farmers"); ?> href="/data-farmers">المزارعين</a></li>
					<li><a <?php Helper::activeItem("data-agents"); ?> href="/data-agents">العملاء</a></li>
					<li><a <?php Helper::activeItem("data-suppliers"); ?> href="/data-suppliers">الموردين</a></li>
					<li><a <?php Helper::activeItem("data-animalfood"); ?> href="/data-animalfood">انواع العلف</a></li>
					<li><a <?php Helper::activeItem("data-milk"); ?> href="/data-milk">انواع اللبن</a></li>
				</ul>
			</li>
			<li><a href="" class="mws-i-24 i-list">المعاملات اليومية</a>
				<ul>
					<li><a <?php Helper::activeItem("trans-distributor"); ?> href="/trans-distributor">مركز التجميع</a></li>
					<li><a <?php Helper::activeItem("trans-food"); ?> href="/trans-freezing">مركز التبريد</a></li>
					<li><a <?php Helper::activeItem("trans-freezingcenter"); ?> href="/trans-agnet">توريد لعميل</a></li>
					<li><a <?php Helper::activeItem("trans-agents"); ?> href="/trans-food">توريد العلف</a></li>
					<li><a <?php Helper::activeItem("trans-agents"); ?> href="/trans-day">الوارد و الصادر</a></li>
				</ul>
			</li>
			<li><a href="" class="mws-i-24 i-list">التقارير</a>
				<ul>
					<li><a <?php Helper::activeItem("reporting-farmers"); ?>  href="/reporting-farmers">كميات اللبن</a></li>
					<li><a <?php Helper::activeItem("reporting-dcenter"); ?>  href="/reporting-dcenter">حسابات دائن و مدين</a></li>
					<li><a <?php Helper::activeItem("reporting-fcenter"); ?>  href="/reporting-fcenter">المزارعين</a></li>
					<li><a <?php Helper::activeItem("reporting-agents"); ?>  href="/reporting-agents">العملاء</a></li>
					<li><a <?php Helper::activeItem("reporting-cars"); ?>  href="/reporting-cars">الموردين</a></li>
					<li><a <?php Helper::activeItem("reporting-drivers"); ?>  href="/reporting-drivers">التقرير المجمع</a></li>
				</ul>
			</li>
			<li><a <?php Helper::activeItem("trans-distributor"); ?>  href="/settings" class="mws-i-24 i-list">الإعدادات العامة</a></li>
		</ul>
	</div>
	<!-- End Navigation -->

</div>