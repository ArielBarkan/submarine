<?php
/**
 * User: ariel
 * Date: 9/2/17
 * Time: 11:49 PM
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);




init(4, "A2 B3,B4 D4", "D1 A2 C3"); // OUTPUT 1,0 (1 hits, 0 sunk)
init(10, "B2 E4,G6 G9,H3 J3", "D1 A2 B4 C4 B2 I3"); // OUTPUT 4,0 (4 hits, 0 sunk)
init(5, "B2 B3,C4 E5", "B2 B3 D5 D1"); // OUTPUT 3,1 (3 hits, 1 sunk)



function init($N, $S, $T){

    echo "<b>Start and End point of ships (from top left to  bottom right)</b>  = ".$S."<br>";
    echo "<b>Missiles fired by enemy</b>= ".$T."<br>";
    echo "<b>Game board size (provided but not relevant to the solution)</b> = $N X $N <br>";
    echo "Solution (Number of hits on ships, number of sunken ships)<br>";

    unset($N);
    echo getShips($S, $T);
    echo "<hr>";
}


function getShips($S, $T){

    $totalHits  = 0;
    $totalSunk  = 0;
    $shipsChunk = explode(",", $S);
    foreach($shipsChunk as $key => $singleShipLimits ){
        $singleShipStatus =   createFullShipsArrayByProvidedCellsAndCheckHits($singleShipLimits, $T);
        $totalHits  += $singleShipStatus["hits"];
        $totalSunk  += $singleShipStatus["sunk"];
    }

    return $totalHits.",".$totalSunk;
}




function createFullShipsArrayByProvidedCellsAndCheckHits($singleShipLimits, $T){
    $hitsInCurrentShip = 0;
    $currentShipCompleted = array();

    $hitsArray = explode(" ", $T);
    $singleChunk = explode(" ", $singleShipLimits);


    $startPoint = ["letter" =>   str_split($singleChunk[0])[0], "number" =>   (int)str_split($singleChunk[0])[1]];
    $endPoint   = ["letter" =>   str_split($singleChunk[1])[0], "number" =>   (int)str_split($singleChunk[1])[1]];


        for($n=$startPoint["number"]; $n<= $endPoint["number"]; $n++) {
            for($l=(ltn($startPoint["letter"])); $l<= (ltn($endPoint["letter"])); $l++) {
                $newCell = ntl($l).$n;
                array_push($currentShipCompleted, $newCell);
            }
        }

    foreach ($currentShipCompleted as &$cube){
        $hitsInCurrentShip+=(in_array($cube, $hitsArray))?1:0;
    }

    return ["hits" => $hitsInCurrentShip, "sunk" => ($hitsInCurrentShip == count($currentShipCompleted))?1:0 ];
}

/**
 * @param $letter
 * @return int
 * convert letter to number (a=1, c=3 ....)
 */
function ltn($letter){
    return (ord(strtolower($letter)) - 96);
}

/**
 * @param $number
 * @return string
 * convert number to letter (1=a, c=3 ....)
 */
function ntl($number){
    return chr(substr("000".($number+64),-3));
}