<?php

require_once '../libraries/fpdf/fpdf.php';
require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

if(isset($_POST['fechaInicial'],$_POST['fechaFinal']) && !empty($_POST['fechaInicial']) && !empty($_POST['fechaFinal']))
{

    $fechaInicial = $_POST['fechaInicial'].' 00:00:00';
    $fechaFinal = $_POST['fechaFinal'].' 23:59:59';

    $ventas = $conexion->prepare("SELECT DATE_FORMAT(ventas.fecha, '%Y-%m-%d') As fecha, ventas.total, ventas.idVenta, ventas.pedidos_idPedido FROM ventas 
    WHERE fecha BETWEEN ? AND ? ORDER BY fecha DESC");

    $ventas->execute([$fechaInicial, $fechaFinal]);

    $ventaGeneral = $ventas->fetchAll(PDO::FETCH_ASSOC);

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
            $this->Cell(0, 10, 'Balance General de Ventas', 0, 1, 'C');
            
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
            $this->Cell(20, 12, 'ID Venta', 1, 0, 'C', true);
            $this->Cell(40, 12, 'Fecha', 1, 0, 'C', true);
            $this->Cell(30, 12, 'ID Pedido', 1, 0, 'C', true);
            $this->Cell(40, 12, 'Total', 1, 1, 'C', true);
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
            $this->Cell(20, 10, $data['idVenta'], 1, 0, 'C', true);
            $this->Cell(40, 10, date('d/m/Y', strtotime($data['fecha'])), 1, 0, 'C', true);
            $this->Cell(30, 10, $data['pedidos_idPedido'], 1, 0, 'C', true);
            $this->Cell(40, 10, "$" . number_format($data['total'], 0, ',', '.'), 1, 1, 'R', true);
        }
    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();

    // Información del período
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(139, 69, 19);
    $pdf->Cell(0, 10, 'Periodo de Analisis', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0, 8, 'Desde: ' . date('d/m/Y', strtotime($_POST['fechaInicial'])), 0, 1);
    $pdf->Cell(0, 8, 'Hasta: ' . date('d/m/Y', strtotime($_POST['fechaFinal'])), 0, 1);

    $pdf->Ln(10);

    // Resumen de ventas
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(139, 69, 19);
    $pdf->Cell(0, 10, 'Resumen de Ventas', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0, 0, 0);

    $totalVentas = count($ventaGeneral);
    // se suma el valor total de todas las ventas realizadas en ese periodo de tiempo
    $total = $conexion->prepare("SELECT SUM(total) AS venta FROM ventas WHERE fecha BETWEEN ? AND ?");
    $total->execute([$fechaInicial, $fechaFinal]);
    $totalRecaudado = $total->fetch(PDO::FETCH_ASSOC);
    // se saca el promedio del valor total de las ventas
    $promedioVenta = $totalVentas > 0 ? $totalRecaudado['venta'] / $totalVentas : 0;

    $pdf->Cell(0, 8, 'Total de ventas: ' . $totalVentas, 0, 1);
    $pdf->Cell(0, 8, 'Total recaudado: $' . number_format($totalRecaudado['venta'], 0, ',', '.'), 0, 1);
    $pdf->Cell(0, 8, 'Promedio por venta: $' . number_format($promedioVenta, 0, ',', '.'), 0, 1);

    $pdf->Ln(10);

    // Tabla de ventas
    $pdf->TableHeader();

    if(!empty($ventaGeneral))
    {
        foreach ($ventaGeneral as $ventaGen) 
        {
            $pdf->TableRow($ventaGen);
        }
        
        $pdf->Ln(10);
        
        // Información adicional
        $pdf->SetFont('Arial', 'I', 9);
        $pdf->SetTextColor(128, 128, 128);
        $pdf->Cell(0, 8, 'Nota: Los montos estan en pesos colombianos (COP)', 0, 1, 'C');
        
        // Se puede visualizar en el navegador o descargar:
        // 'I' = Inline (mostrar), 'D' = Download
        $pdf->Output('I', 'Balance_General_Ventas_Cafe_El_Buen_Sabor.pdf');
    }
    else
    {
        echo "Sin Datos";
        header("refresh:3; url=../views/dashboard.php");
        $mysql->desconectar();
    }
}

$mysql->desconectar();

?>