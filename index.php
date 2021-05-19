<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

    <title>CRUD</title>
</head>
<body>

<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">CRUD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Strona główna</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="row justify-content-center align-items-center m-5">
        <div class="col-8">

            <div class="card m-3">
                <div class="card-header">
                    <p class="h1">
                        Lista tabel w Bazie Danych
                    </p>
                </div>
                <div class="card-body">
                    <?php
                    include_once('./scripts/get_tables.php')
                    ?>
                </div>
            </div>

            <div class="card m-3" id="tableshow" style="display: none">
                <div class="card-header">
                    <p class="h1" id="selectedTableName"></p>
                </div>
                <div class="card-body" id="tableContent">

                </div>
            </div>

            <div class="card m-3">
                <div class="card-header">
                    <p class="h1">
                        Utwórz tabelę
                    </p>
                </div>
                <div class="card-body">
                    <form action="./scripts/create_table.php" method="post">
                        <div class="mb-3">
                            <label for="tablename" class="form-label">Nazwa tabeli</label>
                            <input type="text" class="form-control" id="tablename" name="tablename" placeholder="Nazwa tabeli">
                        </div>
                        <div class="mb-3">
                            <div id="fieldHolder">
                                <div class="row my-3">
                                    <div class="col-4">
                                        <label class="d-flex flex-column">
                                            Nazwa pola
                                            <input type="text" class="form-control" name="fields[0][name]" placeholder="Nazwa pola">
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <label class="d-flex flex-column">
                                            Typ pola
                                            <select name="fields[0][type]" class="form-select">
                                                <option value="1" selected>int</option>
                                                <option value="2">varchar(255)</option>
                                                <option value="2">text</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <label class="d-flex flex-column">
                                            Not null
                                            <input type="checkbox" name="fields[0][notnull]" class="form-check-input" style="width: 2em; height: 2em;">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success" id="addField">Dodaj pole</button>
                        </div>
                        <button type="submit" class="btn btn-primary">Zapisz</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="addingModal" tabindex="-1" aria-labelledby="addingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addingModalLabel">Wprowadź dane</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    // prototype tworzenia tabeli
    let counter = 1;
    $(document).on('click', '#addField', function (){
        let $holder = $('#fieldHolder');
        let prototype = `
        <div class="row my-3">
                                    <div class="col-4">
                                        <label class="d-flex flex-column">
                                            Nazwa pola
                                            <input type="text" class="form-control" name="fields[{counter}][name]" placeholder="Nazwa pola">
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <label class="d-flex flex-column">
                                            Typ pola
                                            <select name="fields[{counter}][type]" class="form-select">
                                                <option value="1" selected>int</option>
                                                <option value="2">varchar(255)</option>
                                                <option value="2">text</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <label class="d-flex flex-column">
                                            Not null
                                            <input type="checkbox" name="fields[{counter}][notnull]" class="form-check-input" style="width: 2em; height: 2em;">
                                        </label>
                                    </div>
                                </div>
        `;

        prototype = prototype.replaceAll('{counter}', String(counter));
        counter++;

        $holder.append(prototype);
    })
</script>
<script>
    $(document).on('click', '.show-table', function (){
        let tablename = $(this).data('tablename');

        let card = $('#tableshow');
        let name = $('#selectedTableName');
        let content = $('#tableContent');

        name.html(tablename);

        $.ajax({
            type: 'post',
            url: './scripts/select_from.php?tablename=' + tablename
        }).done((d) => {
            const respObj = JSON.parse(d)

            let tableHead = `<thead><tr>`;

            for (const respObjKey in respObj[0]) {
                tableHead += `<th scope="col">${respObjKey}</th>`
            }

            tableHead += `<th scope="col">Usuń wiersz</th></tr></thead>`;

            let tableBody = `<tbody>`;

            for (const obj in respObj) {
                tableBody += `<tr>`;
                let id = undefined;
                for(const key in respObj[obj])
                {
                    if (key === 'id')
                        id = respObj[obj][key];
                    tableBody += `<td>` + respObj[obj][key] + `</td>`
                }
                tableBody += `<td><a href="./scripts/delete_one.php?tablename=${tablename}&id=${id}" class="text-danger">Usuń</a></td>`;
                tableBody += `</tr>`;
            }

            tableBody += `</tbody>`

            let table = `
            <table class="table">
                ${tableHead}
                ${tableBody}
            </table>
`

            content.html(table);

            card.show()
        })

    })
</script>
<script>
    let addingModal = document.getElementById('addingModal');
    addingModal.addEventListener('show.bs.modal', function (e) {
        let source = e.relatedTarget
        let table = source.getAttribute('data-tablename')

        $.ajax({
            type: 'get',
            url: './scripts/get_add_form.php',
            data: {
                tablename: table
            }
        }).done( (d) => {
            console.log(d)
            addingModal.querySelector('.modal-body').innerHTML = d
        })

    })
</script>

</body>
</html>
