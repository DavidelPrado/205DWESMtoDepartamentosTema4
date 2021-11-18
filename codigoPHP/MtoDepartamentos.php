<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../webroot/css/estilo.css">
        <title>MtoDepartamentos</title>
    </head>
    <body>
        <h1><a href="../../proyectoTema4/indexProyectoTema4.php"><=</a>MANTENIMIENTO DEPARTAMENTOS</h1>
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
            ];
            
            //Definir array para almacenar respuestas correctas
            $aCorrecto=[
                "descripcion"=>null,
            ];
            
            $entradaOK=true;//Inicializar variable que controlara si los campos estan correctos
            
            //Comprobar si se ha pulsado el boton de enviar
            if(isset($_REQUEST['enviar'])){
                //Comprobar si los campos son correctos
                $aErrores["descripcion"]=validacionFormularios::comprobarAlfaNumerico($_REQUEST["descripcion"], 255, MIN_TAMANIO, OPCIONAL); 
                
                //Recorrer el array de errores para comprobar si hay algun error en el formulario
                foreach($aErrores as $nombreCampo=>$valor){
                    if($valor!=null){
                        $_REQUEST[$nombreCampo]="";//Si encuentra un error vacia el campo
                        $entradaOK=false;//Si se encuentra algun error se cambia la variable entradaOK a false
                    }
                }
            }else{
                $entradaOK=false;//El formulario no se ha rellenado nunca
            }
            
            //Mostrar el fomulario
            ?>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method='post'>
                    <fieldset>
                        <fieldset>
                            <label>Descripción:</label>
                            <input type='text' name='descripcion'  value="<?php
                                //Mostrar los datos correctos introducidos en un intento anterior
                                echo isset($_REQUEST["descripcion"]) ? $_REQUEST["descripcion"] : "";
                            ?>"/><?php
                                //Mostrar los errores en la descripcion, si los hay
                                echo $aErrores["descripcion"]!=null ? $aErrores["descripcion"] : "";
                            ?>
                            <input type='submit' name='enviar' value='Enviar'/>
                        </fieldset>
            <?php
        
            //Comprobar si la entrada es correcta
            if($entradaOK){
                try{
                    //Almacenar las respuestas correctas en el array $aCorrecto
                    $aCorrecto=[
                        "descripcion"=>$_REQUEST["descripcion"],
                    ];
                
                    $DAW2105DBDepartamentos = new PDO(HOST, USER, PASSWORD);//Conectar a la base de datos
                    $DAW2105DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Configurar las excepciones
                    
                    $consulta="SELECT * FROM Departamento WHERE DescDepartamento LIKE'%{$_REQUEST['descripcion']}%';";
                    $oResultado=$DAW2105DBDepartamentos->prepare($consulta);
                    $oResultado->execute();
                        
                    if($oResultado->rowCount()>0){
                        $oDepartamento=$oResultado->fetchObject();
                        
                        ?>
                    <table>
                        <tr>
                            <th>CodDepartamento</th>
                            <th>DescDepartamento</th>
                            <th>FechaBaja</th>
                            <th>VolumenNegocio</th>
                        </tr>
                    <?php
                    while($oDepartamento){
                        echo '<tr>';
                        foreach ($oDepartamento as $valor) {
                            echo "<td>$valor</td>";
                        }
                        ?>
                            <td><a href="./MtoDepartamentosModificar.php"><img src="../img/lapiz.png"></img></a></td>
                            <td><a><img src="../img/papelera.png" heigth="30px"></img></a></td>
                            <td><a><img src="../img/ojo.png" width="30px"></img></a></td>
                        <?php
                        echo '</tr>';
                        $oDepartamento=$oResultado->fetchObject();
                    }
                    ?>
                    </table>
                    <?php
                    }
                    
                }catch(PDOException $excepcion){
                    $errorExcepcion=$excepcion->getCode();
                    $mensajeExcepcion=$excepcion->getMessage();

                    echo '<p>Error: '.$mensajeExcepcion.'</p>';//Mostrar el mensaje de la excepcion
                    echo '<p>Codigo de error: '.$errorExcepcion.'</p>';//Mostrar el codigo de la excepcion
                }finally{
                    unset($DAW2105DBDepartamentos);//Cerrar conexión
                }
            }
        ?>
                </fieldset>
            </form>
        
        <footer>
            <table>
                <tr>
                    <td><p>David del Prado Losada - DAW2</p></td>
                    <td><a href="https://github.com/DavidelPrado" target="_blank"><img src="../../img/git.png" width="50px" height="50px"></img></a></td>
                </tr>
            </table>
        </footer>
    </body>
</html>
