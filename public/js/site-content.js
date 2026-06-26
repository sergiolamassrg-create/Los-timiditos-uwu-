/**
 * site-content.js
 *
 * IIFE que aplica contenido dinámico al DOM del sitio público.
 * Combina los valores por defecto (window.TAPISUR_SITE_DEFAULTS) con
 * posibles overrides guardados en localStorage (desde el panel admin).
 *
 * Responsabilidades:
 *  - Leer overrides de contenido desde localStorage.
 *  - Aplicar textos a elementos con atributo [data-content].
 *  - Actualizar links de teléfono, WhatsApp e Instagram.
 *  - Normalizar números de teléfono a formato internacional.
 *
 * Dependencias: site-defaults.js (debe cargarse antes).
 */
(function () {
  const defaults = window.TAPISUR_SITE_DEFAULTS || {};
  const storageKey = window.TAPISUR_STORAGE_KEY || 'tapisur_admin_content_v1';

  /**
   * Lee de forma segura los overrides de contenido desde localStorage.
   * Retorna objeto vacío si no hay datos o si el JSON es inválido.
   *
   * @returns {Object} Mapa clave-valor con overrides de contenido.
   */
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

  /**
   * Extrae solo los dígitos de un string.
   *
   * @param {string|*} value - Valor a limpiar.
   * @returns {string} Solo dígitos numéricos.
   */
  function digitsOnly(value) {
    return String(value || '').replace(/\D+/g, '');
  }

  /**
   * Normaliza un número de teléfono al formato +54XXXXXXXXXX para enlaces tel:.
   *
   * @param {string|*} value - Número de teléfono a normalizar.
   * @returns {string} Número con prefijo +54 o vacío si no hay dígitos.
   */
  function normalizePhoneForTel(value) {
    const digits = digitsOnly(value);
    if (!digits) return '';
    if (digits.startsWith('54')) return `+${digits}`;
    if (digits.startsWith('0')) return `+54${digits.slice(1)}`;
    return `+54${digits}`;
  }

  /**
   * Normaliza un número al formato WhatsApp (549XXXXXXXXXX).
   *
   * @param {string|*} value - Número a normalizar.
   * @returns {string} Número listo para usar en enlaces wa.me.
   */
  function normalizeWhatsapp(value) {
    const digits = digitsOnly(value);
    if (!digits) return defaults.whatsapp_number || '5491151103419';
    if (digits.startsWith('549')) return digits;
    if (digits.startsWith('54')) return `9${digits}`;
    if (digits.startsWith('11')) return `549${digits}`;
    return digits;
  }

  /**
   * Aplica valores de texto a elementos del DOM con atributo [data-content].
   * Busca todos los nodos con data-content="clave" y les asigna el valor correspondiente.
   *
   * @param {Object} data - Mapa clave-valor con contenido a aplicar.
   */
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

  /**
   * Actualiza links de contacto en el DOM (teléfonos, WhatsApp, Instagram, dirección).
   * Busca elementos por clases específicas (.phone1-link, .wa-link, etc.)
   * y actualiza tanto el texto visible como los atributos href.
   *
   * @param {Object} data - Mapa con valores de contacto a aplicar.
   */
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
