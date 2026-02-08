<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>México · Country Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    /* Águila recorriendo la card */
    @keyframes eagleRun {
      0% {
        transform: translateX(-20%);
        opacity: 0;
      }
      10% {
        opacity: 1;
      }
      90% {
        opacity: 1;
      }
      100% {
        transform: translateX(120%);
        opacity: 0;
      }
    }

    .eagle {
      animation: eagleRun 14s linear infinite;
    }

    /* Entrada suave del contenido */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(12px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-up {
      animation: fadeUp 0.8s ease-out forwards;
    }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6
             bg-gradient-to-r from-green-600 via-white to-red-600">

  <div class="relative w-full max-w-xl bg-white/90 backdrop-blur-xl
              rounded-3xl shadow-2xl p-8 border border-white/40 overflow-hidden">

    <!-- ÁGUILA ANIMADA -->
    <div class="absolute top-3 left-0 w-full pointer-events-none">
      <div class="eagle text-3xl opacity-40">
        🦅
      </div>
    </div>

    <!-- HEADER -->
    <header class="text-center mb-8 mt-6">
      <div class="flex justify-center mb-4">
        <img
          src="descarga.jpg"
          alt="Escudo de México"
          class="h-20 w-20"
        >
      </div>

      <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">
        México
      </h1>
      <p class="text-sm text-slate-500">
        Country Info Dashboard · PHP API · RestCountries
      </p>
    </header>

    <!-- LOADING -->
    <div id="loading" class="text-center py-10">
      <div class="animate-spin h-10 w-10 border-4 border-slate-300 border-t-slate-700 rounded-full mx-auto mb-4"></div>
      <p class="text-slate-500 text-sm">Cargando información del país…</p>
    </div>

    <!-- ERROR -->
    <div id="error"
         class="hidden bg-red-50 border border-red-200 text-red-700
                p-4 rounded-xl text-sm text-center">
      No se pudo cargar la información del país.
    </div>

    <!-- CONTENT -->
    <div id="content" class="hidden fade-up">
      <div class="overflow-hidden rounded-xl border border-slate-200">
        <table class="w-full text-sm">
          <tbody id="tabla" class="divide-y divide-slate-200"></tbody>
        </table>
      </div>
    </div>

    <!-- FOOTER -->
    <footer class="mt-6 text-center text-xs text-slate-400">
      Fuente de datos: RestCountries API
    </footer>

  </div>

<script>
fetch("api.php")
  .then(res => {
    if (!res.ok) throw new Error("Error HTTP");
    return res.json();
  })
  .then(data => {
    document.getElementById("loading").classList.add("hidden");
    document.getElementById("content").classList.remove("hidden");

    const tabla = document.getElementById("tabla");

    const campos = [
      { label: "Nombre", value: data.name, icon: "🏳️" },
      { label: "Traducción (ES)", value: data.translation_spa, icon: "🈯" },
      { label: "Idioma", value: data.language, icon: "🗣️" },
      { label: "Gentilicio", value: data.demonym, icon: "👥" },
      { label: "Código telefónico", value: data.calling_code, icon: "📞" }
    ];

    campos.forEach(c => {
      tabla.innerHTML += `
        <tr class="hover:bg-slate-50 transition">
          <td class="px-4 py-4 text-slate-600">
            ${c.icon} ${c.label}
          </td>
          <td class="px-4 py-4 font-semibold text-slate-800 text-right">
            ${c.value || "—"}
          </td>
        </tr>
      `;
    });
  })
  .catch(err => {
    document.getElementById("loading").classList.add("hidden");
    document.getElementById("error").classList.remove("hidden");
    console.error(err);
  });
</script>

</body>
</html>


