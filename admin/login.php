<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mensaje = "";

if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
    header("Location: inscritos.php");
    exit();
}

$usuario_correcto = "Admin";
$hash_correcto = '$2y$12$WrwtJP6N4qwFOUa3YSyCEOGCfUOCeUSTsOX3sTO.nn/i3ABUgtuK2';

if (!isset($_SESSION['intentos'])) {
    $_SESSION['intentos'] = 0;
    $_SESSION['primer_intento'] = time();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_SESSION['intentos'] >= 5 && (time() - $_SESSION['primer_intento']) < 900) {
        $mensaje = "Demasiados intentos. Espera 15 minutos.";
    } else {
        $usuario = trim($_POST["usuario"] ?? '');
        $clave = trim($_POST["clave"] ?? '');

        if ($usuario === $usuario_correcto && password_verify($clave, $hash_correcto)) {
            session_regenerate_id(true);
            $_SESSION["admin"] = true;
            $_SESSION["ip"] = $_SERVER["REMOTE_ADDR"];
            $_SESSION["ultimo_acceso"] = time();
            $_SESSION['intentos'] = 0;
            header("Location: inscritos.php");
            exit();
        } else {
            $_SESSION['intentos']++;
            $mensaje = "Usuario o contraseña incorrectos";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #3E0A75, #641cad);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 18px;
            overflow: hidden;
        }
        .login-header {
            background: #0d6efd;
            color: white;
            padding: 25px;
            text-align: center;
        }
        .login-header h3 {
            margin: 0;
            font-weight: bold;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
        }
        .btn-login {
            border-radius: 10px;
            padding: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="card shadow-lg login-card">
        <div class="login-header">
            <h3>🔐 Panel Administrativo</h3>
        </div>
        <div class="card-body p-4">
            <?php if (!empty($mensaje)): ?>
                <div class="alert alert-danger text-center">
                    <?= htmlspecialchars($mensaje) ?>
                </div>
            <?php endif; ?>
            <form method="POST" autocomplete="off">
                <div class="mb-3">
                    <label class="form-label fw-bold">Usuario</label>
                    <input
                        type="text"
                        name="usuario"
                        class="form-control"
                        placeholder="Ingrese usuario"
                        required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Contraseña</label>
                    <input
                        type="password"
                        name="clave"
                        class="form-control"
                        placeholder="Ingrese contraseña"
                        required>
                </div>
                <button type="submit" class="btn btn-primary w-100 btn-login">
                    Ingresar
                </button>
            </form>
        </div>
    </div>
</body>
</html>