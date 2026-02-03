<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="@cachebust('assets/js/jquery.slimscroll.min.js')"></script>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Feather Icons -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.29.0/dist/feather.min.js"></script>

<script src="@cachebust('assets/js/sweetalert2.all.min.js')"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTables Responsive JS -->
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<!-- TinyMCE JS -->
<script src="@cachebust('vendor/tinymce/tinymce.min.js')"></script>

<!-- chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!--Custom scripts-->
<!-- Theme JS -->
<script src="@cachebust('assets/dashui/js/main.js')"></script>
<script src="@cachebust('assets/dashui/js/feather.js')"></script>
<script src="@cachebust('assets/dashui/js/sidebarMenu.js')"></script>
<!-- endbuild -->

<script src="@cachebust('assets/js/custom.js')"></script>

<!-- JS Sidebar Admin -->
<script src="@cachebust('assets/js/adminsidebar.js')"></script>

<script>
    $(document).ready(function () {
        $('.datatable').DataTable({
            responsive: true
        });
    });
</script>
