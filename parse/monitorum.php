<?php
$faction = "";
$name = "";
$models = 0;
$points = 0;
$isReadingFaction = true;
$isReadingData = false;

$isReadingEnhancements = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = $_POST['text'];
    $lines = explode("\n", $text);

    $indice = 2;

    $lista = array();

    foreach ($lines as $index => $line) {
        $line = trim($line);

        if ($line == 1) {
            $isReadingData = true;
        }

        if (!empty($line) && $isReadingData) {
            $firstChar = substr($line, 0, 1);
            if (ctype_alpha($firstChar)) {

                if ($line == "FORGE WORLD POINTS VALUES") {
                    continue;
                }

                if ($line == "DETACHMENT ENHANCEMENTS") {
                    $isReadingEnhancements = true;
                    continue;
                }

                //$name = $line;
                //$name = substr($line, -3) != "pts" ? $line : "";

                if ($isReadingEnhancements) {
                    if (substr($line, -3) == "pts") { //si la linea en los ultimos 3 caracteres dice "pts"...
                        $firstPointPos = strpbrk($line, ".");
                        $name = substr($line, 0, strpos($line, $firstPointPos));
                        $models = 1;
                        if (strpos($line, "pts")) {
                            $points = (integer)substr($line, strrpos($line, ".") + 1, strpos($line, "pts"));
                        }

                        //ini duplicado
                        $indice++;
                        $item = array(
                            'faction' => $faction,
                            'name' => $name,
                            'models' => $models,
                            'points' => $points,
                            'fullName' => "Enhancement: " . $name,
                        );
                        $lista[] = $item;
                        //fin duplicado

                    }
                } else {
                    $name = substr($line, -3) != "pts" ? $line : "";
                }


                if ($isReadingFaction) {
                    $faction = $line;
                    $isReadingFaction = false;
                }

            } elseif (ctype_digit($firstChar)) {

                if (ctype_digit($line)) {

                    if ($isReadingEnhancements) {
                        $isReadingEnhancements = false;
                    }
                    if (!in_array($line, [6, 9, 25, 27])) {
                        $isReadingFaction = true;
                        continue;
                    }

                }

                $firstWhiteSpacePos = strpbrk($line, " ");

                $models = (integer)substr($line, 0, strpos($line, $firstWhiteSpacePos));

                if (strpos($line, "pts")) {
                    $points = (integer)substr($line, strrpos($line, ".") + 1, strpos($line, "pts"));
                }

                //ini duplicado
                $indice++;

                if ($models > 1) {
                    $detailName = $models . "x " . $name;
                } else {
                    $detailName = $name;
                }

                $item = array(
                    'faction' => $faction,
                    'name' => $name,
                    'models' => $models,
                    'points' => $points,
                    'fullName' => $detailName
                );
                $lista[] = $item;
                //fin duplicado
            }
        }
    }

    $salvarDatos = function($lista) {
        $datos = [];

        foreach ($lista as $fila) {
            $fila_comilla = str_replace("’", "'", $fila);
            $datos[] = $fila_comilla;
        }

        $json = json_encode($datos, JSON_UNESCAPED_UNICODE);

        $file_path = '../data/monitorum.js';
        file_put_contents($file_path, 'let jsonData = ' . $json . ';');

        echo "Done!";
    };

    $salvarDatos($lista);

}
?>