<?php
    function verificarVariables (array $datos) 
    {
        $datosSanitizados = [];
        foreach( $datos as $variable)
        {
            if(isset($variable) && !empty($variable) )
            {
                array_push($datosSanitizados, $variable);

            }
            else
            {
                return false;
            }
        }
        return $datosSanitizados;
    }

?>