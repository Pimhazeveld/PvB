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
        include("check.php");
        include("connect.php");
        include("navbar.php");
        include("ModalAddWerkproces.php");
        include("ModalDeleteWerkproces.php");
        ?>
        <div class="row" style="margin-bottom: auto;">
            <div class="col s12 m4 l3" style="background-color: gray; height: 100%;">
                <br>
                <!-- Dropdown Trigger -->
                <a class='dropdown-button btn' href='#' data-activates='dropdown1'>Selecteer kerntaak</a>

                <!-- Dropdown Structure -->
                <ul id='dropdown1' class='dropdown-content'>
                    <li><a href="#!"></a></li>
                    <li>Stelt de opdracht vast</a></li>
                    <li>Levert bijdrage projectplan</li>
                    <li>Levert bijdrage onderwerp</li>
                </ul>
            </div>
            <div class="col s12 m8 l9">
                <h4>Overzicht werkprocessen <a data-target="ModalAddWerkproces" class="btn-floating btn-small waves-effect waves-light green btn modal-trigger"><i class="material-icons" >add</i></a></h5>
                    <table>
                        <thead>
                            <tr>
                                <th>Naam</th>
                                <th>Omschrijving</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $get_werkproces_inhoud = "SELECT * FROM werkproces";
                            $result_get_werkproces_inhoud = $conn->query($get_werkproces_inhoud);
                            if ($result_get_werkproces_inhoud->num_rows > 0) {
                                while ($row_get_werkproces_inhoud = $result_get_werkproces_inhoud->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row_get_werkproces_inhoud['werkproces_naam']; ?></td>
                                        <td><?php echo $row_get_werkproces_inhoud['werkproces_id']; ?></td>
                                        <td><button data-id="<?php echo $row_get_werkproces_inhoud['werkproces_id']; ?>" data-target="ModalEditwerkproces" class="btn-floating btn-large waves-effect waves-light yellow btn modal-trigger"><i class="material-icons" >edit</i></button></td>
                                        <td><button data-id="<?php echo $row_get_werkproces_inhoud['werkproces_id']; ?>" data-target="ModalDeleteWerkproces" name="DeleteWerkproces" class="btn-floating btn-large waves-effect waves-light red btn modal-trigger"><i class="material-icons">delete</i></button></td>
                                    <tr>
                                        <?php
                                    }
                                } else {
                                    echo '0 results';
                                }
                                ?>
                        </tbody>
                    </table>
                    <br>
                    </div>
                    </div>
                    <!--EINDE CODE VOOR KLAS TOEVOEGEN BACKEND -->
                    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
                            $('.modal-trigger').leanModal();
                            $('select').material_select();
                            $(".button-collapse").sideNav();

                            $("button[name=DeleteWerkproces]").click(function (event) {
                                event.preventDefault();
                                // ophalen van het id
                                var werkproces_id = $(this).data("id");
                                // link aanpassen
                                $("#delhref").attr("href", "delete_werkproces.php?id=" + werkproces_id);
                            });
                        });
                    </script>
                    </body>
                    </html>
