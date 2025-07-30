<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH. 'libraries/fpdf/fpdf.php';
require_once BASE_PATH.'models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$inventario = $conexion->query("SELECT DATE_FORMAT(usuario.fechaIngreso, '%Y-%m-%d') As fecha, usuario.nombre As nombreUsuario, roles.nombre As nombreRol, COUNT(pedidos.idUsuario) As mesasAtentidas,
SUM(ventas.total) As valorGenerado FROM ventas 
JOIN pedidos ON pedidos.idPedido = ventas.pedidos_idPedido
JOIN usuario ON usuario.idUsuario = pedidos.idUsuario
JOIN roles  ON roles.idRoll = usuario.idRoll
JOIN mesas ON mesas.idMesa = pedidos.idMesa
JOIN productos_has_pedidos ON productos_has_pedidos.idPedido = pedidos.idPedido
JOIN productos ON productos.idProducto = productos_has_pedidos.idProducto WHERE usuario.estado = 'Activo' GROUP BY usuario.nombre");

$estadoInventario = $inventario->fetchAll(PDO::FETCH_ASSOC);

class PDF extends FPDF
{
    function Header() 
    {
        // Color de fondo para el encabezado
        $this->SetFillColor(139, 69, 19); // Marrón café
        $this->Rect(0, 0, 210, 40, 'F');
        
        // Logo de la empresa (☕)
        $this->SetFont('Arial', 'B', 36);
        $this->SetTextColor(255, 215, 0); // Dorado
        $this->Cell(30, 40, 'LOGO', 0, 0, 'C');
        
        // Título principal
        $this->SetFont('Arial', 'B', 24);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 15, 'CAFE EL BUEN SABOR', 0, 1, 'C');
        
        // Subtítulo
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Desempeno Por Empelado', 0, 1, 'C');
        
        // Línea decorativa
        $this->SetDrawColor(255, 215, 0); // Dorado
        $this->SetLineWidth(2);
        $this->Line(20, 35, 190, 35);
        
        // Información adicional
        $this->SetFont('Arial', 'I', 10);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 8, 'Fecha de generacion: ' . date('d/m/Y'), 0, 1, 'R');
        
        $this->Ln(10);
    }

    function Footer() 
    {
        $this->SetY(-20);
        $this->SetFillColor(139, 69, 19);
        $this->Rect(0, 277, 210, 20, 'F');
        
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 10, 'Cafe El Buen Sabor - Sistema de Gestion', 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }
    
    function TableHeader()
    {
        // Color de fondo para encabezados de tabla
        $this->SetFillColor(160, 82, 45); // Marrón sienna
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 11);
        
        // Calcular el ancho total de la tabla y centrarla
        $tableWidth = 30 + 40 + 35 + 35 + 35; // 175
        $pageWidth = 210; // A4 horizontal en mm
        $marginLeft = ($pageWidth - $tableWidth) / 2;
        $this->SetX($marginLeft);
        // Encabezados de tabla
        $this->Cell(30, 12, 'Fecha Ingreso', 1, 0, 'C', true);
        $this->Cell(40, 12, 'Nombre', 1, 0, 'C', true);
        $this->Cell(35, 12, 'Rol', 1, 0, 'C', true);
        $this->Cell(35, 12, 'Mesas Atendidas', 1, 0, 'C', true);
        $this->Cell(35, 12, 'Valor Generado', 1, 0, 'C', true);
        $this->Ln(12);
    }
    
    function TableRow($data)
    {
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);
        
        // Alternar colores de fila
        static $alternate = false;
        if ($alternate) {
            $this->SetFillColor(245, 245, 245);
        } else {
            $this->SetFillColor(255, 255, 255);
        }
        $alternate = !$alternate;
        
        // Calcular el ancho total de la tabla y centrarla
        $tableWidth = 30 + 40 + 35 + 35 + 35; // 175
        $pageWidth = 210; // A4 horizontal en mm
        $marginLeft = ($pageWidth - $tableWidth) / 2;
        $this->SetX($marginLeft);
        $this->Cell(30, 10, $data['fecha'], 1, 0, 'L', true);
        $this->Cell(40, 10, $data['nombreUsuario'], 1, 0, 'L', true);
        $this->Cell(35, 10, $data['nombreRol'], 1, 0, 'C', true);
        $this->Cell(35, 10, $data['mesasAtentidas'], 1, 0, 'C', true);
        $this->Cell(35, 10, "$" . number_format($data['valorGenerado'], 0, ',', '.'), 1, 0, 'R', true);
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Resumen del inventario
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(139, 69, 19);
$pdf->Cell(0, 10, 'Resumen de Desempeno', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0);

// contar los Empleados Activos 
$empleadosActivos = $conexion->query("SELECT COUNT(*) As usuariosActivos FROM usuario WHERE estado = 'Activo'");
$totalEmpleadosActivos = $empleadosActivos->fetch(PDO::FETCH_ASSOC);
// contar los Empleados Inactivo 
$empleadosInactivos = $conexion->query("SELECT COUNT(*) As usuariosInactivos FROM usuario WHERE estado = 'Inactivo'");
$totalEmpleadosInactivos = $empleadosInactivos->fetch(PDO::FETCH_ASSOC);

$pdf->Cell(0, 8, 'Total de Empleados Activos: ' . $totalEmpleadosActivos['usuariosActivos'], 0, 1);
$pdf->Cell(0, 8, 'Total de Empleados Inactivos: ' . $totalEmpleadosInactivos['usuariosInactivos'], 0, 1);

$pdf->Ln(10);

// Tabla de productos
$pdf->TableHeader();

if(!empty($estadoInventario))
{
    foreach ($estadoInventario as $estadoInv) 
    {
        $pdf->TableRow($estadoInv);
    }
    
    $pdf->Ln(10);
    
    // Información adicional
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->SetTextColor(128, 128, 128);
    $pdf->Cell(0, 8, 'Nota: Los precios estan en pesos colombianos (COP)', 0, 1, 'C');
    
    // Se puede visualizar en el navegador o descargar:
    // 'I' = Inline (mostrar), 'D' = Download
    $pdf->Output('I', 'Desempeno_De_Empleados_Cafe_El_Buen_Sabor.pdf');
}
else
{
    echo "Sin Datos";
    header("refresh:3; url=".BASE_URL."views/dashboard.php");
}

$mysql->desconectar();

?>