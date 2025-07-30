<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/cafeelbuensabor/functions/rutas.php';
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: " . BASE_URL . "login.php");
    exit();
}
if ($_SESSION["estado"] == "Inactivo") {
    header("Location: " . BASE_URL . "login.php");
    exit();
}

$nombre = $_SESSION["nombre"] ?? "Desconocido";
$rol = $_SESSION["rol"] ?? "Desconocido";
$icono = str_split($nombre) ?? "?";

//Obtener las mesas
require_once BASE_PATH . 'models/mySql.php';
$mysql = new MySQL();
$mysql->conectar();
$consulta = "SELECT * FROM mesas WHERE estado != 'Inactiva'";
$stmtMesas = $mysql->obtenerConexion()->query($consulta);
$stmtMesas->execute();
$mysql->desconectar();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/boostrap/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/dashboard.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/bootstrap-icons/bootstrap-icons.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/qr.css" />
    <title>Generar QR - CoffeeShop Pro</title>
</head>
<body>
    <div class="coffee-circle circle-1"></div>
    <div class="coffee-circle circle-2"></div>
    <div class="coffee-circle circle-3"></div>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <?php include BASE_PATH . 'controller/admin/components/navbar.php'; ?>

    <?php 
        $activePage = 'generarQr';
        include BASE_PATH . 'controller/admin/components/sidebar.php'; 
    ?>

    <?php include BASE_PATH . 'controller/admin/components/logoutModal.php'; ?>

    <div class="dashboard-layout">
        <main class="main-content" style="min-height: 80vh;">
            <div class="container py-4">
                <div class="row g-4" id="mesasGrid">
                    <?php while ($mesa = $stmtMesas->fetch(PDO::FETCH_ASSOC)) : ?>

                        <?php if ($mesa["estado"] == 'Ocupada') : ?>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card shadow-sm h-100 text-center">
                                    <div class="card-body d-flex flex-column justify-content-between" id="<?= htmlspecialchars($mesa['idMesa']) ?>">
                                        <div>
                                            <div class="mb-2">
                                                <i class="bi bi-table" style="font-size:2rem;color:#8B4513;"></i>
                                            </div>
                                            <h5 class="card-title mb-1">Mesa <?= htmlspecialchars($mesa["numero"] . " " . $mesa['estado']) ?></h5>
                                        </div>
                                        <button class="btn btn-success w-100 mt-3 btnLiberarQr" data-id="<?= htmlspecialchars($mesa['idMesa']) ?>" data-numero="<?= htmlspecialchars($mesa['numero']) ?>">
                                            <i class="bi bi-caret-right"></i>Liberar    
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card shadow-sm h-100 text-center">
                                    <div class="card-body d-flex flex-column justify-content-between" id="<?= htmlspecialchars($mesa['idMesa']) ?>">
                                        <div>
                                            <div class="mb-2">
                                                <i class="bi bi-table" style="font-size:2rem;color:#8B4513;"></i>
                                            </div>
                                            <h5 class="card-title mb-1">Mesa <?= htmlspecialchars($mesa['numero']) ?></h5>
                                        </div>
                                        <button class="btn btn-warning w-100 mt-3 btnMostrarQr" data-id="<?= htmlspecialchars($mesa['idMesa']) ?>" data-numero="<?= htmlspecialchars($mesa['numero']) ?>">
                                            <i class="bi bi-qr-code"></i> Generar QR
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php endwhile; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL PARA MOSTRAR LOS QR -->
    <div class="modal" tabindex="-1" id="mdlVerQr">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">QR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="mdlBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>assets/js/boostrap/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= BASE_URL ?>assets/js/generarQr.js"></script>
</body>
</html>
