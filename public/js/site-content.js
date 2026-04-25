(function () {
  const defaults = window.TAPISUR_SITE_DEFAULTS || {};
  const storageKey = window.TAPISUR_STORAGE_KEY || 'tapisur_admin_content_v1';

  function safeRead() {
    try {
      const raw = localStorage.getItem(storageKey);
      if (!raw) return {};
      const parsed = JSON.parse(raw);
      return parsed && typeof parsed === 'object' ? parsed : {};
    } catch (_e) {
      return {};
    }
  }

  function digitsOnly(value) {
    return String(value || '').replace(/\D+/g, '');
  }

  function normalizePhoneForTel(value) {
    const digits = digitsOnly(value);
    if (!digits) return '';
    if (digits.startsWith('54')) return `+${digits}`;
    if (digits.startsWith('0')) return `+54${digits.slice(1)}`;
    return `+54${digits}`;
  }

  function normalizeWhatsapp(value) {
    const digits = digitsOnly(value);
    if (!digits) return defaults.whatsapp_number || '5491151103419';
    if (digits.startsWith('549')) return digits;
    if (digits.startsWith('54')) return `9${digits}`;
    if (digits.startsWith('11')) return `549${digits}`;
    return digits;
  }

  function applyText(data) {
    document.querySelectorAll('[data-content]').forEach((node) => {
      const key = node.getAttribute('data-content');
      if (!key) return;
      const value = data[key];
      if (typeof value === 'string' && value.trim()) {
        node.textContent = value.trim();
      }
    });
  }

  function applyLinks(data) {
    const phone1 = data.phone_1 || defaults.phone_1;
    const phone2 = data.phone_2 || defaults.phone_2;
    const address = data.address || defaults.address;
    const insta = data.instagram_url || defaults.instagram_url;
    const whatsapp = normalizeWhatsapp(data.whatsapp_number || defaults.whatsapp_number);

    document.querySelectorAll('.phone1-link').forEach((a) => {
      a.textContent = phone1;
      a.setAttribute('href', `tel:${normalizePhoneForTel(phone1)}`);
    });

    document.querySelectorAll('.phone2-link').forEach((a) => {
      a.textContent = phone2;
      a.setAttribute('href', `tel:${normalizePhoneForTel(phone2)}`);
    });

    document.querySelectorAll('[data-phone-link=\"1\"]').forEach((a) => {
      a.setAttribute('href', `tel:${normalizePhoneForTel(phone1)}`);
    });

    document.querySelectorAll('[data-phone-link=\"2\"]').forEach((a) => {
      a.setAttribute('href', `tel:${normalizePhoneForTel(phone2)}`);
    });

    document.querySelectorAll('.address-text').forEach((el) => {
      el.textContent = address;
    });

    document.querySelectorAll('.instagram-link').forEach((a) => {
      a.setAttribute('href', insta);
    });

    document.querySelectorAll('.wa-link').forEach((a) => {
      const message = a.getAttribute('data-wa-message') || 'Hola TAPISUR, quiero hacer una consulta.';
      a.setAttribute('href', `https://wa.me/${whatsapp}?text=${encodeURIComponent(message)}`);
    });
  }

  const stored = safeRead();
  const data = { ...defaults, ...stored };
  applyText(data);
  applyLinks(data);
})();
