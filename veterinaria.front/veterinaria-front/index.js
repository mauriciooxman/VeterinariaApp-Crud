const API = "http://localhost:8080";

const URLS = {
  mascotas: `${API}/mascotas`,
  usuarios: `${API}/usuario`,
  veterinarios: `${API}/veterinarios`,
  medicamentos: `${API}/medicamentos`,
};

/* ---------- TABS ---------- */

function cambiarTab(seccion, tab) {
  document.querySelectorAll(".section").forEach(s => s.classList.remove("active"));
  document.querySelectorAll(".tab").forEach(t => t.classList.remove("active"));

  document.getElementById(seccion).classList.add("active");
  tab.classList.add("active");

  cargarDatos(seccion);

  if (seccion === "mascotas") {
    cargarRelacionesMascota();
  }

  if (seccion === "usuarios") {
    cargarMascotasParaUsuario();
  }
}

/* ---------- CARGA GENERAL ---------- */

function cargarDatos(seccion) {
  if (seccion === "mascotas") cargarMascotas();
  if (seccion === "usuarios") cargarUsuarios();
  if (seccion === "veterinarios") cargarVeterinarios();
  if (seccion === "medicamentos") cargarMedicamentos();
}

/* ---------- MASCOTAS ---------- */

function cargarMascotas() {
  fetch(URLS.mascotas)
    .then(res => res.json())
    .then(data => {
      const ul = document.getElementById("listaMascotas");
      ul.innerHTML = "";
      data.forEach(m => {
        const duenioNombre = m.duenio ? m.duenio.nombre : "Sin dueño";
        const veterinarioNombre = m.veterinario ? m.veterinario.nombre : "Sin veterinario";
        const medicamentosTexto = (m.medicamentos && m.medicamentos.length > 0)
          ? m.medicamentos.map(md => md.nombre).join(", ")
          : "Sin medicamentos";
        ul.innerHTML += `
          <li>
            ${m.nombre} - ${m.raza} - ${m.tipoDeAnimal || "Sin tipo"} - Dueño: ${duenioNombre} - Vet: ${veterinarioNombre} - Medicamentos: ${medicamentosTexto}
            <button onclick="cargarMascotaParaEditar(${m.id})">Editar</button>
            <button onclick="eliminarMascota(${m.id})">Eliminar</button>
          </li>`;
      });
    });
}

function cargarMascotaParaEditar(id) {
  fetch(`${URLS.mascotas}/${id}`)
    .then(res => res.json())
    .then(mascota => {
      document.getElementById("mascotaId").value = mascota.id;
      document.getElementById("mascotaNombre").value = mascota.nombre || "";
      document.getElementById("mascotaRaza").value = mascota.raza || "";
      document.getElementById("mascotaTipoAnimal").value = mascota.tipoDeAnimal || "";
      document.getElementById("mascotaDuenio").value = mascota.duenio ? mascota.duenio.id : "";
      document.getElementById("mascotaVeterinario").value = mascota.veterinario ? mascota.veterinario.id : "";
      const selectMedicamentos = document.getElementById("mascotaMedicamentos");
      const medicamentoIds = mascota.medicamentos ? mascota.medicamentos.map(md => String(md.id)) : [];
      Array.from(selectMedicamentos.options).forEach(option => {
        option.selected = medicamentoIds.includes(option.value);
      });
      document.getElementById("estadoEdicionMascota").textContent = `Modo: Editar mascota #${mascota.id}`;
    });
}

function cancelarEdicionMascota() {
  document.getElementById("mascotaId").value = "";
  document.getElementById("mascotaNombre").value = "";
  document.getElementById("mascotaRaza").value = "";
  document.getElementById("mascotaTipoAnimal").value = "";
  document.getElementById("mascotaDuenio").value = "";
  document.getElementById("mascotaVeterinario").value = "";
  Array.from(document.getElementById("mascotaMedicamentos").options).forEach(option => {
    option.selected = false;
  });
  document.getElementById("estadoEdicionMascota").textContent = "Modo: Crear";
}

function cargarRelacionesMascota() {
  Promise.all([
    fetch(URLS.usuarios).then(res => res.json()),
    fetch(URLS.veterinarios).then(res => res.json()),
    fetch(URLS.medicamentos).then(res => res.json()),
  ]).then(([usuarios, veterinarios, medicamentos]) => {
    const selectDuenio = document.getElementById("mascotaDuenio");
    const selectVeterinario = document.getElementById("mascotaVeterinario");
    const selectMedicamentos = document.getElementById("mascotaMedicamentos");

    selectDuenio.innerHTML = '<option value="">Seleccione dueño</option>';
    usuarios.forEach(u => {
      selectDuenio.innerHTML += `<option value="${u.id}">${u.nombre}</option>`;
    });

    selectVeterinario.innerHTML = '<option value="">Seleccione veterinario</option>';
    veterinarios.forEach(v => {
      selectVeterinario.innerHTML += `<option value="${v.id}">${v.nombre}</option>`;
    });

    selectMedicamentos.innerHTML = "";
    medicamentos.forEach(md => {
      selectMedicamentos.innerHTML += `<option value="${md.id}">${md.nombre} (${md.dosis || "sin dosis"})</option>`;
    });
  });
}

function guardarMascota() {
  const id = document.getElementById("mascotaId").value;
  const nombre = document.getElementById("mascotaNombre").value;
  const raza = document.getElementById("mascotaRaza").value;
  const tipoDeAnimal = document.getElementById("mascotaTipoAnimal").value;
  const duenioId = document.getElementById("mascotaDuenio").value;
  const veterinarioId = document.getElementById("mascotaVeterinario").value;
  const medicamentosSeleccionados = Array.from(document.getElementById("mascotaMedicamentos").selectedOptions)
    .map(option => ({ id: Number(option.value) }));

  const duenio = duenioId ? { id: Number(duenioId) } : null;
  const veterinario = veterinarioId ? { id: Number(veterinarioId) } : null;

  const payload = { nombre, raza, tipoDeAnimal, duenio, veterinario, medicamentos: medicamentosSeleccionados };

  if (id) {
    payload.id = Number(id);
  }

  const url = id ? `${URLS.mascotas}/editar` : URLS.mascotas;
  const method = id ? "PUT" : "POST";

  fetch(url, {
    method,
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload),
  }).then(() => {
    cancelarEdicionMascota();
    cargarMascotas();
  });
}

function eliminarMascota(id) {
  fetch(`${URLS.mascotas}/${id}`, { method: "DELETE" })
    .then(() => {
      cargarMascotas();
      cargarMascotasParaUsuario();
    });
}

/* ---------- USUARIOS ---------- */

function cargarUsuarios() {
  fetch(URLS.usuarios)
    .then(res => res.json())
    .then(data => {
      const ul = document.getElementById("listaUsuarios");
      ul.innerHTML = "";
      data.forEach(u => {
        const mascotasTexto = (u.mascotas && u.mascotas.length > 0)
          ? u.mascotas.map(m => m.nombre).join(", ")
          : "Sin mascota";
        ul.innerHTML += `
          <li>
            ${u.nombre} ${u.apellido || ""} - Mascota: ${mascotasTexto}
            <button onclick="cargarUsuarioParaEditar(${u.id})">Editar</button>
            <button onclick="eliminarUsuario(${u.id})">Eliminar</button>
          </li>`;
      });
    });
}

function cargarUsuarioParaEditar(id) {
  Promise.all([
    fetch(`${URLS.usuarios}/${id}`).then(res => res.json()),
    fetch(URLS.mascotas).then(res => res.json()),
  ]).then(([usuario, mascotas]) => {
    const selectMascota = document.getElementById("usuarioMascota");
    selectMascota.innerHTML = '<option value="">Seleccione mascota</option>';

    mascotas.forEach(m => {
      selectMascota.innerHTML += `<option value="${m.id}">${m.nombre} (${m.raza || "sin raza"})</option>`;
    });

    document.getElementById("usuarioId").value = usuario.id;
    document.getElementById("usuarioNombre").value = usuario.nombre || "";
    document.getElementById("usuarioApellido").value = usuario.apellido || "";
    document.getElementById("usuarioMascota").value = (usuario.mascotas && usuario.mascotas.length > 0)
      ? usuario.mascotas[0].id
      : "";
    document.getElementById("estadoEdicionUsuario").textContent = `Modo: Editar usuario #${usuario.id}`;
  });
}

function cancelarEdicionUsuario() {
  document.getElementById("usuarioId").value = "";
  document.getElementById("usuarioNombre").value = "";
  document.getElementById("usuarioApellido").value = "";
  document.getElementById("usuarioMascota").value = "";
  document.getElementById("estadoEdicionUsuario").textContent = "Modo: Crear";
}

function cargarMascotasParaUsuario() {
  fetch(URLS.mascotas)
    .then(res => res.json())
    .then(data => {
      const selectMascota = document.getElementById("usuarioMascota");
      selectMascota.innerHTML = '<option value="">Seleccione mascota</option>';

      data.forEach(m => {
        selectMascota.innerHTML += `<option value="${m.id}">${m.nombre} (${m.raza || "sin raza"})</option>`;
      });
    });
}

function guardarUsuario() {
  const id = document.getElementById("usuarioId").value;
  const nombre = document.getElementById("usuarioNombre").value;
  const apellido = document.getElementById("usuarioApellido").value;
  const mascotaId = document.getElementById("usuarioMascota").value;

  const mascotas = mascotaId ? [{ id: Number(mascotaId) }] : [];

  const payload = { nombre, apellido, mascotas };
  if (id) {
    payload.id = Number(id);
  }

  const url = id ? `${URLS.usuarios}/editar` : URLS.usuarios;
  const method = id ? "PUT" : "POST";

  fetch(url, {
    method,
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload),
  }).then(() => {
    cancelarEdicionUsuario();
    cargarUsuarios();
    cargarMascotas();
    cargarRelacionesMascota();
    cargarMascotasParaUsuario();
  });
}

function eliminarUsuario(id) {
  fetch(`${URLS.usuarios}/${id}`, { method: "DELETE" })
    .then(() => {
      cargarUsuarios();
      cargarMascotas();
      cargarMascotasParaUsuario();
      cargarRelacionesMascota();
    });
}

/* ---------- VETERINARIOS ---------- */

function cargarVeterinarios() {
  fetch(URLS.veterinarios)
    .then(res => res.json())
    .then(data => {
      const ul = document.getElementById("listaVeterinarios");
      ul.innerHTML = "";
      data.forEach(v => {
        ul.innerHTML += `
          <li>
            ${v.nombre} - ${v.especialidad}
            <button onclick="eliminarVeterinario(${v.id})">Eliminar</button>
          </li>`;
      });
    });
}

function guardarVeterinario() {
  const nombre = document.getElementById("vetNombre").value;
  const especialidad = document.getElementById("vetEspecialidad").value;

  fetch(URLS.veterinarios, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ nombre, especialidad }),
  }).then(() => {
    document.getElementById("vetNombre").value = "";
    document.getElementById("vetEspecialidad").value = "";
    cargarVeterinarios();
    cargarRelacionesMascota();
  });
}

function eliminarVeterinario(id) {
  fetch(`${URLS.veterinarios}/${id}`, { method: "DELETE" })
    .then(cargarVeterinarios);
}

/* ---------- MEDICAMENTOS ---------- */

function cargarMedicamentos() {
  fetch(URLS.medicamentos)
    .then(res => res.json())
    .then(data => {
      const ul = document.getElementById("listaMedicamentos");
      ul.innerHTML = "";
      data.forEach(m => {
        ul.innerHTML += `
          <li>
            ${m.nombre} - ${m.dosis}
            <button onclick="eliminarMedicamento(${m.id})">Eliminar</button>
          </li>`;
      });
    });
}

function guardarMedicamento() {
  const nombre = document.getElementById("medNombre").value;
  const dosis = document.getElementById("medDosis").value;

  fetch(URLS.medicamentos, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ nombre, dosis }),
  }).then(() => {
    document.getElementById("medNombre").value = "";
    document.getElementById("medDosis").value = "";
    cargarMedicamentos();
    cargarRelacionesMascota();
  });
}

function eliminarMedicamento(id) {
  fetch(`${URLS.medicamentos}/${id}`, { method: "DELETE" })
    .then(() => {
      cargarMedicamentos();
      cargarRelacionesMascota();
      cargarMascotas();
    });
}

window.addEventListener("DOMContentLoaded", () => {
  cargarMascotas();
  cargarRelacionesMascota();
  cargarMascotasParaUsuario();
  cargarUsuarios();
});
