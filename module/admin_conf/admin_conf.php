<!-- DataTables JavaScript -->
<script src="/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
<script src="/bower_components/datatables-responsive/js/dataTables.responsive.js"></script>

<script>
$(document).ready(function() {
	$('#dataTables-adminconf').DataTable({
		responsive: true,
		lengthMenu: [ [10, 25, 50, 10, -1], [10, 25, 50, 10, "All"] ]
	});
});
</script>
