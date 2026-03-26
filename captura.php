<?php
require 'db.php';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO registros (nombre, paterno, materno, calle, numero, colonia, telefono, mail, seccion, dl) 
        VALUES (:nombre, :paterno, :materno, :calle, :numero, :colonia, :telefono, :mail, :seccion, :dl)");
    
    $stmt->execute([
        ':nombre' => htmlspecialchars($_POST['nombre'] ?? ''),
        ':paterno' => htmlspecialchars($_POST['paterno'] ?? ''),
        ':materno' => htmlspecialchars($_POST['materno'] ?? ''),
        ':calle' => htmlspecialchars($_POST['calle'] ?? ''),
        ':numero' => (int)($_POST['numero'] ?? 0),
        ':colonia' => htmlspecialchars($_POST['colonia'] ?? ''),
        ':telefono' => htmlspecialchars($_POST['telefono'] ?? ''),
        ':mail' => htmlspecialchars($_POST['mail'] ?? ''),
        ':seccion' => (int)($_POST['seccion'] ?? 0),
        ':dl' => (int)($_POST['dl'] ?? 0)
    ]);
    $last_id = $pdo->lastInsertId();
    $mensaje = "Simpatizante guardado exitosamente. Folio: #PAN-88" . str_pad($last_id, 3, "0", STR_PAD_LEFT);
}

// Folio sugerido
$stmt = $pdo->query("SELECT COALESCE(MAX(id), 0) FROM registros");
$max_id = $stmt->fetchColumn();
$new_id = intval($max_id) + 1;
$display_folio = "#" . str_pad(82931000 + $new_id, 9, "0", STR_PAD_LEFT);
?>
<!DOCTYPE html>
<html class="light" lang="es"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
<meta name="theme-color" content="#faf8ff" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" />
<title>PAN Registro - Captura de Simpatizante</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
tailwind.config = { darkMode: "class", theme: { extend: { colors: { "on-tertiary": "#ffffff", "surface-bright": "#faf8ff", "error-container": "#ffdad6", "on-secondary-container": "#465581", "on-background": "#191b22", "primary-container": "#0047bb", "tertiary-container": "#932d00", "on-surface-variant": "#434653", "tertiary-fixed": "#ffdbcf", "surface-container-lowest": "#ffffff", "on-primary-container": "#afc1ff", "tertiary": "#6c1f00", "on-primary": "#ffffff", "tertiary-fixed-dim": "#ffb59c", "surface-container-high": "#e7e7f1", "on-secondary-fixed": "#071942", "background": "#faf8ff", "secondary": "#4e5d8a", "primary-fixed-dim": "#b3c5ff", "primary": "#00328a", "surface-container": "#ededf7", "outline": "#737685", "on-error": "#ffffff", "secondary-container": "#bccbfe", "inverse-primary": "#b3c5ff", "inverse-surface": "#2e3038", "on-tertiary-container": "#ffb096", "secondary-fixed": "#dbe1ff", "on-tertiary-fixed-variant": "#832700", "secondary-fixed-dim": "#b6c5f8", "inverse-on-surface": "#f0f0fa", "surface-tint": "#2156ca", "error": "#ba1a1a", "surface-variant": "#e2e2ec", "surface": "#faf8ff", "on-secondary-fixed-variant": "#364570", "surface-container-low": "#f3f3fd", "surface-dim": "#d9d9e3", "on-surface": "#191b22", "outline-variant": "#c3c6d6", "surface-container-highest": "#e2e2ec", "primary-fixed": "#dbe1ff", "on-tertiary-fixed": "#390c00", "on-primary-fixed-variant": "#003ea6", "on-secondary": "#ffffff", "on-primary-fixed": "#00174a", "on-error-container": "#93000a" }, fontFamily: { "headline": ["Manrope"], "body": ["Inter"], "label": ["Inter"] }, borderRadius: {"DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem"}, }, }, }
</script>
<style>
.material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
.form-input-focus:focus-within { background-color: #ffffff !important; border-bottom: 2px solid #00328a; }
body { min-height: max(884px, 100dvh); touch-action: manipulation; -webkit-tap-highlight-color: transparent; }
</style>
</head>
<body class="bg-surface font-body text-on-surface antialiased">
<header class="fixed top-0 w-full z-50 px-4 bg-[#faf8ff] dark:bg-slate-950 flex justify-between items-center h-16 w-full px-6 shadow-none">
  <div class="flex items-center gap-4">
    <button class="text-[#00328a] dark:text-blue-400 hover:bg-[#e2e2ec] dark:hover:bg-slate-800 transition-colors active:scale-95 duration-200 p-2 rounded-full">
      <span class="material-symbols-outlined">menu</span>
    </button>
    <h1 class="font-manrope font-extrabold text-[#00328a] dark:text-blue-500 tracking-tight text-xl">PAN Registro</h1>
  </div>
  <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center overflow-hidden border border-outline-variant/15">
    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBtd_fcQatPOxoqxZGYA453XXOcDUg5xc3tVQ6Ry0JRD2vTWv-LFPkAxHzJXErXt5lz3MPAye_O_R6576OVP3bj295aproJJW0hgUB5CgLLopWXp-RwRAmObJlq9IIVi2pB49S5CSg223IURXOPFWjORF2sU2pjk6Tv6h1zlKE-XXZjrG19VD7Lh7Bs2UMDXLvYcmGxe6tqqgWtPxUeKLvSGUpOpF95gunxjcfqx-IDOaDnyeCyHW45W0Or3s4cGS3CoMkCK2elN9k"/>
  </div>
</header>

<main class="pt-20 pb-32 px-4 max-w-2xl mx-auto">
  <?php if ($mensaje): ?>
      <div class="mb-4 p-4 rounded-xl bg-green-100 text-green-800 font-bold border border-green-200 flex items-center gap-2 shadow-sm">
          <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
          <?= $mensaje ?>
      </div>
  <?php endif; ?>

  <section class="mb-8 mt-4">
    <span class="text-primary font-bold tracking-widest text-[10px] uppercase">Módulo de Afiliación</span>
    <h2 class="font-headline font-extrabold text-4xl text-on-surface mt-1 leading-tight">Nueva Captura</h2>
    <p class="text-on-surface-variant mt-2 text-sm">Ingrese la información del simpatizante con precisión. Todos los campos marcados son requeridos para el proceso institucional.</p>
  </section>

  <form method="POST" action="" class="space-y-6">
    <div class="bg-surface-container-low rounded-xl p-1">
      <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/10">
        
        <div class="mb-8 flex items-center justify-between bg-surface-container-low p-4 rounded-lg">
          <div>
            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-tighter">Folio de Registro</p>
            <p class="font-headline font-bold text-lg text-primary"><?= $display_folio ?></p>
          </div>
          <div class="bg-primary/10 text-primary px-3 py-1 rounded-full text-[10px] font-bold uppercase">Sistema Activo</div>
        </div>

        <div class="space-y-8">
          <fieldset>
            <legend class="text-sm font-bold text-on-surface mb-4 flex items-center gap-2">
              <span class="w-1 h-4 bg-primary rounded-full"></span> Datos Personales
            </legend>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="col-span-2">
                <label class="block text-[11px] font-semibold text-on-surface-variant mb-1 px-1">Nombre(s) *</label>
                <input name="nombre" class="w-full bg-surface-container-highest border-none rounded-md p-4 text-base form-input-focus transition-all focus:ring-0" placeholder="Ej. Juan Carlos" required type="text"/>
              </div>
              <div>
                <label class="block text-[11px] font-semibold text-on-surface-variant mb-1 px-1">Apellido Paterno *</label>
                <input name="paterno" class="w-full bg-surface-container-highest border-none rounded-md p-4 text-base form-input-focus transition-all focus:ring-0" placeholder="García" required type="text"/>
              </div>
              <div>
                <label class="block text-[11px] font-semibold text-on-surface-variant mb-1 px-1">Apellido Materno</label>
                <input name="materno" class="w-full bg-surface-container-highest border-none rounded-md p-4 text-base form-input-focus transition-all focus:ring-0" placeholder="López" type="text"/>
              </div>
            </div>
          </fieldset>

          <fieldset>
            <legend class="text-sm font-bold text-on-surface mb-4 flex items-center gap-2">
              <span class="w-1 h-4 bg-primary rounded-full"></span> Domicilio Particular
            </legend>
            <div class="grid grid-cols-6 gap-4">
              <div class="col-span-4">
                <label class="block text-[11px] font-semibold text-on-surface-variant mb-1 px-1">Calle *</label>
                <input name="calle" class="w-full bg-surface-container-highest border-none rounded-md p-4 text-base form-input-focus transition-all focus:ring-0" placeholder="Av. de la Reforma" required type="text"/>
              </div>
              <div class="col-span-2">
                <label class="block text-[11px] font-semibold text-on-surface-variant mb-1 px-1">Número *</label>
                <input name="numero" class="w-full bg-surface-container-highest border-none rounded-md p-4 text-base form-input-focus transition-all focus:ring-0" placeholder="123" required type="number"/>
              </div>
              <div class="col-span-6">
                <label class="block text-[11px] font-semibold text-on-surface-variant mb-1 px-1">Colonia *</label>
                <input name="colonia" class="w-full bg-surface-container-highest border-none rounded-md p-4 text-base form-input-focus transition-all focus:ring-0" placeholder="Centro Histórico" required type="text"/>
              </div>
            </div>
          </fieldset>

          <fieldset>
            <legend class="text-sm font-bold text-on-surface mb-4 flex items-center gap-2">
              <span class="w-1 h-4 bg-primary rounded-full"></span> Medios de Contacto
            </legend>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-[11px] font-semibold text-on-surface-variant mb-1 px-1">Teléfono *</label>
                <input name="telefono" class="w-full bg-surface-container-highest border-none rounded-md p-4 text-base form-input-focus transition-all focus:ring-0" placeholder="55 1234 5678" required type="tel"/>
              </div>
              <div>
                <label class="block text-[11px] font-semibold text-on-surface-variant mb-1 px-1">Correo Electrónico *</label>
                <input name="mail" class="w-full bg-surface-container-highest border-none rounded-md p-4 text-base form-input-focus transition-all focus:ring-0" placeholder="usuario@dominio.com" required type="email"/>
              </div>
            </div>
          </fieldset>

          <fieldset>
            <legend class="text-sm font-bold text-on-surface mb-4 flex items-center gap-2">
              <span class="w-1 h-4 bg-primary rounded-full"></span> Datos Electorales
            </legend>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-[11px] font-semibold text-on-surface-variant mb-1 px-1">Sección *</label>
                <input name="seccion" class="w-full bg-surface-container-highest border-none rounded-md p-4 text-base form-input-focus transition-all focus:ring-0" placeholder="Ej. 1234" required type="number"/>
              </div>
              <div>
                <label class="block text-[11px] font-semibold text-on-surface-variant mb-1 px-1">Distrito Local (DL) *</label>
                <input name="dl" class="w-full bg-surface-container-highest border-none rounded-md p-4 text-base form-input-focus transition-all focus:ring-0" placeholder="Ej. 12" required type="number"/>
              </div>
            </div>
          </fieldset>
        </div>
      </div>
    </div>

    <div class="pt-6">
      <button class="w-full bg-gradient-to-r from-primary to-primary-container text-on-primary font-bold py-5 rounded-md shadow-lg shadow-primary/20 hover:brightness-110 active:scale-[0.98] transition-all flex items-center justify-center gap-3" type="submit">
        <span class="material-symbols-outlined">save</span>
        Guardar Simpatizante
      </button>
      <p class="text-center text-[10px] text-on-surface-variant mt-4 opacity-60">Al guardar, los datos serán encriptados y enviados al servidor institucional central.</p>
    </div>
  </form>
</main>

<nav class="fixed bottom-0 left-0 w-full z-50 rounded-t-2xl bg-[#faf8ff]/80 dark:bg-slate-950/80 backdrop-blur-lg border-t border-[#c3c6d6]/15 shadow-[0_-8px_32px_rgba(25,27,34,0.06)] flex justify-around items-center pt-2 pb-6 px-4">
  <a href="index.php" class="flex flex-col items-center justify-center text-[#434653] dark:text-slate-500 px-5 py-1 hover:opacity-80 active:translate-y-0.5 transition-transform">
    <span class="material-symbols-outlined">home</span>
    <span class="font-inter text-[11px] font-medium mt-1">Inicio</span>
  </a>
  <a href="captura.php" class="flex flex-col items-center justify-center bg-[#bccbfe] dark:bg-blue-900/40 text-[#465581] dark:text-blue-200 rounded-xl px-5 py-1 hover:opacity-80 active:translate-y-0.5 transition-transform">
    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">edit_document</span>
    <span class="font-inter text-[11px] font-medium mt-1">Captura</span>
  </a>
  <a href="historial.php" class="flex flex-col items-center justify-center text-[#434653] dark:text-slate-500 px-5 py-1 hover:opacity-80 active:translate-y-0.5 transition-transform">
    <span class="material-symbols-outlined">history</span>
    <span class="font-inter text-[11px] font-medium mt-1">Historial</span>
  </a>
</nav>
</body></html>
