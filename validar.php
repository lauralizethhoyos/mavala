<!DOCTYPE html>
</html>

<?php
// Conectar a la base de datos (Asegúrate de usar tus propias credenciales de conexión)

include('conexion.php');
$conexion = new mysqli ($server,$user,$contra,$db);


// Recibir los datos del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Buscar el usuario en la base de datos
    $sql = "SELECT id, password_hash FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Usuario encontrado, verificar la contraseña
        $row = $result->fetch_assoc();
        $password_hash = $row["password_hash"];
        if (password_verify($password, $password_hash)) {
            // Contraseña válida, inicia sesión
            session_start();
            $_SESSION["user_id"] = $row["id"];
            header("Location: bienvenida.php");
            exit();
        }
    }

    // Los datos son inválidos, redireccionar de nuevo al formulario de inicio de sesión
    header("Location: index.html");
    exit();
}

$conexion->close();
?>








