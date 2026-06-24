<?php

namespace App\Core;

use PDOException;

class SiteAnalytics
{
    public static function trackPageView(string $page): void
    {
        if (self::isAdminRequest() || self::isAssetRequest()) {
            return;
        }

        try {
            $ip = self::clientIp();
            $location = self::locationFromIp($ip);

            Database::connect()->prepare("
                INSERT INTO visitas_sitio (
                    ip_address, pagina, user_agent, pais, region, ciudad, fecha_ingreso
                ) VALUES (
                    :ip_address, :pagina, :user_agent, :pais, :region, :ciudad, NOW()
                )
            ")->execute([
                'ip_address' => $ip,
                'pagina' => $page,
                'user_agent' => substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255),
                'pais' => $location['pais'],
                'region' => $location['region'],
                'ciudad' => $location['ciudad'],
            ]);
        } catch (PDOException $e) {
            error_log('Site analytics track error: ' . $e->getMessage());
        }
    }

    public static function todaySummary(): array
    {
        $summary = [
            'totalViews' => 0,
            'uniqueIps' => 0,
            'repeatedIps' => 0,
            'rows' => [],
        ];

        try {
            $pdo = Database::connect();
            $summary['totalViews'] = (int) $pdo->query("
                SELECT COUNT(*)
                FROM visitas_sitio
                WHERE DATE(fecha_ingreso) = CURDATE()
            ")->fetchColumn();
            $summary['uniqueIps'] = (int) $pdo->query("
                SELECT COUNT(DISTINCT ip_address)
                FROM visitas_sitio
                WHERE DATE(fecha_ingreso) = CURDATE()
            ")->fetchColumn();
            $summary['repeatedIps'] = (int) $pdo->query("
                SELECT COUNT(*)
                FROM (
                    SELECT ip_address
                    FROM visitas_sitio
                    WHERE DATE(fecha_ingreso) = CURDATE()
                    GROUP BY ip_address
                    HAVING COUNT(*) > 1
                ) repeated
            ")->fetchColumn();

            $summary['rows'] = $pdo->query("
                SELECT
                    ip_address,
                    COUNT(*) AS entradas,
                    MIN(fecha_ingreso) AS primera_visita,
                    MAX(fecha_ingreso) AS ultima_visita,
                    COALESCE(NULLIF(ciudad, ''), 'Sin dato') AS ciudad,
                    COALESCE(NULLIF(region, ''), 'Sin dato') AS region,
                    COALESCE(NULLIF(pais, ''), 'Sin dato') AS pais,
                    SUBSTRING_INDEX(GROUP_CONCAT(pagina ORDER BY fecha_ingreso DESC SEPARATOR '||'), '||', 1) AS ultima_pagina
                FROM visitas_sitio
                WHERE DATE(fecha_ingreso) = CURDATE()
                GROUP BY ip_address, ciudad, region, pais
                ORDER BY ultima_visita DESC
                LIMIT 30
            ")->fetchAll();
        } catch (PDOException $e) {
            error_log('Site analytics summary error: ' . $e->getMessage());
        }

        return $summary;
    }

    private static function clientIp(): string
    {
        foreach (['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'REMOTE_ADDR'] as $key) {
            $value = (string) ($_SERVER[$key] ?? '');
            if ($value === '') {
                continue;
            }

            $ip = trim(explode(',', $value)[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }

        return '0.0.0.0';
    }

    private static function locationFromIp(string $ip): array
    {
        if ($ip === '::1' || str_starts_with($ip, '127.') || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return ['pais' => 'Local', 'region' => 'Buenos Aires', 'ciudad' => 'Local'];
        }

        return ['pais' => 'Sin dato', 'region' => 'Sin dato', 'ciudad' => 'Sin dato'];
    }

    private static function isAdminRequest(): bool
    {
        $path = parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH) ?: '';

        return str_contains($path, '/admin');
    }

    private static function isAssetRequest(): bool
    {
        $path = parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH) ?: '';

        return (bool) preg_match('/\.(css|js|png|jpe?g|gif|svg|ico|webp|woff2?)$/i', $path);
    }
}
