<?php
session_start();
if (!isset($_SESSION["id"])){
    header("Location: ./login.php");
    exit();
}
$nombre = $_SESSION["nombre"]??"Desconocido";
$rol = $_SESSION["rol"]??"Desconocido";
$icono = str_split($nombre)??"?";

//Obtener las mesas
require_once '../models/mySql.php';
$mysql = new MySQL();
$mysql->conectar();
$consulta = "SELECT * FROM mesas";
$stmtMesas = $mysql->obtenerConexion()->query($consulta);
$mysql->desconectar();


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
                    <div class="qr-desc">Seleccione la mesa para la cual desea generar un código QR.</div>
                </div>
                <form>
                    <div class="mb-4">
                        <label for="selectMesa" class="form-label fw-semibold">Mesa</label>
                        <select class="form-select form-select-lg" id="selectMesa" name="mesa" required>
                            <?php while($mesas = $stmtMesas->fetch(PDO::FETCH_ASSOC)): ?>
                                <option value="<?php echo $mesas["idMesa"] ?>"><?php echo $mesas["numero"] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" id="btnGenerarQr" class="btn btn-lg btn-primary w-100 d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-qr-code"></i> Generar QR
                    </button>
                </form>
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
      <div class="modal-body" id="mdlBody">
                                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>                        
    
    
    <script src="../assets/js/boostrap/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/generarQr.js"></script>
    
</body>
</html> 