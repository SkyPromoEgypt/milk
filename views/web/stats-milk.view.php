<script type="text/javascript">
$(document).ready(function() {
	var chart;
	chart = new Highcharts.Chart({
	    chart: {
	    	renderTo: 'container',
	        type: 'column'
	    },
	    title: {
	        text: 'احصائيات اللبن هذا الشهر'
	    },
	    xAxis: {
	        categories: ['إبريل', 'مايو', 'يونيو', 'يوليو']
	    },
	    yAxis: {
	        title: {
	            text: 'الكميات'
	        }
	    },
	    series: [{
	        name: 'هادر',
	        data: [11250, 10254, 25632, 21451]
	    }, {
	        name: 'خارج',
	        data: [1125236, 1452362, 1254568, 1954587]
	    }, {
	    	name: 'داخل',
	        data: [1253652, 1654877, 1548756, 2365487]
	    }]
	});
});
</script>
<div id="container"></div>