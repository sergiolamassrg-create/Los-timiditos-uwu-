<?php

namespace App\Core;

use PDOException;

class SiteSettings
{
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

    private static ?array $cache = null;

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

    public static function get(string $key, ?string $fallback = null): string
    {
        $settings = self::all();

        return (string) ($settings[$key] ?? $fallback ?? self::DEFAULTS[$key] ?? '');
    }

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
