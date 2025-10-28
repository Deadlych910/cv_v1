<?php
session_start(); // Inicia la sesión para guardar el estado

// Comprueba si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. LIMPIAR Y VALIDAR DATOS
    // strip_tags() quita cualquier HTML malicioso
    // filter_var() limpia los datos
    
    $nombre = filter_var(strip_tags($_POST['nombre']), FILTER_SANITIZE_STRING);
    $correo = filter_var(strip_tags($_POST['correo']), FILTER_SANITIZE_EMAIL);
    $mensaje = filter_var(strip_tags($_POST['mensaje']), FILTER_SANITIZE_STRING);

    // Validar que los campos no estén vacíos y el email sea válido
    if (empty($nombre) || !filter_var($correo, FILTER_VALIDATE_EMAIL) || empty($mensaje)) {
        // Si algo falla, guarda un mensaje de error y redirige
        $_SESSION['form_status'] = 'error_validation';
        header('Location: index.php#contacto');
        exit;
    }

    // 2. CONFIGURAR EL CORREO
    $para = "Christopherv724@gmail.com"; // Tu correo
    $asunto = "Nuevo Mensaje del Portafolio de: $nombre";

    // 3. CONSTRUIR EL CUERPO DEL MENSAJE
    $cuerpo_mensaje = "Has recibido un nuevo mensaje de tu portafolio web.\n\n";
    $cuerpo_mensaje .= "Nombre: $nombre\n";
    $cuerpo_mensaje .= "Correo: $correo\n\n";
    $cuerpo_mensaje .= "Mensaje:\n$mensaje\n";

    // 4. CONFIGURAR LAS CABECERAS (HEADERS)
    // Esto es crucial para que tu correo no se marque como SPAM
    $headers = "From: $nombre <$correo>\r\n";
    $headers .= "Reply-To: $correo\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // 5. ENVIAR EL CORREO
    if (mail($para, $asunto, $cuerpo_mensaje, $headers)) {
        // Si se envía bien, guarda mensaje de éxito
        $_SESSION['form_status'] = 'success';
    } else {
        // Si falla el envío, guarda mensaje de error
        $_SESSION['form_status'] = 'error_send';
    }

    // 6. REDIRIGIR DE VUELTA AL FORMULARIO
    header('Location: index.php#contacto');
    exit;

} else {
    // Si alguien intenta acceder a este archivo directamente, lo saca
    header('Location: index.php');
    exit;
}
?>