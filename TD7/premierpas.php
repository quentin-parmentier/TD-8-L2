<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premier Pas</title>
</head>

<body>
    <h1>Bonjour</h1>
    <?php 
        $emoji = "😭";
        $toto = "mon premier pas $emoji";
        echo $toto;

        $prenom = "Quentin";
        $salutation = "Bonjour $prenom";
        $salutation2 = 'Bonjour $prenom';
        echo $salutation2;
        echo `<br>`;
        echo strlen($salutation);
        echo "<br>";
        echo str_word_count($salutation);
        echo "<br>";
        echo str_replace("Bonjour", "Yo", $salutation);
        $salutation .= "!!!!";
        echo "<br>";
        $age = 20;
        echo $age . "<br>";
        $type = gettype($age);
        echo $type . "<br>";
        $pi = pi();
        echo substr($pi,0,6);
    ?>


    <div>Jfais</div>
    <div>des</div>
    <div>trucs</div>
    <div>cools</div>
    <div><?php echo $salutation; ?></div>

    <?php
        //Cas d'usage n°1 - note du bac
        //10/5/19 - 2/6/3
        $resultat = (10*2 + 5*6 + 19*3) / 11;
    ?>
    <div> Ma note : <?php echo($resultat) ?></div>

    <div>
        <?php
            //Cas d'usage - Les booleans
            $a = true;
            $b = true;
            if($a || $b) {
                echo("C'est inclusif");
            } else {
                echo("C'est exclusif");
            }

            if($a xor $b) {
                echo("C'est inclusif");
            } else {
                echo("<br>C'est exclusif");
            }
        ?>
    </div>

    <div>
        <?php
            //Cas d'usage n°2 - Marie Antoinette
            //le peuple a faim et n’a pas de pain ni de brioche
            $phrase = "le peuple a faim et n’a pas de pain ni de brioche";
            $etatDuPeuple = [
                "pain" => "?",
                "brioche" => "mort",
            ];

            $tabPhrase = explode(" ", $phrase);

            foreach ($tabPhrase as $key => $word) {
                echo(" " . $word);
                if(array_key_exists($word, $etatDuPeuple)) {
                    echo($etatDuPeuple[$word]);
                }
            }

            $pain = false;
            $brioche = false;
            $faim = true;
            if(!($pain && $brioche) && $faim) {
                echo("Marie Antoinette: 'Mais il faut se forcer'");
            }
        ?>
    </div>

    <div>
        <?php
            //Cas d'usage - Les tableaux
            $artistes = array("Edith Piaf", "Alpha One", "Jean Dujardin", "Jacques Brel", "Van gogh");
            var_dump($artistes);
        ?>
        <?php
            array_push($artistes, "Suprem NTM");
            echo("<br>");
            var_dump($artistes);
            array_pop($artistes);
            echo("<br>");
            var_dump($artistes);
            asort($artistes);
            echo("<br>");
            var_dump($artistes);
            array_unshift($artistes, "Brice de Nice");
            echo("<br>");
            var_dump($artistes);
            arsort($artistes);
            echo("<br>");
            var_dump($artistes);
            echo("<br>");
            array_shift($artistes);
            var_dump($artistes);
            echo("<br>");
            array_splice($artistes, 2, 1, ["Minnie Riperton", "Minnie Riperton"]);
            var_dump($artistes);
            echo("<br>");
            print_r(array_count_values($artistes));
            
            //for ($i=0; $i < count($artistes); $i++) {
            //    echo("<br>");
            //    echo($artistes[$i]);
            //}
//
            //for($i = count($artistes) - 1; $i >= 0; $i--) {
            //    echo("<br>");
            //    echo($artistes[$i]);
            //}
//
            //for ($i=0; $i < count($artistes); $i=$i+3) {
            //    echo("<br>");
            //    echo($artistes[$i]);
            //}
        ?>
    </div>

    <div>
        <?php
            //Cas d'usage n°3 - Picsou
            $prix = [234, 5234, 235, 112, 98.5, 154];
            $prix[] = 95;
            array_push($prix, 763);
            rsort($prix);
            var_dump($prix);
            $moinscher = $prix[(count($prix)-1)];
            echo('<br>');
            echo($moinscher);
        ?>
    </div>

    <div>
        <?php
            //MOIMOIMOI :)
            $moimoimoi = [
                "nom" => "Rougé",
                "prenom" => "Mélina",
                "age" => "19",
            ];
            var_dump($moimoimoi);
            var_dump($moimoimoi["prenom"]);
        ?>
    </div>

    <div>
        <?php
            //LE MMO TROP BIEN
            //tete - Jambe - Torse - sac - sorts [feu - (description, visuel, puissance)]
            $personnage = array(
                "tete" => "Casque abysse",
                "torse" => "Torse",
                "jambe" => "Sandale",
                "sac" => array("Potion", "Ordinateur"),
                "sorts" => [
                    "feu" => array(
                        [
                            "description" => "La description...",
                            "visuel" => "Flamme",
                            "puissance" => 76,
                        ],
                        [
                            "description" => "La description 2...",
                            "visuel" => "Flamme 2",
                            "puissance" => 89,
                        ],
                    )
                ]
            );
            var_dump($personnage["sac"]);
            var_dump($personnage['sorts']["feu"][1]["visuel"]);
        ?>
    </div>

    <div>
        <?php
            foreach ($moimoimoi as $value) {
                echo("<br>");
                var_dump($value);
            }
            
            foreach ($moimoimoi as $toto => $tata) {
                echo("<br>");
                echo("$toto : $tata");
            }
        ?>
    </div>

    <div>
        <?php
            //Cas d'usage n°5 - Placard à chaussure
            //prix - Nom - couleur - type - livraison longue distance ?
            $chaussures = [
                [
                    "prix" => 45.99,
                    "nom" => "Basket 1",
                    "couleur" => "Rose",
                    "type" => "Basket Basse",
                    "livraison" => false,
                ],
                [
                    "prix" => 44.99,
                    "nom" => "Sandale 1",
                    "couleur" => "Noire",
                    "type" => "Sandale",
                    "livraison" => false,
                ],
                [
                    "prix" => 109.95,
                    "nom" => "Basket 2",
                    "couleur" => "Blanche",
                    "type" => "Basket Basse",
                    "livraison" => true,
                ],
            ];

            foreach($chaussures as $chaussure) {
                echo($chaussure["nom"] . " - " . $chaussure["type"] . " - " . $chaussure["couleur"]);
                echo("<br>");
                echo($chaussure["prix"]);
                echo("<br>");
                echo($chaussure["livraison"] == true ? "Livraison dispo" : "");

                echo("<br>");
                echo("<br>");
            }
        ?>
    </div>
</body>

</html>