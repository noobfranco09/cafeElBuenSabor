<?php

class Validaciones{
    

    private array $datos;

    public function __construct($datos){
        $this->datos=$datos;

    }


    public function validarDatos(){
        require_once '../../models/mySql.php';

        $mysql = new MySQL();

        
        $errores = [];
        if(empty(trim($this->datos["correo"]??""))||
        empty(trim($this->datos["contraseña"]??""))){
            $errores["datosVacio"]="Enviaste datos vacios";
            return $errores;
        }


        $correo = $this->datos["correo"];
        $contraseña=$this->datos["contraseña"];


        if(!preg_match('/^[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',$correo) || !filter_var($correo,FILTER_VALIDATE_EMAIL)){
             $errores['errorCorreo']= 'El correo ingresado es invalido';

             return $errores;
        }

        $mysql->conectar();



        $consulta = "SELECT * FROM  usuario WHERE correo = :correo";

        $stmt = $mysql->obtenerConexion()->prepare($consulta);
        $stmt->bindParam(':correo',$correo,PDO::PARAM_STR);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $cantidadFilas = $stmt->rowCount();


        if($cantidadFilas==0){
            $errores["correoNoExiste"]="Este correo no existe";
            return $errores;
        }

       
        if($resultado["contraseña"]!=$contraseña){
            $errores["contraseñaIncorrecta"]="La contraseña es incorrecta";
            return $errores;

        }
        
        $mysql->desconectar();
        return $errores;
        
        
    }

    public function vldCrearEmpleado(){
        $errores = [];


        if(empty(trim($this->datos["nombre"]??""))||
        empty(trim($this->datos["fecha"]??""))||
        empty(trim($this->datos["telefono"]??""))||
        empty(trim($this->datos["correo"]??""))||
        empty(trim($this->datos["rol"]??""))||
        empty(trim($this->datos["contraseña"]??""))){
            $errores["datosVacios"]="Enviaste datos vacios";
            return $errores;
        }


        $nombre = $this->datos["nombre"];
        $fecha = $this->datos["fecha"];
        $telefono = $this->datos["telefono"];
        $correo = $this->datos["correo"];
        $rol = $this->datos["rol"];
        $contraseña = $this->datos["contraseña"];


        if(!preg_match('/^[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',$correo) ||
        - !filter_var($correo,FILTER_VALIDATE_EMAIL)){
            $errores["errorCorreo"]="Este correo no es valido";
            return $errores;
        }

        if(!preg_match('/^[a-zA-Z0-9_]+$/',$nombre)){
            $errores["errorNombre"] = "Este nombre no es valido";
            return $errores;
        }

        if(!preg_match('/^[0-9\/-]+$/',$fecha)){
            $errores["errorFecha"] = "La fecha es invalida";
            return $errores;
        }

        if(!preg_match('/^[0-9]+$/',$telefono)){
            $errores["errorTelefono"]="Este telefono no es valido";
            return $errores;
        }
        if(!preg_match('/^[0-9]+$/',$rol)){
            $errores["errorRol"]="Este rol no es valido";
            return $errores;
        }



        require_once '../models/mySql.php';

        $mysql = new MySQL();

        $mysql->conectar();
        $consulta = "SELECT correo FROM  usuario WHERE correo = :correo";

        $stmt = $mysql->obtenerConexion()->prepare($consulta);
        $stmt->bindParam(":correo", $correo,PDO::PARAM_STR);
        $stmt->execute();
        $cntFilas = $stmt->rowCount();

        if($cntFilas > 0){
          $errores["correoEnUso"]="Este correo ya esta en uso";
          return $errores;
        }
    
        return $errores;
    }

    public function vldEditarEmpleado(){
        $errores = [];


        if(empty(trim($this->datos["nombre"]??""))||
        empty(trim($this->datos["fecha"]??""))||
        empty(trim($this->datos["telefono"]??""))||
        empty(trim($this->datos["correo"]??""))||
        empty(trim($this->datos["rol"]??""))||
        empty(trim($this->datos["estado"]??""))||
        empty(trim($this->datos["contraseña"]??""))){
            $errores["datosVacios"]="Enviaste datos vacios";
            return $errores;
        }


        $nombre = $this->datos["nombre"];
        $fecha = $this->datos["fecha"];
        $telefono = $this->datos["telefono"];
        $correo = $this->datos["correo"];
        $rol = $this->datos["rol"];
        $contraseña = $this->datos["contraseña"];
        $id = $this->datos["id"];


        if(!preg_match('/^[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',$correo) ||
         !filter_var($correo,FILTER_VALIDATE_EMAIL)){
            $errores["errorCorreo"]="Este correo no es valido";
            return $errores;
        }

        if(!preg_match('/^[a-zA-Z0-9_]+$/',$nombre)){
            $errores["errorNombre"] = "Este nombre no es valido";
            return $errores;
        }

        if(!preg_match('/^[0-9\/-]+$/',$fecha)){
            $errores["errorFecha"] = "La fecha es invalida";
            return $errores;
        }

        if(!preg_match('/^[0-9]+$/',$telefono)){
            $errores["errorTelefono"]="Este telefono no es valido";
            return $errores;
        }
        if(!preg_match('/^[0-9]+$/',$rol)){
            $errores["errorRol"]="Este rol no es valido";
            return $errores;
        }



        require_once '../models/mySql.php';

        $mysql = new MySQL();

        $mysql->conectar();
        $consulta = "SELECT * FROM  usuario WHERE correo = :correo";

        $stmt = $mysql->obtenerConexion()->prepare($consulta);
        $stmt->bindParam(":correo", $correo,PDO::PARAM_STR);
        $stmt->execute();
        $cntFilas = $stmt->rowCount();
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        

        if($cntFilas > 0 && $datos["idUsuario"]!=$id){
          $errores["correoEnUso"]="Este correo ya esta en uso";
          return $errores;
        }
    
        return  $errores;
    }
    
    public function validarProducto(){

        require_once '../models/mySql.php';

        $mysql = new MySQL();
        $mysql->conectar();

        $errores = [];

        if(empty(trim($this->datos["nombre"])) && empty(trim($this->datos["precio"])) && empty(trim($this->datos["stock"])) && empty(trim($this->datos["categoria"]))
        && empty(trim($this->datos["estado"])) && empty(trim($this->datos["descripcion"])) )
        {
            $errores["datosVacio"]="Enviaste datos vacios";
            return $errores;
        }

        $nombre = $this->datos["nombre"];
        $precio = $this->datos["precio"];
        $stock = $this->datos["stock"];
        $categoria = $this->datos["categoria"];
        $estado = $this->datos["estado"];
        $descripcion = $this->datos["descripcion"];

        // Validar nombre (solo letras, espacios y acentos, longitud entre 2 y 100)
        if (!preg_match("/^[\p{L}\s]{2,100}$/u",$nombre)) {
            $errores["nombreInvalido"] = "El nombre no es válido.";
            return $errores;
        }

        // Validar precio (número decimal positivo con hasta 2 decimales)
        if (!preg_match("/^\d+(\.\d{1,2})?$/", $precio)) {
            $errores["precioInvalido"] = "El precio no es válido.";
            return $errores;
        }

        // Validar stock (solo números enteros positivos)
        if (!preg_match("/^\d+$/", $stock)) {
            $errores["stockInvalido"] = "El stock debe ser un número entero positivo.";
            return $errores;
        }

        // Validar categoría (ID numérico entero positivo - llave foránea)
        if (!preg_match("/^\d+$/", $categoria)) {
            $errores["categoriaInvalida"] = "La categoría no es válida.";
            return $errores;
        }

        // Validar estado (por ejemplo, solo "activo" o "inactivo")
        if (!preg_match("/^(Activo|Inactivo)$/i", $estado)) {
            $errores["estadoInvalido"] = "El estado debe ser 'activo' o 'inactivo'.";
            return $errores;
        }

        // Validar descripción (texto libre, longitud opcionalmente limitada)
        if (!preg_match("/^.{0,500}$/s", $descripcion)) {
            $errores["descripcionInvalida"] = "La descripción no es valida";
            return $errores;
        }

    }

    public function validarRolAgregar()
    {

        require_once '../models/mySql.php';

        $mysql = new MySQL();
        $mysql->conectar();

        $errores = [];

        if(empty(trim($this->datos["nombreRol"])) && empty(trim($this->datos["descripcionRol"])))
        {
            $errores["datosVacio"]="Enviaste datos vacios";
            return $errores;
        }

        $nombreRol = $this->datos["nombreRol"];
        $descripcionRol = $this->datos["nombreRol"];

        // Validar nombreRol (solo letras, mayús/minús y espacios, mínimo 3 letras, máx 50)
        if (!preg_match("/^[a-zA-ZÁÉÍÓÚÑáéíóúñ\s]{3,50}$/u", $nombreRol)) {
            $errores["nombreInvalido"] = "El nombre no es válido.";
            return $errores;
        }

        // Validar descripcionRol (permite letras, números, signos básicos, sin < > ni comillas peligrosas)
        if (!preg_match("/^[^<>\"']{5,200}$/u", $descripcionRol)) {
            $errores["descripcionInvalida"] = "La descripción no es valida";
            return $errores;
        }
        
    }

    public function validarRolEditar()
    {

        require_once '../models/mySql.php';

        $mysql = new MySQL();
        $mysql->conectar();

        $errores = [];

        if(empty(trim($this->datos["nombreRolEditar"])) && empty(trim($this->datos["descripcionRolEditar"])))
        {
            $errores["datosVacio"]="Enviaste datos vacios";
            return $errores;
        }

        $nombreRolEditar = $this->datos["nombreRolEditar"];
        $descripcionRolEditar = $this->datos["nombreRolEditar"];

        // Validar nombreRol (solo letras, mayús/minús y espacios, mínimo 3 letras, máx 50)
        if (!preg_match("/^[a-zA-ZÁÉÍÓÚÑáéíóúñ\s]{3,50}$/u", $nombreRolEditar)) {
            $errores["nombreInvalido"] = "El nombre no es válido.";
            return $errores;
        }

        // Validar descripcionRol (permite letras, números, signos básicos, sin < > ni comillas peligrosas)
        if (!preg_match("/^[^<>\"']{5,200}$/u", $descripcionRolEditar)) {
            $errores["descripcionInvalida"] = "La descripción no es valida";
            return $errores;
        }

    }

    public function validarMesaAgregar()
    {

        require_once '../models/mySql.php';

        $mysql = new MySQL();
        $mysql->conectar();

        $errores = [];

        if(empty(trim($this->datos["numeroMesa"])) && empty(trim($this->datos["estadoMesa"])))
        {
            $errores["datosVacio"]="Enviaste datos vacios";
            return $errores;
        }

        $numeroMesa = $this->datos["numeroMesa"];
        $estadoMesa = $this->datos["estadoMesa"];

        // Validar numeroMesa (solo números enteros positivos mayores que 0)
        if (!preg_match("/^[1-9][0-9]*$/", $numeroMesa)) {
            $errores["numeroMesaInvalido"] = "El número de mesa no es válido";
            return $errores;
        }

        // Validar estadoMesa (solo 'Activa' o 'Inactiva', sin < > ni comillas)
        if (!preg_match("/^(Activa|Inactiva)$/i", $estadoMesa)) {
            $errores["estadoMesaInvalido"] = "El estado de la mesa no es válido";
            return $errores;
        }

    }

    public function validarMesaEditar()
    {

        require_once '../models/mySql.php';

        $mysql = new MySQL();
        $mysql->conectar();

        $errores = [];

        if(empty(trim($this->datos["numeroMesaEditar"])) && empty(trim($this->datos["estadoMesaEditar"])))
        {
            $errores["datosVacio"]="Enviaste datos vacios";
            return $errores;
        }

        $numeroMesaEditar = $this->datos["numeroMesaEditar"];
        $estadoMesaEditar = $this->datos["estadoMesaEditar"];

        // Validar numeroMesa (solo números enteros positivos mayores que 0)
        if (!preg_match("/^[1-9][0-9]*$/", $numeroMesaEditar)) {
            $errores["numeroMesaInvalido"] = "El número de mesa no es válido";
            return $errores;
        }

        // Validar estadoMesa (solo 'Activa' o 'Inactiva', sin < > ni comillas)
        if (!preg_match("/^(Activa|Inactiva)$/i", $estadoMesaEditar)) {
            $errores["estadoMesaInvalido"] = "El estado de la mesa no es válido";
            return $errores;
        }

    }


    public function vldActualizarPerfil(){
        $errores = [];


        if(empty(trim($this->datos["nombre"]??""))||
        empty(trim($this->datos["telefono"]??""))||
        empty(trim($this->datos["correo"]??""))){
            $errores["datosVacios"]="Enviaste datos vacios";
            return $errores;
        }

        session_start();
        $nombre = $this->datos["nombre"];
        $telefono = $this->datos["telefono"];
        $correo = $this->datos["correo"];
        $id = $_SESSION["id"];
        


        if(!preg_match('/^[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',$correo) ||
         !filter_var($correo,FILTER_VALIDATE_EMAIL)){
            $errores["errorCorreo"]="Este correo no es valido";
            return $errores;
        }

        if(!preg_match('/^[a-zA-Z0-9_]+$/',$nombre)){
            $errores["errorNombre"] = "Este nombre no es valido";
            return $errores;
        }


        if(!preg_match('/^[0-9]+$/',$telefono)){
            $errores["errorTelefono"]="Este telefono no es valido";
            return $errores;
        }
       



        require_once '../models/mySql.php';

        $mysql = new MySQL();

        $mysql->conectar();
        $consulta = "SELECT * FROM  usuario WHERE correo = :correo";

        $stmt = $mysql->obtenerConexion()->prepare($consulta);
        $stmt->bindParam(":correo", $correo,PDO::PARAM_STR);
        $stmt->execute();
        $cntFilas = $stmt->rowCount();
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        

        if($cntFilas > 0 && $datos["idUsuario"]!=$id){
          $errores["correoEnUso"]="Este correo ya esta en uso";
          return $errores;
        }
    
        return  $errores;
    }

    public function validarCategoriaAgregar()
    {

        require_once '../models/mySql.php';

        $mysql = new MySQL();
        $mysql->conectar();

        $errores = [];

        if(empty(trim($this->datos["nombreCategoria"])) && empty(trim($this->datos["descripcionCategoria"])))
        {
            $errores["datosVacio"]="Enviaste datos vacios";
            return $errores;
        }

        $nombreCategoria = $this->datos["nombreCategoria"];
        $descripcionCategoria = $this->datos["descripcionCategoria"];

        // Validar nombreCategoria (letras, números, espacios, guiones, paréntesis, etc.)
        if (!preg_match("/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ\-\.\,\(\)\&]{2,100}$/", $nombreCategoria)) {
            $errores["nombreCategoriaInvalido"] = "El nombre de la categoría no es válido";
            return $errores;
        }

        // Validar descripcionCategoria (permite más longitud)
        if (!preg_match("/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ\-\.\,\(\)\&]{5,255}$/", $descripcionCategoria)) {
            $errores["descripcionCategoriaInvalida"] = "La descripción de la categoría no es válida";
            return $errores;
        }

    }

    public function validarCategoriaEditar()
    {

        require_once '../models/mySql.php';

        $mysql = new MySQL();
        $mysql->conectar();

        $errores = [];

        if(empty(trim($this->datos["nombreCategoriaEditar"])) && empty(trim($this->datos["descripcionCategoriaEditar"])))
        {
            $errores["datosVacio"]="Enviaste datos vacios";
            return $errores;
        }

        $nombreCategoriaEditar = $this->datos["nombreCategoriaEditar"];
        $descripcionCategoriaEditar = $this->datos["descripcionCategoriaEditar"];
        $estadoCategoriaEditar = $this->datos["estadoCategoriaEditar"];

        // Validar nombreCategoria (letras, números, espacios, guiones, paréntesis, etc.)
        if (!preg_match("/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ\-\.\,\(\)\&]{2,100}$/", $nombreCategoriaEditar)) {
            $errores["nombreCategoriaInvalido"] = "El nombre de la categoría no es válido";
            return $errores;
        }

        // Validar descripcionCategoria (permite más longitud)
        if (!preg_match("/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ\-\.\,\(\)\&]{5,255}$/", $descripcionCategoriaEditar)) {
            $errores["descripcionCategoriaInvalida"] = "La descripción de la categoría no es válida";
            return $errores;
        }

        // Validar estadoCategoria (solo 'Activa' o 'Inactiva', sin comillas ni símbolos)
        if (!preg_match("/^(Activa|Inactiva)$/i", $estadoCategoriaEditar)) {
            $errores["estadoCategoriaInvalido"] = "El estado de la categoría no es válido";
            return $errores;
        }

    }


}

?>