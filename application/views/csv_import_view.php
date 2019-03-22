<html>

<head>
    <title>Como importar CSV para o MYSQL usando Codeigniter</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container box">
        <h3>Como importar CSV para o MYSQL usando Codeigniter</h3>
        <br />
        <form method="post" id="import_csv" enctype="multipart/form-data">
            <div class="form-group">
                <label>Selecione o arquivo...</label>
                <input type="file" name="csv_file" id="csv_file" required accept=".csv" />
            </div>
            <br />
            <button type="submit" name="import_csv" class="btn btn-info" id="import_csv_btn">Import CSV</button>
        </form>
        <br />
        <div id="imported_csv_data"></div>
    </div>
</body>

</html>

<script>
    $(document).ready(function() {

        load_data();

        function load_data() {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/csv_import_controller/carrega_dados",
                method: "POST",
                success: function(data) {
                    $('#imported_csv_data').html(data);
                }
            })
        }

        $('#import_csv').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/csv_import_controller/import",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('#import_csv_btn').html('Importando...');
                },
                success: function(data) {
                    $('#import_csv')[0].reset();
                    $('#import_csv_btn').attr('disabled', false);
                    $('#import_csv_btn').html('Import Done');
                    load_data();
                }
            })
        });

    });
</script> 