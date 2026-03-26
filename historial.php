<?php
require 'db.php';

// Obtener registros
$stmt = $pdo->query("SELECT * FROM registros ORDER BY id DESC");
$registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = count($registros);

// Obtener cuantos de hoy
$stmt = $pdo->query("SELECT COUNT(*) FROM registros WHERE date(fecha_registro) = date('now')");
$hoy = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html class="light" lang="es"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
<meta name="theme-color" content="#faf8ff" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" />
<title>PAN Registro - Historial</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
tailwind.config = { darkMode: "class", theme: { extend: { colors: { "on-tertiary": "#ffffff", "surface-bright": "#faf8ff", "error-container": "#ffdad6", "on-secondary-container": "#465581", "on-background": "#191b22", "primary-container": "#0047bb", "tertiary-container": "#932d00", "on-surface-variant": "#434653", "tertiary-fixed": "#ffdbcf", "surface-container-lowest": "#ffffff", "on-primary-container": "#afc1ff", "tertiary": "#6c1f00", "on-primary": "#ffffff", "tertiary-fixed-dim": "#ffb59c", "surface-container-high": "#e7e7f1", "on-secondary-fixed": "#071942", "background": "#faf8ff", "secondary": "#4e5d8a", "primary-fixed-dim": "#b3c5ff", "primary": "#00328a", "surface-container": "#ededf7", "outline": "#737685", "on-error": "#ffffff", "secondary-container": "#bccbfe", "inverse-primary": "#b3c5ff", "inverse-surface": "#2e3038", "on-tertiary-container": "#ffb096", "secondary-fixed": "#dbe1ff", "on-tertiary-fixed-variant": "#832700", "secondary-fixed-dim": "#b6c5f8", "inverse-on-surface": "#f0f0fa", "surface-tint": "#2156ca", "error": "#ba1a1a", "surface-variant": "#e2e2ec", "surface": "#faf8ff", "on-secondary-fixed-variant": "#364570", "surface-container-low": "#f3f3fd", "surface-dim": "#d9d9e3", "on-surface": "#191b22", "outline-variant": "#c3c6d6", "surface-container-highest": "#e2e2ec", "primary-fixed": "#dbe1ff", "on-tertiary-fixed": "#390c00", "on-primary-fixed-variant": "#003ea6", "on-secondary": "#ffffff", "on-primary-fixed": "#00174a", "on-error-container": "#93000a" }, fontFamily: { "headline": ["Manrope"], "body": ["Inter"], "label": ["Inter"] }, borderRadius: {"DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem"}, }, }, }
</script>
<style>
.material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
body { background-color: #faf8ff; font-family: 'Inter', sans-serif; min-height: max(884px, 100dvh); touch-action: manipulation; -webkit-tap-highlight-color: transparent; }
.editorial-header { font-family: 'Manrope', sans-serif; }
</style>
</head>
<body class="bg-surface text-on-surface pb-24">

<header class="fixed top-0 w-full z-50 px-4 bg-surface dark:bg-slate-950">
  <div class="flex justify-between items-center h-16 w-full px-6 bg-surface-container-low dark:bg-slate-900 shadow-none">
    <div class="flex items-center gap-4">
      <button class="text-primary dark:text-blue-400 hover:bg-surface-container-highest dark:hover:bg-slate-800 transition-colors active:scale-95 duration-200 p-2 rounded-full">
        <span class="material-symbols-outlined">menu</span>
      </button>
      <h1 class="font-headline font-extrabold text-primary dark:text-blue-500 tracking-tight text-xl">PAN Registro</h1>
    </div>
    <div class="flex items-center">
      <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center overflow-hidden border-2 border-primary/10">
        <img alt="User" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBgRtlcVnK7UshqheeN1KCH-zYoDI5NOCMKbmt4Cink3QoyIRoek_qmgPVrj_P6WvEDJXeAsHE3hmmGpgmLxERKivrhiTH9z5wE4DQm-tu9AhZ9XK0kvkga807lnef0z_v-yV2hwHgo_PUjJtCOEK_Yl3R4REHpE3tBXyRR45AXZ5WyaIbSDb9NYuNQZEveALIOfbiPwa-AjIk_H7wBqZ37etmvby9RqM2zue2U-6F8mBd1eeTRdqSsNSPfeNUrUX_n9x69appWSgg"/>
      </div>
    </div>
  </div>
</header>

<main class="pt-24 px-6 max-w-2xl mx-auto">
  <section class="mb-8">
    <h2 class="font-headline text-3xl font-extrabold text-on-surface tracking-tight leading-tight">Historial de Registros</h2>
    <p class="font-body text-on-surface-variant text-sm mt-2">Consulta y gestiona las personas capturadas recientemente en tu zona.</p>
  </section>

  <div class="relative mb-8 group">
    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
      <span class="material-symbols-outlined text-outline">search</span>
    </div>
    <input class="w-full bg-surface-container-highest border-none rounded-xl py-4 pl-12 pr-4 text-on-surface placeholder:text-on-surface-variant/60 focus:ring-0 focus:bg-surface-container-lowest transition-all duration-300 shadow-sm focus:shadow-md" placeholder="Buscar por nombre o colonia..." type="text"/>
    <div class="absolute bottom-0 left-0 w-0 h-[2px] bg-primary transition-all duration-300 group-focus-within:w-full"></div>
  </div>

  <div class="grid grid-cols-2 gap-4 mb-8">
    <div class="bg-surface-container-low p-5 rounded-xl flex flex-col justify-between h-32 border-l-4 border-primary">
      <span class="text-primary font-headline font-bold text-2xl"><?= number_format($total) ?></span>
      <span class="text-on-surface-variant font-label text-xs uppercase tracking-wider font-semibold">Total Registros</span>
    </div>
    <div class="bg-secondary-container/30 p-5 rounded-xl flex flex-col justify-between h-32">
      <div class="flex justify-between items-start">
        <span class="material-symbols-outlined text-secondary">trending_up</span>
        <span class="text-secondary font-headline font-bold text-lg">+<?= $hoy ?></span>
      </div>
      <span class="text-on-secondary-container font-label text-xs uppercase tracking-wider font-semibold">Hoy</span>
    </div>
  </div>

  <div class="space-y-4">
    <?php if(empty($registros)): ?>
        <p class="text-center text-on-surface-variant py-8">No hay registros capturados aún.</p>
    <?php else: ?>
        <?php foreach($registros as $row): 
            $initials = strtoupper(substr($row['nombre'],0,1) . substr($row['paterno'],0,1));
        ?>
        <div class="bg-surface-container-lowest p-5 rounded-xl flex items-center justify-between group hover:bg-surface-container-low transition-all duration-200 shadow-sm">
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-primary/5 flex items-center justify-center text-primary font-bold font-headline text-lg">
              <?= $initials ?>
            </div>
            <div class="flex-1 min-w-0">
              <h3 class="font-body font-semibold text-on-surface truncate"><?= htmlspecialchars($row['nombre']) ?> <?= htmlspecialchars($row['paterno']) ?></h3>
              <p class="font-body text-xs text-on-surface-variant truncate">Col. <?= htmlspecialchars($row['colonia']) ?></p>
            </div>
          </div>
          <div class="flex items-center gap-2">
            <button class="p-2 rounded-lg text-on-surface-variant hover:bg-white hover:text-primary transition-colors">
              <span class="material-symbols-outlined" style="font-variation-settings: 'opsz' 20;">edit</span>
            </button>
            <button onclick="alert('Teléfono: <?= htmlspecialchars($row['telefono']) ?>\nEmail: <?= htmlspecialchars($row['mail']) ?>')" class="p-2 rounded-lg text-on-surface-variant hover:bg-white hover:text-primary transition-colors">
              <span class="material-symbols-outlined" style="font-variation-settings: 'opsz' 20;">visibility</span>
            </button>
          </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <a href="captura.php">
      <button class="fixed bottom-24 right-6 w-14 h-14 bg-primary text-white rounded-2xl shadow-[0_8px_32px_rgba(25,27,34,0.15)] flex items-center justify-center hover:scale-105 transition-transform active:scale-95 z-40">
        <span class="material-symbols-outlined">add</span>
      </button>
  </a>
</main>

<nav class="fixed bottom-0 left-0 w-full z-50 bg-[#faf8ff]/80 dark:bg-slate-950/80 backdrop-blur-lg border-t border-[#c3c6d6]/15 shadow-[0_-8px_32px_rgba(25,27,34,0.06)] rounded-t-2xl">
  <div class="w-full flex justify-around items-center pt-2 pb-6 px-4 h-20">
    <a href="index.php" class="flex flex-col items-center justify-center text-[#434653] dark:text-slate-500 px-5 py-1 hover:opacity-80 active:translate-y-0.5 transition-transform">
      <span class="material-symbols-outlined">home</span>
      <span class="font-inter text-[11px] font-medium mt-1">Inicio</span>
    </a>
    <a href="captura.php" class="flex flex-col items-center justify-center text-[#434653] dark:text-slate-500 px-5 py-1 hover:opacity-80 active:translate-y-0.5 transition-transform">
      <span class="material-symbols-outlined">edit_document</span>
      <span class="font-inter text-[11px] font-medium mt-1">Captura</span>
    </a>
    <a href="historial.php" class="flex flex-col items-center justify-center bg-[#bccbfe] dark:bg-blue-900/40 text-[#465581] dark:text-blue-200 rounded-xl px-5 py-1 active:translate-y-0.5 transition-transform">
      <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">history</span>
      <span class="font-inter text-[11px] font-medium mt-1">Historial</span>
    </a>
  </div>
</nav>

</body></html>
