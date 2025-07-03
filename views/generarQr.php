<?php
session_start();
if (!isset($_SESSION["id"])){
    header("Location: ./login.php");
    exit();
}
$nombre = $_SESSION["nombre"]??"Desconocido";
$rol = $_SESSION["rol"]??"Desconocido";
$icono = str_split($nombre)??"?";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/boostrap/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="/assets/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/qr.css"> 
    <title>Generar QR - CoffeeShop Pro</title>

</head>
<body>
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
    <?php include './components/navbar.php'; ?>
    <?php 
        $activePage = 'generarQr';
        include './components/sidebar.php'; 
    ?>
    <?php include './components/logoutModal.php'; ?>
    <div class="dashboard-layout">
        <main class="main-content d-flex align-items-center justify-content-center" style="min-height: 80vh;">
            <div class="qr-card">
                <div class="qr-card-header">
                    <div class="qr-avatar"><i class="bi bi-qr-code"></i></div>
                    <div class="qr-title">Generar Código QR</div>
                    <div class="qr-desc">Seleccione el elemento para el cual desea generar un código QR.</div>
                </div>
                <form method="post" action="../controller/crearQr.php">
                    <div class="mb-4">
                        <label for="selectElemento" class="form-label fw-semibold">Elemento</label>
                        <select class="form-select form-select-lg" id="selectElemento" name="elemento" required>
                            <!-- Opciones serán agregadas dinámicamente -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-lg btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-qr-code"></i> Generar QR
                    </button>
                </form>
            </div>
        </main>
    </div>
    <script src="../assets/js/dashboard.js"></script>
    <script src="../assets/js/boostrap/bootstrap.bundle.min.js"></script>
    
</body>
</html> 