<!-- Necessary markup, do not remove -->
<div id="mws-sidebar-stitch"></div>
<div id="mws-sidebar-bg"></div>

<!-- Sidebar Wrapper -->
<div id="mws-sidebar">

	<!-- Main Navigation -->
	<div id="mws-navigation">
		<ul>
			<li><a href="" class="mws-i-24 i-list">الملفات</a>
				<ul>
					<li><a <?php Helper::activeItem("data-farmers"); ?> href="/data-farmers">الفلاحين</a></li>
					<li><a <?php Helper::activeItem("data-agents"); ?> href="/data-agents">العملاء</a></li>
					<li><a <?php Helper::activeItem("data-suppliers"); ?> href="/data-suppliers">الموردين</a></li>
					<li><a <?php Helper::activeItem("data-animalfood"); ?> href="/data-animalfood">العلف</a></li>
					<li><a <?php Helper::activeItem("data-milk"); ?> href="/data-milk">اللبن</a></li>
				</ul>
			</li>
			<li><a href="" class="mws-i-24 i-list">اليوميات</a>
				<ul>
					<li><a <?php Helper::activeItem("trans-distributor"); ?> href="/trans-distributor">توريد لبن</a></li>
					<li><a <?php Helper::activeItem("trans-agent"); ?> href="/trans-agent">توريد لعميل</a></li>
					<li><a <?php Helper::activeItem("trans-food"); ?> href="/trans-food">توريد علف</a></li>
				</ul>
			</li>
			<li><a href="" class="mws-i-24 i-list">الحسابات</a>
				<ul>
					<li><a <?php Helper::activeItem("acc-agent"); ?> href="/acc-agent">محاسبة عميل</a></li>
					<li><a <?php Helper::activeItem("acc-supplier"); ?> href="/acc-supplier">الدفع لمورد</a></li>
					<li><a <?php Helper::activeItem("acc-farmer"); ?> href="/acc-farmer">محاسبة مزارعين</a></li>
				</ul>
			</li>
			<li><a href="" class="mws-i-24 i-list">التقارير</a>
				<ul>
					<li><a <?php Helper::activeItem("reporting-milks"); ?>  href="/reporting-milk">كميات اللبن</a></li>
					<li><a <?php Helper::activeItem("reporting-farmers"); ?>  href="/reporting-farmers">الفلاحين</a></li>
					<li><a <?php Helper::activeItem("reporting-agents"); ?>  href="/reporting-agents">العملاء</a></li>
					<li><a <?php Helper::activeItem("reporting-suppliers"); ?>  href="/reporting-suppliers">الموردين</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<!-- End Navigation -->

</div>