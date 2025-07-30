    <?php
    session_start();
    require_once $_SERVER["DOCUMENT_ROOT"] . '/cafeElBuenSabor/functions/rutas.php';

    if (!isset($_SESSION["id"])) {
        header("Location: " . BASE_URL . "views/login.php");
        exit();
    }
    if ($_SESSION["estado"] == "Inactivo") {
        header("Location: " . BASE_URL . "views/login.php");
        exit();
    }

    require_once BASE_PATH . 'models/mySql.php';

    $id = $_SESSION["id"] ?? "";
    $mysql = new MySQL();
    $mysql->conectar();

    $consulta = "SELECT usuario.idUsuario, usuario.nombre, usuario.fechaIngreso, usuario.telefono, usuario.correo, usuario.estado, roles.nombre AS nombreRol 
    FROM usuario JOIN roles ON roles.idRoll = usuario.idRoll 
    WHERE idUsuario = :id";

    $stmt = $mysql->obtenerConexion()->prepare($consulta);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    $nombre = $usuario["nombre"] ?? "Desconocido";
    $rol = $usuario["nombreRol"] ?? "Desconocido";
    $correo = $usuario["correo"] ?? "Desconocido";
    $telefono = $usuario["telefono"] ?? "Desconocido";
    $icono = str_split($usuario["nombre"]);

    $errores = $_SESSION["errores"] ?? [];
    $old = $_SESSION["old"] ?? [];
    unset($_SESSION["old"], $_SESSION["errores"]);
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/css/boostrap/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/bootstrap-icons/bootstrap-icons.css">
        <link rel="stylesheet" href="<?php echo BASE_URL ?>assets/css/dashboard.css">
        <title>Mi Perfil - CoffeeShop Pro</title>
    </head>
    <body>
        <div class="coffee-circle circle-1"></div>
        <div class="coffee-circle circle-2"></div>
        <div class="coffee-circle circle-3"></div>
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

        <?php include BASE_PATH . 'views/components/navbar.php'; ?>

        <?php 
            $activePage = 'perfil';
            include BASE_PATH . 'views/components/sidebar.php'; 
        ?>

        <?php include BASE_PATH . 'views/components/logoutModal.php'; ?>

        <div class="dashboard-layout">
            <main class="main-content">
                <div class="container min-vh-100 d-flex justify-content-center align-items-center">
                    <div class="card shadow perfil-form-card" style="max-width: 400px; width: 100%;">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <div class="perfil-avatar-pro mx-auto mb-2" style="width: 60px; height: 60px; background: #f1f1f1; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                    <?php echo htmlspecialchars($icono[0]) ?>
                                </div>
                                <h2 class="h5 mb-1">¡Hola, <?php echo htmlspecialchars($nombre) ?>!</h2>
                                <div class="text-muted mb-1">Rol: <?php echo htmlspecialchars($rol) ?></div>
                                <div class="small text-secondary">Administra tu información personal y mantén tu cuenta segura.</div>
                            </div>
                            <form action="<?php echo BASE_URL ?>controller/actualizarPerfil.php" method="POST">
                                <?php if (!empty($errores["datosVacios"])): ?>
                                    <p class="text-start text-danger"><?php echo $errores["datosVacios"]; ?></p>
                                <?php endif; ?>

                                <?php if (!empty($errores["errorPerfil"])): ?>
                                    <p class="text-start text-danger"><?php echo $errores["errorPerfil"]; ?></p>
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label for="nombre" class="form-label"><i class="bi bi-person me-2"></i>Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($nombre) ?>" autocomplete="off">
                                    <?php if (!empty($errores["errorNombre"])): ?>
                                        <p class="text-start text-danger"><?php echo $errores["errorNombre"]; ?></p>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="correo" class="form-label"><i class="bi bi-envelope me-2"></i>Correo</label>
                                    <input type="email" class="form-control" id="correo" name="correo" required value="<?php echo htmlspecialchars($correo) ?>" autocomplete="off">
                                    <?php if (!empty($errores["errorCorreo"])): ?>
                                        <p class="text-start text-danger"><?php echo $errores["errorCorreo"]; ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($errores["correoEnUso"])): ?>
                                        <p class="text-start text-danger"><?php echo $errores["correoEnUso"]; ?></p>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="telefono" class="form-label"><i class="bi bi-telephone me-2"></i>Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" required value="<?php echo htmlspecialchars($telefono) ?>" autocomplete="off">
                                    <?php if (!empty($errores["errorTelefono"])): ?>
                                        <p class="text-start text-danger"><?php echo $errores["errorTelefono"]; ?></p>
                                    <?php endif; ?>
                                </div>

                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="bi bi-save me-2"></i>Guardar Cambios
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <script src="<?php echo BASE_URL ?>assets/js/dashboard.js"></script>
        <script src="<?php echo BASE_URL ?>assets/js/boostrap/bootstrap.bundle.min.js"></script>
    </body>
    </html>
