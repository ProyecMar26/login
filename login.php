<?php
include 'conn.php';

// Leer los datos enviados desde el formulario
$username = isset($_POST['username']) ? $_POST['username'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;

if ($username && $password) {
    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el usuario
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verificar la contraseña
        if ($password === $user['password']) {
            echo "  ¡Entrado correctamente!";
        } else {
            echo "  Contraseña incorrecta";
        }
    } else {
        echo "  Usuario no encontrado";
    }

    $stmt->close();
} else {
    echo "  Datos de usuario y/o contraseña no recibidos correctamente";
}

$conn->close();
?>
