<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../webroot/css/estilo.css">
        <title>MtoDepartamentosModificar</title>
        <style>
            label{
                display: block;
            }
            form{
                text-align: center;
                position: absolute;
                right: 25%;
                width: 50vw;
                margin-top: 30px;
            }
            legend{
                border: 1px solid black;
                font-weight: bold;
            }
            p{
                color: red;
            }
        </style>
    </head>
    <body>
        <?php
            include '../core/210322ValidacionFormularios.php';//Incluir la libreria de validación de formularios
            include "../config/confDBPDO.php";//Incluir el archivo de conexión con la base de datos
        
            //Definir constantes
            define("OBLIGATORIO", 1);
            define("OPCIONAL", 0);
            define("MIN_TAMANIO", 0);
            
            //Definir array para almacenar errores
            $aErrores=[
                "descripcion"=>null,
                "volumen"=>null,
            ];
            
            //Definir array para almacenar respuestas correctas
            $aCorrecto=[
                "descripcion"=>null,
                "volumen"=>null,
            ];
            
            //Inicializar variable que controlara si los campos estan correctos
            $entradaOK=true;
            
            //Comprobar si se ha pulsado el boton de cancelar
            if(isset($_REQUEST['cancelar'])){
                header("Location: ./MtoDepartamentos.php");
            }
            
            //Comprobar si se ha pulsado el boton de aceptar
            if(isset($_REQUEST['aceptar'])){
                //Comprobar si los campos son correctos
                $aErrores["descripcion"]=validacionFormularios::comprobarAlfaNumerico($_REQUEST["descripcion"], 255, MIN_TAMANIO, OBLIGATORIO);
                $aErrores["volumen"]=validacionFormularios::comprobarFloat($_REQUEST["volumen"], 10000, 0, OBLIGATORIO);
                    
                //Recorrer el array de errores para comprobar si hay algun error en el formulario
                foreach($aErrores as $nombreCampo=>$valor){
                    if($valor!=null){
                        $_REQUEST[$nombreCampo]="";//Si encuentra un error vacia el campo
                        $entradaOK=false;//Si se encuentra algun error se cambia la variable entradaOK a false
                    }
                }
                
            }else{
                //El formulario no se ha rellenado nunca
                $entradaOK=false;
            }
            
            
            //Comprobar si la entrada es correcta
            if($entradaOK){
                try{
                    //Almacenar las respuestas correctas en el array $aCorrecto
                    $aCorrecto=[
                        "descripcion"=>$_REQUEST["descripcion"],
                        "volumen"=>$_REQUEST["volumen"],
                    ];
                
                    //Conectar a la base de datos
                    $DAW2105DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                    //Configurar las excepciones
                    $DAW2105DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    //Query de la insercion
                    $consulta= <<<QUERY
                            INSERT INTO Departamento(DescDepartamento, VolumenNegocio) VALUES 
                            ('{$aCorrecto['descripcion']}', {$aCorrecto['volumen']});
                    QUERY;
                    
                    $oResultado=$DAW2105DBDepartamentos->exec($consulta);
                    
                    header("Location: ./MtoDepartamentos.php");
                }catch(PDOException $excepcion){
                    $errorExcepcion=$excepcion->getCode();
                    $mensajeExcepcion=$excepcion->getMessage();

                    //Mostrar el mensaje de la excepcion
                    echo '<p>Error: '.$mensajeExcepcion.'</p>';
                    //Mostrar el codigo de la excepcion
                    echo '<p>Codigo de error: '.$errorExcepcion.'</p>';
                }finally{
                    //Cerrar conexión
                    unset($DAW2105DBDepartamentos);
                }
                
            }else{
                //Mostrar el fomulario
        ?>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method='post'>
                <fieldset>
                    <legend>Modificar departamento:</legend>
                    
                    <label>Codigo departamento:</label>
                    <input type='text' name='codDep' disabled value="<?php
                        //Mostrar los datos correctos introducidos en un intento anterior
                        echo isset($_REQUEST["codDep"]) ? $_REQUEST["codDep"] : "";
                    ?>"/><br><br>
                    
                    <label>Descripción:</label>
                    <input type='text' name='descripcion' value="<?php
                        //Mostrar los datos correctos introducidos en un intento anterior
                        echo isset($_REQUEST["descripcion"]) ? $_REQUEST["descripcion"] : "";
                    ?>"/><p ><?php
                        //Mostrar los errores en la descripcion, si los hay
                        echo $aErrores["descripcion"]!=null ? $aErrores["descripcion"] : "";
                    ?></p>
                    
                    <label>Fecha de baja:</label>
                    <input type='text' disabled name='fecha' value="<?php
                        //Mostrar los datos correctos introducidos en un intento anterior
                        echo isset($_REQUEST["fecha"]) ? $_REQUEST["fecha"] : "";
                    ?>"/><br><br>
                    
                    <label>Volumen:</label>
                    <input type='text' name='volumen' value="<?php
                        //Mostrar los datos correctos introducidos en un intento anterior
                        echo isset($_REQUEST["volumen"]) ? $_REQUEST["volumen"] : "";
                    ?>"/><p><?php
                        //Mostrar los errores en el volumen, si los hay
                        echo $aErrores["volumen"]!=null ? $aErrores["volumen"] : "";
                    ?></p>
                    <br>
                    <input type='submit' name='aceptar' value='Aceptar'/>
                    <input type='submit' name='cancelar' value='Cancelar'/>
                </fieldset>
            </form>
        <?php    
            } 
        ?>
    </body>
</html>
