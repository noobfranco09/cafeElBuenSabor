<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cafeelbuensabor/functions/rutas.php';
require_once BASE_PATH. 'libraries/fpdf/fpdf.php';
require_once BASE_PATH.'models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$inventario = $conexion->query("SELECT productos.*, categorias.nombre As categoria_nombre FROM productos
JOIN categorias ON categorias.idCategoria = productos.idCategoria ORDER BY productos.nombre");

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
        $this->Cell(0, 10, 'Estado de Inventario', 0, 1, 'C');
        
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
        
        // Margen izquierdo
        $this->SetX(20);
        // Encabezados de tabla
        $this->Cell(15, 12, 'ID', 1, 0, 'C', true);
        $this->Cell(40, 12, 'Producto', 1, 0, 'C', true);
        $this->Cell(55, 12, 'Descripcion', 1, 0, 'C', true);
        $this->Cell(25, 12, 'Precio', 1, 0, 'C', true);
        $this->Cell(20, 12, 'Stock', 1, 0, 'C', true);
        $this->Cell(30, 12, 'Categoria', 1, 1, 'C', true);
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
        
        // Margen izquierdo
        $this->SetX(20);
        $this->Cell(15, 10, $data['idProducto'], 1, 0, 'C', true);
        $this->Cell(40, 10, $data['nombre'], 1, 0, 'L', true);
        $this->Cell(55, 10, substr($data['descripcion'], 0, 30) . (strlen($data['descripcion']) > 30 ? '...' : ''), 1, 0, 'L', true);
        $this->Cell(25, 10, "$" . number_format($data['precio'], 0, ',', '.'), 1, 0, 'R', true);
        $this->Cell(20, 10, $data['stock'], 1, 0, 'C', true);
        $this->Cell(30, 10, $data['categoria_nombre'], 1, 1, 'L', true);
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Resumen del inventario
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(139, 69, 19);
$pdf->Cell(0, 10, 'Resumen del Inventario', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0);

// contar los prodcutos totales
$totalProductos = count($estadoInventario);
// sumar e lvalor total de los prodcutos
$total = $conexion->query("SELECT SUM(precio) As valorTotal FROM productos");
$totalValor = $total->fetch(PDO::FETCH_ASSOC);
// contar cuantos productos tienen el stock bajo
$bajoStock = $conexion->query("SELECT COUNT(*) As productosStockBajo FROM productos WHERE stock <= 5");
$productosBajoStock = $bajoStock->fetch(PDO::FETCH_ASSOC);

$pdf->Cell(0, 8, 'Total de productos: ' . $totalProductos, 0, 1);
$pdf->Cell(0, 8, 'Valor total del inventario: $' . number_format($totalValor['valorTotal'], 0, ',', '.'), 0, 1);
$pdf->Cell(0, 8, 'Productos con stock bajo (<= 5): ' . $productosBajoStock['productosStockBajo'], 0, 1);

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
    $pdf->Output('I', 'Estado_Inventario_Cafe_El_Buen_Sabor.pdf');
}
else
{
    echo "Sin Datos";
    header("refresh:3; url=".BASE_URL."views/dashboard.php");
}

$mysql->desconectar();

?>