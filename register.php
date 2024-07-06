<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Verificar si el nombre de usuario ya existe
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "  El nombre de usuario ya existe. Por favor elige otro.";
    } else {
        // Insertar nuevo usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO usuarios (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $email);
        if ($stmt->execute()) {
            echo "  Usuario registrado correctamente.";
        } else {
            echo "  Error al registrar el usuario: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>
