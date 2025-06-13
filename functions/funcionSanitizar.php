<?php


     function  sanitizarFormulario($arregloDeEntrada[])
{
    $arregloDeSalida=[];
    if(trim(isset($nombre)) && trim(isset($cedula)) && trim(isset($cargo)) && trim(isset($area)) 
        && trim(isset($salario)) && trim(isset($fechaIngreso)) && trim(isset($correo)) && trim(isset($telefono)) )
    {
        if (!empty($nombre) && !empty($cedula) && !empty($cargo) && !empty($area) && !empty($salario) 
        && !empty($fechaIngreso) && !empty($correo) && !empty($telefono)) 
        {
           $nombre=filter_var($nombre,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $cedula=filter_var($cedula,FILTER_SANITIZE_NUMBER_INT);
           $cargo=filter_var($cargo,FILTER_SANITIZE_NUMBER_INT);
           $area=filter_var($area,FILTER_SANITIZE_NUMBER_INT);
           $salario=filter_var($salario,FILTER_SANITIZE_NUMBER_FLOAT);
           $fechaIngreso=filter_var($fechaIngreso,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $correo=filter_var($correo,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $telefono=filter_var($telefono,FILTER_SANITIZE_NUMBER_INT);
           $arreglo=[$nombre,$cedula,$cargo,$area,$salario,$fechaIngreso,$correo,$telefono];
           return $arreglo;
        }
        else
            {
                return $arreglo;
            } 
    }
    else
        {
            return $arreglo;
        }
}






















 /* function  sanitizarFormulario($nombre,$cedula,$cargo,$area,$salario,$fechaIngreso,$correo,$telefono)
{
    $arreglo=[];
    if(trim(isset($nombre)) && trim(isset($cedula)) && trim(isset($cargo)) && trim(isset($area)) 
        && trim(isset($salario)) && trim(isset($fechaIngreso)) && trim(isset($correo)) && trim(isset($telefono)) )
    {
        if (!empty($nombre) && !empty($cedula) && !empty($cargo) && !empty($area) && !empty($salario) 
        && !empty($fechaIngreso) && !empty($correo) && !empty($telefono)) 
        {
           $nombre=filter_var($nombre,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $cedula=filter_var($cedula,FILTER_SANITIZE_NUMBER_INT);
           $cargo=filter_var($cargo,FILTER_SANITIZE_NUMBER_INT);
           $area=filter_var($area,FILTER_SANITIZE_NUMBER_INT);
           $salario=filter_var($salario,FILTER_SANITIZE_NUMBER_FLOAT);
           $fechaIngreso=filter_var($fechaIngreso,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $correo=filter_var($correo,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           $telefono=filter_var($telefono,FILTER_SANITIZE_NUMBER_INT);
           $arreglo=[$nombre,$cedula,$cargo,$area,$salario,$fechaIngreso,$correo,$telefono];
           return $arreglo;
        }
        else
            {
                return $arreglo;
            } 
    }
    else
        {
            return $arreglo;
        }
}
 */


?>