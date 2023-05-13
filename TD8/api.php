<?php
    function connect() {

        $db_host = "localhost";
        $db_user = "root";
        $db_password = "root";
        $db_db = "produits";
        $db_port = "3306";

        $conn = new mysqli($db_host, $db_user, $db_password, $db_db);

        return $conn;
    }

    function parseResults($results) {
        header("Content-Type: application/json");

        echo(json_encode($results));
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
        
        parseResults($data);
        //return $data;
    }

    function findBy($conn, $filterColumn, $filterValue) {
        $sql = "SELECT * FROM vetements WHERE `$filterColumn` = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $filterValue);
        $stmt->execute();
        $resultat = $stmt->get_result();
        $data = [];
        if($resultat->num_rows > 0){
            while($row = $resultat->fetch_assoc()) {
                $data[] = $row;
            }
        }

        parseResults($data);

        ///mysqli ne permet pas la gestion de paramètre nommé (:value)
        ///mysqli ne permet pas de mettre de marqueur de position (?) à la place des noms de colonne
        ///Avec PDO non plus

        ///$pdo = new PDO("mysql:host=localhost;dbname=ma_base_de_donnees", "mon_utilisateur", "mon_mot_de_passe");
        ///$stmt = $pdo->prepare($sql);
        ///$stmt->bindParam(':val', "...");
        ///$stmt->execute();
        /*
        Traiter les résultats
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Faire quelque chose avec les données de chaque ligne
        }

        // Fermer la requête
        $stmt->closeCursor();
        */
        
    }

    //Retour un boolean (true or false)
    function delete($conn, $id) {
        $sql = "DELETE from `vetements` WHERE `id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        if($conn->affected_rows == 0) {
            return false;
        } else {
            return true;
        }
    }

    function insert($conn, $id, $productDisplayName, $gender) {
        $sql = "INSERT INTO `vetements`(`id`, `gender`, `productDisplayName`) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iss', $id, $gender, $productDisplayName);
        $stmt->execute();
        
        if($conn->affected_rows == 0) {
            return false;
        } else {
            return true;
        }
    }
    
    $conn = connect();
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if(count($_GET)) {
                findBy($conn, $_GET["column"], $_GET["value"]);
            } else {
                findAll($conn);
            }
            break;
        
        case "POST": 
            $_POST = json_decode(file_get_contents("php://input"), true);
            ///On regarde si on a une action
            if($_POST["action"] == "delete") {
                if(isset($_POST["id"])) {
                    $result = delete($conn, $_POST["id"]);
                    if($result) {
                        findAll($conn);
                    } else {
                        parseResults(["result" => false]);
                    }
                }
            } elseif ($_POST["action"] == "add") {
                if(isset($_POST["id"]) && isset($_POST["productDisplayName"]) && isset($_POST["gender"])) {
                    $result = insert($conn, $_POST["id"], $_POST["productDisplayName"], $_POST["gender"]);
                    if($result) {
                        findAll($conn);
                    } else {
                        parseResults(["result" => false]);
                    }
                }
            }
            
            break;
        default:
           # code... 
            break;
    }
    //if(count($_GET)) {
    //    //var_dump($_GET);
    //    findBy($conn, $_GET["column"], $_GET["value"]);
    //} else {
    //    findAll($conn);
    //}

    $conn->close();
    exit();
?>