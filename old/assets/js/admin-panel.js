(function () {
  const STORAGE_KEY = window.TAPISUR_STORAGE_KEY || 'tapisur_admin_content_v1';
  const DEFAULTS = window.TAPISUR_SITE_DEFAULTS || {};
  const SESSION_KEY = 'tapisur_admin_session_v1';

  const ADMIN_USER = 'dueno_tapisur';
  const ADMIN_PASS = 'TapiSur2026!';

  const loginView = document.getElementById('loginView');
  const panelView = document.getElementById('panelView');
  const loginForm = document.getElementById('loginForm');
  const loginMsg = document.getElementById('loginMsg');
  const contentForm = document.getElementById('contentForm');
  const saveMsg = document.getElementById('saveMsg');
  const logoutBtn = document.getElementById('logoutBtn');
  const restoreBtn = document.getElementById('restoreBtn');
  const exportBtn = document.getElementById('exportBtn');
  const importBtn = document.getElementById('importBtn');
  const importFile = document.getElementById('importFile');

  function readContent() {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      if (!raw) return { ...DEFAULTS };
      const parsed = JSON.parse(raw);
      return { ...DEFAULTS, ...parsed };
    } catch (_e) {
      return { ...DEFAULTS };
    }
  }

  function saveContent(data) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
  }

  function setSession(active) {
    if (active) sessionStorage.setItem(SESSION_KEY, '1');
    else sessionStorage.removeItem(SESSION_KEY);
  }

  function isSessionActive() {
    return sessionStorage.getItem(SESSION_KEY) === '1';
  }

  function showPanel(show) {
    loginView.hidden = show;
    panelView.hidden = !show;
  }

  function fillForm(data) {
    Object.keys(DEFAULTS).forEach((key) => {
      const input = contentForm.elements.namedItem(key);
      if (input) input.value = data[key] || '';
    });
  }

  function collectForm() {
    const data = {};
    Object.keys(DEFAULTS).forEach((key) => {
      const input = contentForm.elements.namedItem(key);
      data[key] = input ? String(input.value || '').trim() : DEFAULTS[key];
    });
    return data;
  }

  function validInstagram(url) {
    return /^https:\/\//i.test(url);
  }

  function validWhatsappNumber(value) {
    return /^\d{10,15}$/.test(value);
  }

  loginForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const user = String(loginForm.username.value || '').trim();
    const pass = String(loginForm.password.value || '').trim();

    if (user === ADMIN_USER && pass === ADMIN_PASS) {
      setSession(true);
      showPanel(true);
      fillForm(readContent());
      loginMsg.textContent = '';
      return;
    }

    loginMsg.textContent = 'Usuario o clave incorrectos.';
  });

  contentForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const data = collectForm();

    if (!validInstagram(data.instagram_url)) {
      saveMsg.textContent = 'La URL de Instagram debe empezar con https://';
      return;
    }

    if (!validWhatsappNumber(data.whatsapp_number)) {
      saveMsg.textContent = 'WhatsApp debe tener entre 10 y 15 digitos, sin espacios.';
      return;
    }

    saveContent(data);
    saveMsg.textContent = 'Cambios guardados. Recarga el sitio para verlos.';
  });

  restoreBtn.addEventListener('click', () => {
    fillForm(DEFAULTS);
    saveContent(DEFAULTS);
    saveMsg.textContent = 'Se restauraron los valores por defecto.';
  });

  logoutBtn.addEventListener('click', () => {
    setSession(false);
    showPanel(false);
    loginForm.reset();
    saveMsg.textContent = '';
  });

  exportBtn.addEventListener('click', () => {
    const data = collectForm();
    const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'tapisur-config.json';
    document.body.appendChild(a);
    a.click();
    a.remove();
    URL.revokeObjectURL(url);
    saveMsg.textContent = 'Configuracion exportada.';
  });

  importBtn.addEventListener('click', () => {
    importFile.click();
  });

  importFile.addEventListener('change', async () => {
    const file = importFile.files && importFile.files[0];
    if (!file) return;
    try {
      const text = await file.text();
      const parsed = JSON.parse(text);
      const data = { ...DEFAULTS, ...parsed };
      fillForm(data);
      saveContent(data);
      saveMsg.textContent = 'Configuracion importada y guardada.';
    } catch (_e) {
      saveMsg.textContent = 'No se pudo importar el JSON.';
    } finally {
      importFile.value = '';
    }
  });

  if (isSessionActive()) {
    showPanel(true);
    fillForm(readContent());
  } else {
    showPanel(false);
  }
})();
