<!-- js -->
<script src="<?php echo assets_url('admin/scripts/core.js');?>"></script>
<script src="<?php echo assets_url('admin/scripts/script.min.js');?>"></script>
<script src="<?php echo assets_url('admin/scripts/process.js');?>"></script>
<script src="<?php echo assets_url('admin/scripts/layout-settings.js');?>"></script>
<script src="<?php echo assets_url('admin/src/plugins/apexcharts/apexcharts.min.js');?>"></script>
<script src="<?php echo assets_url('admin/src/plugins/datatables/js/jquery.dataTables.min.js');?>"></script>
<script src="<?php echo assets_url('admin/src/plugins/datatables/js/dataTables.bootstrap4.min.js');?>"></script>
<script src="<?php echo assets_url('admin/src/plugins/datatables/js/dataTables.responsive.min.js');?>"></script>
<script src="<?php echo assets_url('admin/src/plugins/datatables/js/responsive.bootstrap4.min.js');?>"></script>
<script src="<?php echo assets_url('admin/scripts/dashboard.js');?>"></script>
<script src="<?php echo assets_url('admin/chart/chart.min.js');?>"></script>
<script src="<?php echo assets_url('admin/chart/chart2-min.js');?>"></script>
<script src="<?php echo assets_url('admin/scripts/common.js');?>"></script>
<script>
	var data = [
		{ y: 'Jan', a: 50, b: 90 },
		{ y: 'Feb', a: 65, b: 75 },
		{ y: 'Mar', a: 50, b: 50 },
		{ y: 'Apr', a: 75, b: 60 },
		{ y: 'May', a: 80, b: 65 },
		{ y: 'Jun', a: 90, b: 70 },
		{ y: 'Jul', a: 100, b: 75 },
		{ y: 'Aug', a: 115, b: 75 },
		{ y: 'Sep', a: 120, b: 85 },
		{ y: 'Oct', a: 145, b: 85 },
		{ y: 'Nov', a: 160, b: 95 },
		{ y: 'Dec', a: 180, b: 95 },

	],
		config = {
			data: data,
			xkey: 'y',
			ymax: 200, // set this value according to your liking
			ykeys: ['a', 'b'],
			labels: ['Total Income', 'Total Outcome'],
			fillOpacity: 0.6,
			hideHover: 'auto',
			behaveLikeLine: true,
			resize: true,
			barSize: 10,
			pointFillColors: ['#ffffff'],
			pointStrokeColors: ['black'],
			lineColors: ['gray', 'red']
		};
	config.element = 'bar-chart';
	Morris.Bar(config);
	config.element = 'stacked';
	config.stacked = true;
	Morris.Bar(config);
	Morris.Donut({
		element: 'pie-chart',
		data: [
			{ label: "Friends", value: 30 },
			{ label: "Allies", value: 15 },
			{ label: "Enemies", value: 45 },
			{ label: "Neutral", value: 10 }
		]
	});
</script>

<script>
	$(document).ready(function () {
		// Initialize DataTable
		$('#myDataTable').DataTable({
			paging: true, // Enable pagination
			searching: true, // Enable search
			ordering: true, // Enable sorting
			info: true, // Show information
			lengthChange: true, // Disable the "Show X entries" dropdown
		});
	});
</script>