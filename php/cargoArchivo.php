<?php

class cargoArchivo{

    private $arreglo;

    public function leerArchivo($nombreArchivo){

        if ($file = fopen("../archivos/".$nombreArchivo, "r")) {
            while(!feof($file)) {
                $line = fgets($file);
               $arreglo[]=$line;
            }
            fclose($file);
        }   
        //print_r($arreglo);
        return $arreglo;    
    }

};
?>