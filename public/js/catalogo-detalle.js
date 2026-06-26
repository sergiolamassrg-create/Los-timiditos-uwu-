(function () {
  const item = window.__TAPISUR_DETAIL__;
  const whatsapp = window.__TAPISUR_WHATSAPP__ || '5491151103419';
  const form = document.querySelector('[data-detail-form]');
  const materialSelect = document.querySelector('[data-detail-material]');
  const fabricNote = document.querySelector('[data-fabric-note]');
  const budgetButton = document.querySelector('[data-budget-button]');

  if (!item || !form || !budgetButton) return;

  const fabricDescriptions = {
    chenille: 'Tela suave y resistente, ideal para sillones de uso diario por su textura calida y buen cuerpo.',
    pana: 'Textura aterciopelada y confortable, con una presencia visual mas marcada.',
    cuero: 'Terminacion elegante y facil de limpiar, recomendada para un estilo clasico o moderno.',
    cuerina: 'Alternativa practica de mantenimiento simple para espacios de mucho uso.',
    lino: 'Aspecto natural y fresco, ideal para ambientes claros y livianos.',
    boucle: 'Tela con textura rizada y tacto mullido, muy usada en diseños contemporaneos.',
    bouclé: 'Tela con textura rizada y tacto mullido, muy usada en diseños contemporaneos.',
    velvet: 'Acabado suave con brillo sutil, pensado para una terminacion mas sofisticada.',
    default: 'Material personalizable. TAPISUR puede asesorarte segun uso, estilo del ambiente y mantenimiento esperado.'
  };

  function fabricDescription(material) {
    const key = String(material || '').trim().toLowerCase();
    return fabricDescriptions[key] || fabricDescriptions.default;
  }

  function syncFabricNote() {
    if (!fabricNote || !materialSelect) return;
    fabricNote.textContent = fabricDescription(materialSelect.value);
  }

  function buildMessage() {
    const data = new FormData(form);
    const material = data.get('material') || 'A definir';
    const color = data.get('color') || 'A definir';
    const size = data.get('size') || 'Personalizada';

    return [
      'Hola TAPISUR, quiero pedir un presupuesto para un producto personalizado.',
      '',
      'Datos del modelo:',
      `- Nombre: ${item.name}`,
      `- Categoria: ${item.category}`,
      `- Linea / tipo: ${item.subcategory}`,
      `- Descripcion: ${item.description}`,
      '',
      'Opciones seleccionadas:',
      `- Tela / material: ${material}`,
      `- Detalle de tela: ${fabricDescription(material)}`,
      `- Color: ${color}`,
      `- Medida sugerida: ${size}`,
      `- Terminaciones / caracteristicas: ${(item.features || []).join(', ')}`,
      '',
      'Consulta:',
      'Quisiera confirmar disponibilidad de tela y color, medidas finales, tiempo estimado de fabricacion/entrega y precio.',
      '',
      'Gracias.'
    ].join('\n');
  }

  materialSelect?.addEventListener('change', syncFabricNote);

  budgetButton.addEventListener('click', () => {
    const url = `https://wa.me/${whatsapp}?text=${encodeURIComponent(buildMessage())}`;
    window.open(url, '_blank', 'noopener,noreferrer');
  });

  syncFabricNote();
})();
