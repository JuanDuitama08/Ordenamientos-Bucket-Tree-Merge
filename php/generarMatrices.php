<?php
class generarMatrices{
    private $arreglo;
    // use the factory to create a Faker\Generator instance
    
    public function arrayNumerico($cantidad_de_datos){

        for ($i = 1; $i <= $cantidad_de_datos; $i++) {
            $arreglo[]= rand(0, 1000000);
        }
        //print_r($arreglo);
        return $arreglo;
    }

    public function arrayPalabras($cantidad_de_datos){
        $palabras = array("Hugo", "Martín", "Lucas", "Mateo", "Leo", "Daniel", "Alejandro", "Pablo", "Manuel", "Álvaro", "Adrián", "David", "Mario", "Enzo", "Diego", "Marcos", "Izan", "Javier", "Marco", "Álex", "Bruno", "Oliver", "Miguel", "Thiago", "Antonio", "Marc", "Carlos", "Ángel", "Juan", "Gonzalo", "Gael", "Sergio", "Nicolás", "Dylan", "Gabriel", "Jorge", "José", "Adam", "Liam", "Eric", "Samuel", "Darío", "Héctor", "Luca", "Iker", "Amir", "Rodrigo", "Saúl", "Víctor", "Francisco", "Iván", "Jesús", "Jaime", "Aarón", "Rubén", "Ian", "Guillermo", "Erik", "Mohamed", "Julen", "Luis", "Pau", "Unai", "Rafael", "Joel", "Alberto", "Pedro", "Raúl", "Aitor", "Santiago", "Rayan", "Pol", "Nil", "Noah", "Jan", "Asier", "Fernando", "Alonso", "Matías", "Biel", "Andrés", "Axel", "Ismael", "Martí", "Arnau", "Imran", "Luka", "Ignacio", "Aleix", "Alan", "Elías", "Omar", "Isaac", "Youssef", "Jon", "Teo", "Mauro", "Óscar", "Cristian", "Leonardo");
        for ($i = 1; $i <= $cantidad_de_datos; $i++) {
            $arreglo[]= $palabras[rand(0,count($palabras)-1)];
        }
        //print_r($arreglo);
        return $arreglo;
    }    
};
?>