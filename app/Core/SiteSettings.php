<?php

namespace App\Core;

use PDOException;

/**
 * SiteSettings
 *
 * Gestiona la configuración dinámica del sitio almacenada en la tabla
 * `contenidos_sitio` de la base de datos. Provee valores por defecto
 * hardcodeados como fallback y cachea los resultados en memoria
 * para evitar consultas repetidas durante un mismo request.
 *
 * Uso típico:
 *   $all = SiteSettings::all();           // Todos los settings
 *   $phone = SiteSettings::get('phone_1'); // Un valor específico
 *   $wa = SiteSettings::normalizeWhatsapp('1151103419'); // Normalizar número
 */
class SiteSettings
{
    /**
     * Valores por defecto del sitio.
     * Se usan como fallback si la base de datos no está disponible
     * o si una clave no existe en la tabla contenidos_sitio.
     */
    private const DEFAULTS = [
        'site_name' => 'Tapisur',
        'contact_email' => 'sergio_lamas_93@hotmail.com',
        'phone_1' => '11 5110-3419',
        'phone_2' => '11 6767-5200',
        'whatsapp_number' => '5491151103419',
        'instagram_url' => 'https://www.instagram.com/tapisur_/',
        'address' => 'Juan Esteban Pedernera 1462, Lanus Este, Buenos Aires',
        'business_hours_weekdays' => 'Lunes a Viernes 9:00 a 18:00 hs',
        'business_hours_saturday' => 'Sabados 9:00 a 13:00 hs',
        'timezone' => 'America/Argentina/Buenos_Aires',
        'meta_title' => 'Tapisur | Sillones y muebles a medida',
        'meta_description' => 'Tapisur fabrica sillones, muebles a medida, retapizados y restauraciones en Buenos Aires.',
    ];

    /** @var array|null Caché en memoria de los settings cargados. */
    private static ?array $cache = null;

    /**
     * Obtiene todos los settings combinando defaults con valores de la DB.
     *
     * Consulta la tabla `contenidos_sitio` (solo registros públicos)
     * y mergea los resultados sobre los valores por defecto.
     * El resultado se cachea para el request actual.
     *
     * @return array Mapa clave => valor con todos los settings.
     */
    public static function all(): array
    {
        if (self::$cache !== null) {
            return self::$cache;
        }

        $settings = self::DEFAULTS;

        try {
            $stmt = Database::connect()->query("
                SELECT clave, valor
                FROM contenidos_sitio
                WHERE publico = 1
            ");

            foreach ($stmt->fetchAll() as $row) {
                $key = (string) ($row['clave'] ?? '');
                if ($key !== '') {
                    $settings[$key] = (string) ($row['valor'] ?? '');
                }
            }
        } catch (PDOException $e) {
            error_log('Site settings load error: ' . $e->getMessage());
        }

        self::$cache = $settings;

        return self::$cache;
    }

    /**
     * Obtiene el valor de un setting específico.
     *
     * @param string      $key      Clave del setting (ej: 'phone_1', 'whatsapp_number').
     * @param string|null $fallback Valor de fallback si la clave no existe.
     *
     * @return string Valor del setting o string vacío si no se encuentra.
     */
    public static function get(string $key, ?string $fallback = null): string
    {
        $settings = self::all();

        return (string) ($settings[$key] ?? $fallback ?? self::DEFAULTS[$key] ?? '');
    }

    /**
     * Normaliza un número de teléfono al formato de WhatsApp (549XXXXXXXXXX).
     *
     * Reglas de normalización:
     *  - Si ya empieza con "549": se devuelve tal cual.
     *  - Si empieza con "54": se inserta "9" después del código de país.
     *  - Si empieza con "11": se antepone "549".
     *  - Cualquier otro caso: se devuelven solo los dígitos.
     *
     * @param string|null $value Número a normalizar. Si es null, usa el setting guardado.
     *
     * @return string Número normalizado para enlaces wa.me (solo dígitos).
     */
    public static function normalizeWhatsapp(?string $value = null): string
    {
        $digits = preg_replace('/\D+/', '', (string) ($value ?? self::get('whatsapp_number')));

        if ($digits === '') {
            return self::DEFAULTS['whatsapp_number'];
        }

        if (str_starts_with($digits, '549')) {
            return $digits;
        }

        if (str_starts_with($digits, '54')) {
            return '549' . substr($digits, 2);
        }

        if (str_starts_with($digits, '11')) {
            return '549' . $digits;
        }

        return $digits;
    }

    /**
     * Normaliza un número de teléfono al formato internacional (+54XXXXXXXXXX).
     *
     * Usado para generar enlaces tel: válidos.
     *
     * @param string|null $value Número a normalizar.
     *
     * @return string Número con prefijo +54 o string vacío si no hay dígitos.
     */
    public static function normalizeTel(?string $value = null): string
    {
        $digits = preg_replace('/\D+/', '', (string) $value);

        if ($digits === '') {
            return '';
        }

        if (str_starts_with($digits, '54')) {
            return '+' . $digits;
        }

        return '+54' . $digits;
    }
}
