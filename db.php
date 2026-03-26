<?php
// db.php
session_start();

// Credenciales formadas para Supabase PostgreSQL (Protegidas)
$host = getenv('SUPABASE_HOST') ?: 'db.dplwndtxnnuqphhvzhfn.supabase.co';
$port = '5432';
$dbname = getenv('SUPABASE_DB') ?: 'detecta';
$user = getenv('SUPABASE_USER') ?: 'postgres';
$password = getenv('SUPABASE_PASSWORD');

if (!$password) {
    die("Error: La contraseña de la base de datos no está configurada. Por favor, asegúrate de agregar SUPABASE_PASSWORD en las Variables de Entorno (Environment Variables) de Vercel.");
}

try {
    // String de conexión a PostgreSQL
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Omitimos la creación dinámica de tablas ya que tu tabla se creó manualmente 
    // a través del panel de Supabase Studio guiándonos por tu pantallazo.
} catch (PDOException $e) {
    die("Error Database: " . $e->getMessage() . " (Asegúrate de tener habilitada la extensión pdo_pgsql en PHP)");
}
?>
