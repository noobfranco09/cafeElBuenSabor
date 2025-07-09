<?php

require_once '../libraries/fpdf/fpdf.php';
require_once '../models/mySql.php';

$mysql = new MySQL();
$mysql->conectar();
$conexion = $mysql->obtenerConexion();

$inventario = $conexion->query("SELECT * FROM productos");

$estadoInventario = $inventario->fetchAll(PDO::FETCH_ASSOC);

class PDF extends FPDF
{
    function Header() 
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Estado de Inventario', 0, 1, 'C');
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
$pdf->Cell(30, 10, 'Nombre', 1);
$pdf->Cell(30, 10, 'Descripcion', 1);
$pdf->Cell(30, 10, 'Precio', 1);
$pdf->Cell(30, 10, 'Stock', 1);
$pdf->Cell(30, 10, 'idCategoria', 1);

$pdf->Ln();

$pdf->SetFont('Arial', '', 12);

if(!empty($estadoInventario))
{
    foreach ($estadoInventario as $estadoInv) 
    {
        $pdf->Cell(10, 10, $estadoInv['idProducto'], 1);
        $pdf->Cell(30, 10, $estadoInv['nombre'], 1);
        $pdf->Cell(30, 10, $estadoInv['descripcion'], 1);
        $pdf->Cell(30, 10, "$".number_format($estadoInv['precio'], 0, ',', '.'), 1);
        $pdf->Cell(30, 10, $estadoInv['stock'], 1);
        $pdf->Cell(30, 10, $estadoInv['idCategoria'], 1);
        $pdf->Ln();
    }
    
    // Se puede visualizar en el navegador o descargar:
    // 'I' = Inline (mostrar), 'D' = Download
    $pdf->Output('I', 'Estado_Inventario.pdf');
    // $pdf->Output('D', 'Listado_Empleados.pdf'); // ← para forzar descarga
}
else
{
    echo "Sin Datos";
    header("refresh:3; url=../views/dashboard.php");
}

$mysql->desconectar();

?>