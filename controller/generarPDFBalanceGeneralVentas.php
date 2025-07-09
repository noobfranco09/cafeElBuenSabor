<?php

require_once '../libraries/fpdf/fpdf.php';
require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$ventas = $conexion->query("SELECT * FROM ventas");

$ventaGeneral = $ventas->fetchAll(PDO::FETCH_ASSOC);

class PDF extends FPDF
{
    function Header() 
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Balance General de Ventas', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() 
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(10, 10, 'ID', 1);
$pdf->Cell(30, 10, 'Fecha', 1);
$pdf->Cell(30, 10, 'idPedido', 1);
$pdf->Cell(30, 10, 'Total', 1);

$pdf->Ln();

$pdf->SetFont('Arial', '', 12);

if(!empty($ventaGeneral))
{
    foreach ($ventaGeneral as $ventaGen) 
    {
        $pdf->Cell(10, 10, $ventaGen['idVenta'], 1);
        $pdf->Cell(30, 10, $ventaGen['fecha'], 1);
        $pdf->Cell(30, 10, $ventaGen['pedidos_idPedido'], 1);
        $pdf->Cell(30, 10, "$".number_format($ventaGen['total'], 0, ',', '.'), 1);
        $pdf->Ln();
    }
    
    // Se puede visualizar en el navegador o descargar:
    // 'I' = Inline (mostrar), 'D' = Download
    $pdf->Output('I', 'Balance_General_Ventas.pdf');
    // $pdf->Output('D', 'Listado_Empleados.pdf'); // ← para forzar descarga
}
else
{
    echo "Sin Datos";
    header("refresh:3; url=../views/dashboard.php");
}

$mysql->desconectar();

?>