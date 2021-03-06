<?php
    //importamos clases
    include '../../class/database.php';
    include '../../class/update.php';
    include '../../class/consultas.php';
    
    //creamos objetos de las clases
    $claseModicar = new update();
    $claseConsultas = new consultas();
    $nombre = ( $_POST['nomCli'] !== "" ) ? $_POST['nomCli'] : null ;
    $telefono = ( $_POST['numCli'] !== "" ) ? $_POST['numCli'] : null ;
    $descripcion = ( $_POST['Descripcion'] !== "") ? $_POST['Descripcion'] : null;
    $precioTotal = ( $_POST['PrecioTotal'] !== "") ? $_POST['PrecioTotal'] : null;
    $aporte = ( $_POST['aporte'] !== "") ? $_POST['aporte'] : null;
    $direccion = ( $_POST['direccion'] !== "") ? $_POST['direccion'] : null;
    $tipoEvento = ( $_POST['tipoEvento'] !== "") ? $_POST['tipoEvento'] : null;
    $hora = ( $_POST['hora'] !== "") ? $_POST['hora'] : null;
    $cantidadHoras = ( $_POST['cantidadHoras'] !== "") ? $_POST['cantidadHoras'] : null;
    $fecha = ( $_POST['fecha'] !== "") ? $_POST['fecha'] : null;
    $id = ( $_POST['id'] !== "") ? $_POST['id'] : null;

    $claseValidar = new validar();

    $errores = [];
    if($claseValidar->isName($nombre) === 0 ){
        $errores[] = "por favor ingresa un nombre valido";
    }
    if( $claseValidar->isPhone( $telefono ) === 0 ){
        $errores[] = "ingresa un Numero valido ";
    }
    if($claseValidar->isNumber( $precioTotal ) === 0 ){
        $errores[] = "ingresa un monto valido";
    }
    if($claseValidar->isNumber( $aporte ) === 0) {
        $errores[] = "ingresa un monto valido";
    }
    
    if(count($errores) === 0){
        $validarUsuario = $claseConsultas->validateTocada($hora, $cantidadHoras, $fecha);
        $respuesta = null;
        if(!$validarUsuario){
            $respuesta = $claseModicar->updateTocada($nombre, $telefono, $hora, $descripcion, $precioTotal, $aporte, $direccion, $tipoEvento, $cantidadHoras, $fecha, $id);
        }else{
            $respuesta["estatus"] = "error";
            $respuesta["mensaje"] = "apartado, Selecciona otra hora";
        }
        echo json_encode($respuesta);           
    }else{
        echo json_encode($errores);
    }


    class validar{
        
        public function isEmpty( $string ) {
            return isset($string);
        }

        public function isName( $string ) {
            $regex = "/^[a-z-A-Z\D]+$/";
            return preg_match( $regex , $string );
        }

        public function isPhone( $phone ) {
            $regex = "/^[0-9-]*$/";
            return preg_match( $regex , $phone );
        }
        public function isNumber( $int ) {
            $regex = "/^[+-]?[0-9]{1,3}(?:,?[0-9]{3})*\.[0-9]{2}$/";
            return preg_match( $regex , $int );
        }

    }