<!-- Datatables -->
<script src="../js/datatables/js/jquery.dataTables.js"></script>
<script src="../js/datatables/tools/js/dataTables.tableTools.js"></script>
<script>

    $(document).ready(function () {
        var oTable = $('#example').dataTable({
            "aaSorting": [[ 0, "desc" ]],
            "oLanguage": {
                "sSearch": "Search all columns:"
            },
            "aoColumnDefs": [
                {
                    'aTargets': [0]
                } //disables sorting for column one
            ],
            'iDisplayLength': 12,
            "sPaginationType": "full_numbers"
        });
    });
</script>