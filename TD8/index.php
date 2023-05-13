<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Temple du swag</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <script src="swag.js" defer></script>
</head>

<body>
    <nav class="navbar navbar-expanded-sm bg-light navbar-light fixed-top">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li>
                    <a class="navbar-brand" href="#"><img src="img/logo.png" height="24"></a>
                </li>
                <li>
                    <a href="#" class="nav-link active"><i class="bi bi-house-fill"></i>HOME</a>
                </li>

            </ul>
        </div>
    </nav>

    <div class="container-fluid text-center" id="bandeau">
        <img src="img/logo.png" height="200">
        <p>Bienvenue dans le super site des étudiants en L2 MIASHS :)</p>

        <div class="container">
            <form method="post" action="/L2/TD8/api.php" class="row align-items-center ajaxform">
                <div class="col-auto">
                    <input type="number" name="id" id="id" class="form-control" placeholder="Identifiant">
                </div>
                <div class="col-auto">
                    <input type="text" name="productDisplayName" id="productDisplayName" class="form-control"
                        placeholder="Description">
                </div>
                <div class="col-auto">
                    <select name="gender" id="gender" placeholder="Genre" class="form-select">
                        <option selected>A choisir ...</option>
                        <option value="Men">Homme</option>
                        <option value="Women">Femme</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        </div>

        <?php
            $db_host = "localhost";
            $db_user = "root";
            $db_password = "root";
            $db_db = "produits";
            $db_port = "3306";

            $conn = new mysqli($db_host, $db_user, $db_password, $db_db);

            if($conn->connect_error) {
                die("Connexion error : " . $conn->connect_error);
            }

            function findAll($conn) {
                $sql = "SELECT * FROM vetements";
                $resultat = $conn->query($sql);
                $data = [];
                if($resultat->num_rows > 0){ 
                    while($row = $resultat->fetch_assoc()) {
                        $data[] = $row;
                    }
                }

                return $data;
            }

            $data = findAll($conn);
           

            $conn->close();
        ?>


        <?php
            //var_dump($data);
            foreach ($data as $key => $value) {
                //var_dump($value);
                //echo("<br>");
            }
        ?>
        <!-- COMMENTAIRE -->
        <div class="container mt-5" id="container">
            <div class="row">
                <?php foreach ($data as $key => $value) {?>
                <div class="card text-bg-light" id="<?php echo($value["id"]);?>">
                    <img src="img/vetements/<?php echo($value["id"]) ?>.jpg" alt="Card img cap" class="card-img-top">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo($value["productDisplayName"]) ?></h4>
                        <p class="card-text">
                            <span class="badge bg-secondary">
                                <?php echo($value["articleType"]) ?>
                            </span>
                            <span class="badge bg-secondary">
                                <?php echo($value["baseColour"]) ?>
                            </span>
                            <span class="badge bg-dark">
                                <button
                                    onclick="filterByYear('<?php echo($value['year']) ?>')"><?php echo($value["year"]); ?></button>
                            </span>
                            <?php 
                                $sexIcon = $value["gender"] == "Men" ? "bi-gender-male" : "bi-gender-female";
                            ?>
                            <span class="badge bg-secondary">
                                <button
                                    onclick="filterByGender(<?php echo($value['id']) ?>, '<?php echo($value['gender']) ?>')"
                                    class="btn btn-secondary btn-sm bi <?php echo($sexIcon) ?>"></button>
                            </span>
                            <span>
                                <button class="btn btn-sm btn-danger" onclick="remove(<?php echo($value['id']) ?>)">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </span>
                        </p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>

</html>