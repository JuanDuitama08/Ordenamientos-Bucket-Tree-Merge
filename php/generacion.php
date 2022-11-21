<?php
    include("generarMatrices.php");
    include("cargoArchivo.php");
    include("bucketSort.php");
    include("mergeSort.php");
    include("treeSort.php");

    //Instanci de ls operciones entre clases
    $generararreglo= new generarMatrices;
    $leerArchivo= new cargoArchivo;
    $ordenamiento_TreeSort = new implementacion();
    $ordenamiento_Bucketsort = new implementacionB();

    //Definiciónn de variables
    $arreglo_tiempos;
    $arreglo_tiemposB;
    $arreglo_tiemposM;
    $arreglo_iteraciones;

    $cant_elementosB;
    $sum_tiemposB;

    $cant_elementosM;
    $sum_tiemposM;

    $cant_elementosT;
    $sum_tiemposT;

    $cantAlgoritmos= 0;
    $algoritmos;


    //Conocer que algoritmos escogió el usuario
    if (empty($_POST['algoritmo1'])){
        $bucket = "0";
        $arreglo_tiemposB[0] = 0;
    }else{
        $bucket=$_POST['algoritmo1'];
        $algoritmos[$cantAlgoritmos] = $bucket;
        $cantAlgoritmos = $cantAlgoritmos + 1;
    }

    if (empty($_POST['algoritmo3'])){
        $tree = "0";
        $arreglo_tiempos[0] = 0;
    }else{
        $tree=$_POST['algoritmo3'];
        $algoritmos[$cantAlgoritmos] = $tree;
        $cantAlgoritmos = $cantAlgoritmos + 1;
    }

    if (empty($_POST['algoritmo2'])){
        $merge = "0";
        $arreglo_tiemposM[0] = 0;
    }else{
        $merge=$_POST['algoritmo2'];
        $algoritmos[$cantAlgoritmos] = $merge;
        $cantAlgoritmos = $cantAlgoritmos + 1;
    }


    $arreglo_nombres;

	// $algoritmo=$_POST['algoritmo'];

    $tipo_cargue=$_POST['flexRadioDefault'];

    if($tipo_cargue == "archivo"){


        $iteraciones = 0;
        $files = glob('../archivos/*.txt'); //obtenemos todos los nombres de los ficheros
        foreach($files as $file){
            if(is_file($file))
            unlink($file); //elimino el fichero
        }        

    //Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
        foreach($_FILES["adjunto"]['tmp_name'] as $key => $tmp_name)
        {
            //Validamos que el archivo exista
            if($_FILES["adjunto"]["name"][$key]) {
                $filename = $_FILES["adjunto"]["name"][$key]; //Obtenemos el nombre original del archivo
                $source = $_FILES["adjunto"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
                
                $directorio = '../archivos/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
                
                $dir=opendir($directorio); //Abrimos el directorio de destino
                $target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
                
                //Movemos y validamos que el archivo se haya cargado correctamente
                //El primer campo es el origen y el segundo el destino
                if(move_uploaded_file($source, $target_path)) {	
                    $arreglo_nombres[$iteraciones]=$_FILES["adjunto"]["name"][$key];
                    $iteraciones =  $iteraciones + 1 ;
                    } else {	
                    echo "Ha ocurrido un error, por favor inténtelo de nuevo.<br>";
                }
                closedir($dir); //Cerramos el directorio de destino
            }
        }

    }else{
        $nombre_archivo="null";
 	    $datos_inicio = $_POST['numeros_inicio'];
        $tipo_dato=$_POST['flexRadioDefault_tipo'];
        $avance_iteracion = $_POST['avance_iteracion'];
        $iteraciones=$_POST['Iteraciones'];

        if( $datos_inicio == "Otro"){
            $datos_inicio=$_POST['otro1'];
        }

        if( $avance_iteracion == "Otro"){
            $avance_iteracion=$_POST['otro2'];
        }  
    }

    $x = true;
    for ($j = 0; $j < $cantAlgoritmos; $j++){
        switch ($algoritmos[$j]) { 
            case "Bucket sort":
                $x = 0;
                for ($i = 0; $i < $iteraciones; $i++) {
                    if($tipo_cargue=="archivo"){  
                        $arreglo=$leerArchivo->leerArchivo($arreglo_nombres[$i]);
                        $datos_inicio= count($arreglo);

                        $tiempo_inicial = microtime(true);
                        $ordenamiento_Bucketsort-> BucketSort($arreglo);
                        $tiempo_final = microtime(true);

                        foreach ($arreglo as $value) {
                            $value = $value;
                            settype($value,"integer");
                            echo gettype($value), "\n";
                        }

                        $tiempoB = $tiempo_final - $tiempo_inicial;
            
                        $arreglo_tiemposB[$i]=$tiempoB;
                        $arreglo_iteraciones[$i]=$datos_inicio;
                    }elseif($tipo_cargue=="aleatorios"){
                        if($tipo_dato=="numerico"){
                            $arreglo=$generararreglo -> arrayNumerico($datos_inicio);
                            $x = true;
                        }elseif($tipo_dato=="letras"){
                            $arreglo=$generararreglo -> arrayPalabras($datos_inicio);
                            $x = false;
                        }

                        if($x == true){
                            print_r("Entro numeros");
                            $tiempo_inicial = microtime(true);
                            $ordenamiento_Bucketsort-> BucketSort($arreglo);
                            $tiempo_final = microtime(true);

                        }elseif($x == false){
                            print_r("Entro Letras");
                            $tiempo_inicial = microtime(true);
                            $ordenamiento_Bucketsort-> BucketSortL($arreglo);
                            $tiempo_final = microtime(true);                    
                        }

                        $tiempoB = $tiempo_final - $tiempo_inicial;                        
                        $arreglo_tiemposB[$i]=$tiempoB;
                        $arreglo_iteraciones[$i]=$datos_inicio;

                        $datos_inicio = $datos_inicio + $avance_iteracion ;

                        $cant_elementosB = count($arreglo_tiemposB);
                        $sum_tiemposB = array_sum($arreglo_tiempoSB);

                        $promB = $sum_tiemposB/$cant_elementosB;

                    }
                }
                break;
            case "Merge sort":
                for ($i = 0; $i < $iteraciones; $i++) {
                    if($tipo_cargue=="archivo"){  
                        $arreglo=$leerArchivo->leerArchivo($arreglo_nombres[$i]);
                        $datos_inicio= count($arreglo);



                        $tiempo_inicial = microtime(true);
                        merge_sort($arreglo);
                        $tiempo_final = microtime(true);

                    
                        $tiempoM = $tiempo_final - $tiempo_inicial;
            
                        $arreglo_tiemposM[$i]=$tiempoM;
                        $arreglo_iteraciones[$i]=$datos_inicio;
                    }elseif($tipo_cargue=="aleatorios"){
                        if($tipo_dato=="numerico"){
                            $arreglo=$generararreglo -> arrayNumerico($datos_inicio);
                        }elseif($tipo_dato=="letras"){
                            $arreglo=$generararreglo -> arrayPalabras($datos_inicio);
                        } 

                        $tiempo_inicial = microtime(true);
                        merge_sort($arreglo);
                        $tiempo_final = microtime(true);
                        
                    
                        $tiempoM = $tiempo_final - $tiempo_inicial;
            
                        $arreglo_tiemposM[$i]=$tiempoM;
                        $arreglo_iteraciones[$i]=$datos_inicio;

                        $datos_inicio = $datos_inicio + $avance_iteracion ;

                        $cant_elementosM = count($arreglo_tiemposM);
                        $sum_tiemposM = array_sum($arreglo_tiemposM);

                        $promM = $sum_tiemposM/$cant_elementosM;
                    }
                }
                break;
            case "Tree sort":
                for ($i = 0; $i < $iteraciones; $i++) {
                    if($tipo_cargue=="archivo"){  
                        $arreglo=$leerArchivo->leerArchivo($arreglo_nombres[$i]);

                        $datos_inicio= count($arreglo);
                        $tiempo_inicial = microtime(true);
                        $ordenamiento_TreeSort-> crearArbol($arreglo);
                        $tiempo_final = microtime(true);
                    
                        $tiempo = $tiempo_final - $tiempo_inicial;
            
                        $arreglo_tiempos[$i]=$tiempo;
                        $arreglo_iteraciones[$i]=$datos_inicio;
                    }elseif($tipo_cargue=="aleatorios"){
                        if($tipo_dato=="numerico"){
                            $arreglo=$generararreglo -> arrayNumerico($datos_inicio);
                        }elseif($tipo_dato=="letras"){
                            $arreglo=$generararreglo -> arrayPalabras($datos_inicio);
                        } 

                        $tiempo_inicial = microtime(true);
                        $ordenamiento_TreeSort-> crearArbol($arreglo);
                        $tiempo_final = microtime(true);
                    
                        $tiempo = $tiempo_final - $tiempo_inicial;
            
                        $arreglo_tiempos[$i]=$tiempo;
                        $arreglo_iteraciones[$i]=$datos_inicio;

                        $datos_inicio = $datos_inicio + $avance_iteracion ;

                        $cant_elementosT = count($arreglo_tiempos);
                        $sum_tiemposT = array_sum($arreglo_tiempos);

                        $promT = $sum_tiemposT/ $cant_elementosT;
                    }
                }
                break;            
            default;
                echo '<script> alert("¡Seleccione un algoritmo!\n");location.href="../index.php";</script>';
            break;
        }
    }



?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../images/favicon.png" rel="icon" />
<title>Analisis de algoritmos</title>
<meta name="description" content="Simone is responsive bootstrap 5 one page personal portfolio html template.">
<meta name="author" content="harnishdesign.net">

<!-- Web Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">

<!-- Stylesheet
============================== -->
<!-- Bootstrap -->
<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css" />
<!-- Font Awesome Icon -->
<link rel="stylesheet" type="text/css" href="../vendor/font-awesome/css/all.min.css" />
<link rel="stylesheet" href="css/font-awesome.min.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="css/styles.css">
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- Owl Carousel -->
<link rel="stylesheet" type="text/css" href="../vendor/owl.carousel/assets/owl.carousel.min.css" />
<!-- Magnific Popup -->
<link rel="stylesheet" type="text/css" href="../vendor/magnific-popup/magnific-popup.min.css" />
<!-- Youtube Video Background -->
<link rel="stylesheet" type="text/css" href="../vendor/jquery.mb.YTPlayer/css/jquery.mb.YTPlayer.min.css" />
<!-- Custom Stylesheet -->
<link rel="stylesheet" type="text/css" href="../css/stylesheet.css" />
<!-- Colors Css -->
<link id="color-switcher" type="text/css" rel="../stylesheet" href="#" />

<link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
</head>
<body class="side-header" data-bs-spy="scroll" data-bs-target="#header-nav" data-bs-offset="1">

<!-- Preloader -->
<div class="preloader">
    <div class="lds-ellipsis">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<!-- Preloader End -->

<!-- Document Wrapper   
=============================== -->
<div id="main-wrapper"> 
    <!-- Header
    ============================ -->
    <header id="header" class="sticky-top"> 
        <!-- Navbar -->
        <nav class="primary-menu navbar navbar-expand-lg navbar-dark bg-dark border-bottom-0">
        <div class="container-fluid position-relative h-100 flex-lg-column ps-3 px-lg-3 pt-lg-3 pb-lg-2"> 
            
            <!-- Logo --> 
            <a href="../index.php" class="mb-lg-auto mt-lg-4">
                <span class="bg-dark-2 rounded-pill p-2 mb-lg-1 d-none d-lg-inline-block">
                    <img class="img-fluid rounded-pill d-block" src="../images/profile.jpg" title="Analisis de algoritmos" alt="">
                </span>
                <h1 class="text-5 text-white text-center mb-0 d-lg-block">Sorting Methods</h1>
            </a> 
            <!-- Logo End -->
            
            <div id="header-nav" class="collapse navbar-collapse w-100 my-lg-auto">
            <ul class="navbar-nav text-lg-center my-lg-auto py-lg-3">
                <li class="nav-item"><a class="nav-link smooth-scroll active" href="#complex">Complexities</a></li>
                <li class="nav-item"><a class="nav-link smooth-scroll" href="#temp">Temporal graph</a></li>
                <li class="nav-item"><a class="nav-link smooth-scroll" href="#data">Data tables</a></li>
            </ul>
            </div>
            <ul class="social-icons social-icons-muted social-icons-sm mt-lg-auto ms-auto ms-lg-0 d-flex">
            <li class="social-icons-facebook"><a data-bs-toggle="tooltip" title="Facebook" href="http://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
            <li class="social-icons-twitter"><a data-bs-toggle="tooltip" title="Twitter" href="http://www.twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a></li>
            <li class="social-icons-dribbble"><a data-bs-toggle="tooltip" title="Dribbble" data-bs-placement="top" href="http://www.dribbble.com/" target="_blank"><i class="fab fa-dribbble"></i></a></li>
            <li class="social-icons-github"><a data-bs-toggle="tooltip" title="GitHub" data-bs-placement="top" href="https://github.com/JuanDuitama08" target="_blank" ><i class="fab fa-github"></i></a></li>
            </ul>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#header-nav"><span></span><span></span><span></span></button>
        </div>
        </nav>
        <!-- Navbar End --> 
    </header>
    <!-- Header End --> 

    <div id="content" role="main">
        
        
        <!-- Complexities section 
        ============================================= -->
        <section id="complex" class="section">
        <div class="container px-lg-5"> 
            <!-- Heading -->
            <div class="position-relative d-flex text-center mb-5">
            <h2 class="text-24 text-light opacity-4 text-uppercase fw-600 w-100 mb-0">Complexities </h2>
            <p class="text-9 text-dark fw-600 position-absolute w-100 align-self-center lh-base mb-0">Temporal behavior<span class="heading-separator-line border-bottom border-3 border-primary d-block mx-auto"></span> </p>
            </div>
            <!-- Heading end-->
            
            <!-- Filter Menu -->
            <ul class="portfolio-menu nav nav-tabs justify-content-center border-bottom-0 mb-5">
            <li class="nav-item"> <a data-filter="*" class="nav-link active" href="#">All</a></li>
            </ul>
            <!-- Filter Menu end -->
            <div class="portfolio popup-img-gallery">
            <div class="row portfolio-filter g-4">
                <div class="col-sm-6 col-lg-4 brand">
                    <div class="portfolio-box rounded">
                        <div class="portfolio-img rounded"> <img class="img-fluid d-block" src="../images/projects/project-1.jpg" alt="">
                        <div class="portfolio-overlay"> <a class="popup-ajax stretched-link" href="../images/complexity/1.png"></a>
                            <div class="portfolio-overlay-details">
                            <h5 class="text-white fw-400">Merge sort</h5>
                            <span class="text-light">Category</span> </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-6 col-lg-4 design">
                    <div class="portfolio-box rounded">
                        <div class="portfolio-img rounded"> <img class="img-fluid d-block" src="../images/projects/project-5.jpg" alt="">
                        <div class="portfolio-overlay"> <a class="popup-ajax stretched-link" href="../images/complexity/2.png"></a>
                            <div class="portfolio-overlay-details">
                            <h5 class="text-white fw-400">Bucket sort</h5>
                            <span class="text-light">Category</span> </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-6 col-lg-4 artwork photos">
                    <div class="portfolio-box rounded">
                        <div class="portfolio-img rounded"> <img class="img-fluid d-block" src="../images/projects/project-3.jpg" alt="">
                        <div class="portfolio-overlay"> <a class="popup-ajax stretched-link" href="../images/complexity/3.png"></a>
                            <div class="portfolio-overlay-details">
                            <h5 class="text-white fw-400">Tree sort</h5>
                            <span class="text-light">Category</span> </div>
                        </div>                            
                        </div>
                        
                    </div>
                </div>
            
            </div>       
            
        </div>
        </section>
        <!-- Complexities  end --> 

        <!-- Temporal graphs section 
        ============================================= -->
        <section id="temp" class="section bg-light">
        <div class="container px-lg-5"> 
            <!-- Heading -->
            <div class="position-relative d-flex text-center mb-5">
            <h2 class="text-24 text-light opacity-4 text-uppercase fw-600 w-100 mb-0">Temporal graphs </h2>
            <p class="text-9 text-dark fw-600 position-absolute w-100 align-self-center lh-base mb-0">with the three algorithms<span class="heading-separator-line border-bottom border-3 border-primary d-block mx-auto"></span> </p>
            </div>
            <!-- Heading end-->
            
            <div class="row gy-12">
            <div class="col-lg-7 col-xl-12 text-center text-lg-start">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <h1 id="Generalidades">Time VS Iterations </h1>
                </div>
                <div>
                    <h4>Line chart</h4>
                        <canvas id="myChart2"></canvas>
                    <h4>Comparative time chart</h4>
                        <canvas id="myChart3"></canvas>
                </div>
            </div>  
            </div>       
            
        </div>
        </section>
        <!-- Temporal graphs  end --> 
        
        <!-- Data tables
        ============================================= -->
        <section id="data" class="section">
        <div class="container px-lg-5"> 
            <!-- Heading -->
            <div class="position-relative d-flex text-center mb-5">
            <h2 class="text-24 text-light opacity-4 text-uppercase fw-600 w-100 mb-0">Data tables</h2>
            <p class="text-9 text-dark fw-600 position-absolute w-100 align-self-center lh-base mb-0">On each iteration<span class="heading-separator-line border-bottom border-3 border-primary d-block mx-auto"></span> </p>
            </div>
            <!-- Heading end-->
            
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h1 id="head1" >Bucket sort Algorithm</h1>
                    <table class="table table-dark table-striped" id="tabla1">
                        <thead>
                            <tr>
                                <th scope="col">Iterations number</th>
                                <th scope="col">Number of executions</th>
                                <th scope="col">Time</th>
                                <?php
                                    if($tipo_cargue == "archivo"){
                                ?>
                                <th scope="col">File Name</th>
                                <?php
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                for ($i = 0; $i <= count($arreglo_iteraciones)-1; $i++) {
                            ?>
                            <tr>
                                <td><?php echo($i+1);?></td>
                                <td><?php echo($arreglo_iteraciones[$i]);?></td>
                                <td><?php echo($arreglo_tiemposB[$i]);?></td>                                
                                <?php
                                    if($tipo_cargue == "archivo"){
                                ?>
                                <td><?php echo($arreglo_nombres[$i]);?></td>
                                <?php
                                    }
                                ?>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <h1 id="head2" >Merge sort Algorithm </h1>
                    <table class="table table-dark table-striped" id="tabla2">
                        <thead>
                            <tr>
                                <th scope="col">Iterations number</th>
                                <th scope="col">Number of executions</th>
                                <th scope="col">Time</th>
                                <?php
                                    if($tipo_cargue == "archivo"){
                                ?>
                                <th scope="col">File Name</th>
                                <?php
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                for ($i = 0; $i <= count($arreglo_iteraciones)-1; $i++) {
                            ?>
                            <tr>
                                <td><?php echo($i+1);?></td>
                                <td><?php echo($arreglo_iteraciones[$i]);?></td>
                                <td><?php echo($arreglo_tiemposM[$i]);?></td>
                                <?php
                                    if($tipo_cargue == "archivo"){
                                ?>
                                <td><?php echo($arreglo_nombres[$i]);?></td>
                                <?php
                                    }
                                ?>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <h1 id="head3" > Tree sort Algorithm</h1>
                    <table class="table table-dark table-striped" id="tabla3">
                        <thead>
                            <tr>
                                <th scope="col">Iterations number</th>
                                <th scope="col">Number of executions</th>
                                <th scope="col">Time</th>
                                <?php
                                    if($tipo_cargue == "archivo"){
                                ?>
                                <th scope="col">File Name</th>
                                <?php
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                for ($i = 0; $i <= count($arreglo_iteraciones)-1; $i++) {
                            ?>
                            <tr>
                                <td><?php echo($i+1);?></td>
                                <td><?php echo($arreglo_iteraciones[$i]);?></td>
                                <td><?php echo($arreglo_tiempos[$i]);?></td>
                                <?php
                                    if($tipo_cargue == "archivo"){
                                ?>
                                <td><?php echo($arreglo_nombres[$i]);?></td>
                                <?php
                                    }
                                ?>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>        
                </div>
            </div>
            </div>
            <center> <button type="button" class="btn btn-primary"
                            onclick="location.href='../index.php'">Go Back</button></center>
        </div>
        </section>
        <!-- Data tables end -->    
    </div>


<!-- Footer
    ============================================= -->
    <footer id="footer" class="section">
        <div class="container px-lg-5">
        <div class="row">
            <div class="col-lg-6 text-center text-lg-start">
            <p class="mb-3 mb-lg-0">Copyright © 2022 <a href="#" class="fw-500">Simone</a>. All Rights Reserved.</p>
            </div>
            <div class="col-lg-6">
            <ul class="nav nav-separator justify-content-center justify-content-lg-end">
                <li class="nav-item"> <a class="nav-link" data-bs-toggle="modal" data-bs-target="#terms-policy" href="#">Terms & Policy</a></li>
                <li class="nav-item"> <a class="nav-link" data-bs-toggle="modal" data-bs-target="#disclaimer" href="#">Disclaimer</a></li>
            </ul>
            </div>
        </div>
        </div>
    </footer>
    <!-- Footer end --> 
</div>

<!-- Styles Switcher End --> 

<!-- JavaScript --> 
<script src="../vendor/jquery/jquery.min.js"></script> 
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script> 
<!-- Easing --> 
<script src="../vendor/jquery.easing/jquery.easing.min.js"></script> 
<!-- Appear --> 
<script src="../vendor/jquery.appear/jquery.appear.min.js"></script> 
<!-- Images Loaded --> 
<script src="../vendor/imagesloaded/imagesloaded.pkgd.min.js"></script> 
<!-- Counter --> 
<script src="../vendor/jquery.countTo/jquery.countTo.min.js"></script> 
<!-- Parallax Bg --> 
<script src="../vendor/parallaxie/parallaxie.min.js"></script> 
<!-- Typed --> 
<script src="../vendor/typed/typed.min.js"></script> 
<!-- Youtube Video Background --> 
<script src="../vendor/jquery.mb.YTPlayer/jquery.mb.YTPlayer.min.js"></script> 
<!-- Owl Carousel --> 
<script src="../vendor/owl.carousel/owl.carousel.min.js"></script> 
<!-- isotope Portfolio Filter --> 
<script src="../vendor/isotope/isotope.pkgd.min.js"></script> 
<!-- Magnific Popup --> 
<script src="../vendor/magnific-popup/jquery.magnific-popup.min.js"></script> 
<!-- Style Switcher --> 
<script src="../js/switcher.min.js"></script> 
<!-- Custom Script --> 
<script src="../js/theme.js"></script>

<script>
    const ejecucionesTree = <?php echo json_encode($arreglo_iteraciones) ?>;
    const iteracionesTree = <?php echo json_encode($arreglo_tiempos) ?>;
    const iteracionesBuck= <?php echo json_encode($arreglo_tiemposB) ?>;
    const iteracionesMerge= <?php echo json_encode($arreglo_tiemposM) ?>;
    var buck_val = <?php echo json_encode($bucket) ?>;
    var tree_val = <?php echo json_encode($tree) ?>;
    var merge_val = <?php echo json_encode($merge) ?>;

    //validaciones en caso de que no se escoja alguno
    if(buck_val == 0){
        document.getElementById("tabla1").style.display = "none";
        document.getElementById('head1').style.display = 'none';  
    }
    if(tree_val == 0){
        document.getElementById("tabla3").style.display = "none";
        document.getElementById('head3').style.display = 'none';  
    }
    if(merge_val == 0){
        document.getElementById('tabla2').style.display = 'none';                                           
        document.getElementById('head2').style.display = 'none';                                           
    }
    

    var ctx1 = document.getElementById('myChart2').getContext('2d');
    var chart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ejecucionesTree,
            datasets: [{
                label: 'Tree sort',
                backgroundColor: '#42a5f5',
                borderColor: 'gray',
                data: iteracionesTree,
            },{
                label: 'Bucket sort',
                backgroundColor: '#ffab91',
                borderColor: 'yellow',
                data: iteracionesBuck,
            },
            {
                label: 'Merge sort',
                backgroundColor: '#82bb00',
                borderColor: 'green',
                data: iteracionesMerge,
            }	
            ]},
        options: {}
    });
    </script>

    <script>
        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Chart.js Line Chart'
                }
                }
            },
            };
    </script>
    <script>
        // <block:actions:2>
        const actions = [
        {
            name: 'Randomize',
            handler(chart) {
            chart.data.datasets.forEach(dataset => {
                dataset.data = Utils.numbers({count: chart.data.labels.length, min: -100, max: 100});
            });
            chart.update();
            }
        },
        {
            name: 'Add Dataset',
            handler(chart) {
            const data = chart.data;
            const dsColor = Utils.namedColor(chart.data.datasets.length);
            const newDataset = {
                label: 'Dataset ' + (data.datasets.length + 1),
                backgroundColor: Utils.transparentize(dsColor, 0.5),
                borderColor: dsColor,
                borderWidth: 1,
                data: Utils.numbers({count: data.labels.length, min: -100, max: 100}),
            };
            chart.data.datasets.push(newDataset);
            chart.update();
            }
        },
        {
            name: 'Add Data',
            handler(chart) {
            const data = chart.data;
            if (data.datasets.length > 0) {
                data.labels = Utils.months({count: data.labels.length + 1});

                for (let index = 0; index < data.datasets.length; ++index) {
                data.datasets[index].data.push(Utils.rand(-100, 100));
                }

                chart.update();
            }
            }
        },
        {
            name: 'Remove Dataset',
            handler(chart) {
            chart.data.datasets.pop();
            chart.update();
            }
        },
        {
            name: 'Remove Data',
            handler(chart) {
            chart.data.labels.splice(-1, 1); // remove the label first

            chart.data.datasets.forEach(dataset => {
                dataset.data.pop();
            });

            chart.update();
            }
        }
        ];
        // </block:actions>

        // <block:setup:1>
        const DATA_COUNT = 7;
        const NUMBER_CFG = {count: DATA_COUNT, min: -100, max: 100};

        const labels = Utils.months({count: 7});
        const data = {
        labels: labels,
        datasets: [
            {
            label: 'Dataset 1',
            data: Utils.numbers(NUMBER_CFG),
            borderColor: Utils.CHART_COLORS.red,
            backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
            },
            {
            label: 'Dataset 2',
            data: Utils.numbers(NUMBER_CFG),
            borderColor: Utils.CHART_COLORS.blue,
            backgroundColor: Utils.transparentize(Utils.CHART_COLORS.blue, 0.5),
            }
        ]
        };
        // </block:setup>

        // <block:config:0>
        const config = {
        type: 'bar',
        data: data,
        options: {
            indexAxis: 'y',
            // Elements options apply to all of the options unless overridden in a dataset
            // In this case, we are setting the border of each horizontal bar to be 2px wide
            elements: {
            bar: {
                borderWidth: 2,
            }
            },
            responsive: true,
            plugins: {
            legend: {
                position: 'right',
            },
            title: {
                display: true,
                text: 'Chart.js Horizontal Bar Chart'
            }
            }
        },
        };
        // </block:config>

        module.exports = {
        actions: actions,
        config: config,
        };
    </script>

    <script>
        const config2 = {
        type: 'bar',
        data,
        options: {
            indexAxis: 'y',
        }
        };
    </script>
<script> 
    $(window).load(function() {
        $(".loader").fadeOut("slow");
    });
</script>
</body>
</html>