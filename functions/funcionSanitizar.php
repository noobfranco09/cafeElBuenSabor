<?php
function verificarVariables(array $datos)
{
    $datosSanitizados = [];

    foreach ($datos as $clave => $variable) {
        if (isset($variable) && !empty($variable) ) {
            if (is_int($variable)) {
                $variable = filter_var($variable, FILTER_SANITIZE_NUMBER_INT);
            } elseif (is_float($variable)) {
                $variable = filter_var($variable, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            } elseif (is_string($variable)) {
                $variable = filter_var($variable, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }

            $datosSanitizados[$clave] = $variable;
        } else {
            return false; // si hay una variable vacía o no definida
        }
    }

    return $datosSanitizados;
};
function validarCorreo($correo)
{
    if(isset($correo) && !empty($correo))
    {
         $correo = filter_var($correo, FILTER_SANITIZE_EMAIL);
        if(filter_var($correo,FILTER_VALIDATE_EMAIL)!=false)
        {
            return $correo;
        }else
        {
            return false;
        }
    }

}
?>