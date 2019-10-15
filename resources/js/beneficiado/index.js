$(function() {

    $('#tabela-beneficiados').DataTable({
        "language": {
            "url": base_url + "resources/libs/datatables/i18n/datatables.ptbr.json"
        },
        "lengthMenu": [[50, 100, 150, 200, -1], [50, 100, 150, 200, "Todos"]]
    });
});