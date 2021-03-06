<?php
include("check.php");
include("connect.php");
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>MiniProeve</title>
        <link type="text/css" rel="stylesheet" href="stylesheet.css">
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link type="text/css" rel="stylesheet" media="screen,projection" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css" />
    </head>
    <body> 
        <?php
        include("navbar.php");
        include("ModalAddWerkproces.php");
        include("ModalEditWerkproces.php");
        include("ModalDeleteWerkproces.php");
        ?>
        <div class="row" style="margin-bottom: auto;">
            <div class="col s12 m4 l3" style="background-color: gray; height: 100%;">
                <br>
                <?php
                $error = '';
                $get_kerntaak = "SELECT * FROM kerntaak";
                $result_kerntaak = $conn->query($get_kerntaak);
                if ($result_kerntaak->num_rows > 0) {
                    ?>
                    <select name="selected_kerntaak" required>
                        <option selected="selected" disabled>Kies een kerntaken</option>
                        <?php
                        while ($row_kerntaak = $result_kerntaak->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row_kerntaak["kerntaak_id"] ?>"><?php echo $row_kerntaak["kerntaak_naam"] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <?php
                }
                ?>
            </div>
            <div class="col s12 m8 l9">
                <h4>Overzicht werkprocessen <a data-target="ModalAddWerkproces" class="btn-floating btn-small waves-effect waves-light green btn modal-trigger"><i class="material-icons" >add</i></a></h4>
                <table id="show_werkproces" class="hide">
                    <thead>
                        <tr>
                            <th>Werkprocesnaam</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody name="tbody">

                    </tbody>
                </table>
            </div>
        </div>
        <!--EINDE CODE VOOR KLAS TOEVOEGEN BACKEND -->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
                $('.modal-trigger').leanModal();
                $('select').material_select();
                $(".button-collapse").sideNav();

                // Show werkproces
                $("select[name=selected_kerntaak]").on('change', function () {
                    kerntaak_id = this.value;
                    //alert(kerntaak_id);

                    $("tbody[name=tbody]").empty();

                    // ophalen van informatie, met ajax
                    $.ajax({
                        type: 'GET',
                        url: 'json_show_werkproces.php',
                        data: {id: kerntaak_id},
                        dataType: 'json',
                        success: function (data) {
                            //console.log(data);
                            $.each(data, function (index, element) {
                                $("#show_werkproces").find('tbody')
                                        .append($('<tr>', {id: element.id}
                                        ).append($('<td>', {
                                            text: element.name},
                                                )).append($(
                                                '<td><button data-target="ModalEditWerkproces" class="EditWerkproces btn-floating btn-large waves-effect waves-light yellow btn modal-trigger"><i class="material-icons" >edit</i></button>'
                                                )).append($(
                                                '<td><button data-target="ModalDeleteWerkproces" class="DeleteWerkproces btn-floating btn-large waves-effect waves-light red btn modal-trigger"><i class="material-icons">delete</i></button>'
                                                ))

                                                );
                                //$('#show_klas').append($('<td>', {value: element.klas_id, text: element.name}, '</td>'));
                                $("#show_werkproces").removeClass("hide");
                            });
                                $(".modal-trigger").leanModal();

                            //Edit button Werkproces
                            $(".EditWerkproces").on('click', function () {
                                // waarde van het geselecteerde id ophalen
                                id_werkproces = $(this).parent().parent().attr('id');
                                //alert(id_werkproces);

                                // Velden leeg maken
                                document.getElementById("werkproces_id").value = "";
                                document.getElementById("werkproces_naam").value = "";

                                // ophalen van informatie, met ajax om naam/omschrijving werkproces op te halen
                                $.ajax({
                                    type: 'GET',
                                    url: 'json_edit_werkproces.php',
                                    data: {id: id_werkproces},
                                    dataType: 'json',
                                    success: function (data) {
                                        $("#werkproces_id").val(data.id);
                                        $("#werkproces_naam").val(data.name);
                                        $("#werkproces_naam").removeClass("hide");
                                    }
                                });
                            });
                            
                            // Delete button Werkproces
                            $(".DeleteWerkproces").on('click', function () {
                                
                                // ophalen van het id
                                var werkproces_id = $(this).parent().parent().attr('id');
                                //console.log(werkproces_id);
                                // link aanpassen
                                $("#delhref").attr("href", "delete_werkproces.php?id=" + werkproces_id);
                            });
                          
                        }
                    });
                });
            });
        </script>
    </body>
</html>
