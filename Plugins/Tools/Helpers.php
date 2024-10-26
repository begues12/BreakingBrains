<?php
namespace Plugins\Tools;

class Helpers
{
    /**
     * Obtiene la URL completa actual, incluyendo el esquema, host y URI.
     *
     * @return string
     */
    public static function getCurrentUrl()
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];
        
        return $scheme . "://" . $host . $uri;
    }

    public static function getBaseUrl()
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        
        return $scheme . "://" . $host;
    }

    /**
     * Genera un hash único.
     *
     * @param int $length Longitud del hash (16 por defecto).
     * @return string
     */
    public static function generateUniqueHash($length = 16)
    {
        return bin2hex(random_bytes($length / 2));
    }

    /**
     * Sanitiza una cadena de texto para evitar inyecciones de HTML y JS.
     *
     * @param string $string Cadena a sanitizar.
     * @return string
     */
    public static function sanitizeString($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Redirecciona a una URL dada.
     *
     * @param string $url URL de destino.
     * @param int $statusCode Código de estado HTTP para la redirección (por defecto 302).
     */
    public static function redirect($url, $statusCode = 302)
    {
        header("Location: $url", true, $statusCode);
        exit();
    }

    /**
     * Formatea una fecha a un formato legible.
     *
     * @param string $date Fecha en formato 'Y-m-d H:i:s'.
     * @param string $format Formato de destino ('d-m-Y H:i' por defecto).
     * @return string
     */
    public static function formatDate($date, $format = 'd-m-Y H:i')
    {
        return date($format, strtotime($date));
    }

    /**
     * Valida una dirección de correo electrónico.
     *
     * @param string $email Correo electrónico a validar.
     * @return bool
     */
    public static function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Obtiene la IP del usuario.
     *
     * @return string
     */
    public static function getUserIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    /**
     * Convierte una cadena de texto a slug (amigable para URL).
     *
     * @param string $string Cadena de texto.
     * @return string
     */
    public static function toSlug($string)
    {
        $string = strtolower(trim($string));
        $string = preg_replace('/[^a-z0-9-]/', '-', $string);
        $string = preg_replace('/-+/', '-', $string);
        return rtrim($string, '-');
    }
}
