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
    // Intento 1: Conectar con el nombre de base de datos brindado (con sslmode=require mandatorio en Supabase)
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    // Intento 2: Supabase nombra la BD como 'postgres' por defecto si 'detecta' no existe
    if (strpos($e->getMessage(), 'does not exist') !== false) {
        $dsnFallback = "pgsql:host=$host;port=$port;dbname=postgres;sslmode=require";
        $pdo = new PDO($dsnFallback, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } else {
        die("Error de Base de Datos: " . $e->getMessage());
    }
}
?>
