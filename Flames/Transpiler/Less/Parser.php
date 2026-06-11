<?php

declare(strict_types=1);

namespace Flames\Transpiler\Less;

/**
 * Compiles LESS files to CSS using the bundled wikimedia/less.php engine.
 */
final class Parser
{
    private static bool $booted = false;

    /**
     * Compiles $lessPath to CSS when the output is missing or stale.
     *
     * Returns the absolute filesystem path of the generated CSS file.
     */
    public static function parse(string $lessPath, ?string $cssPath = null): string
    {
        self::boot();

        $lessPath = self::resolveFilesystemPath($lessPath);
        if (!is_file($lessPath)) {
            throw new \RuntimeException('LESS file not found: ' . $lessPath);
        }

        $cssPath ??= self::cssPathFor($lessPath);
        $lessMtime = filemtime($lessPath) ?: time();

        if (is_file($cssPath) && (filemtime($cssPath) ?: 0) === $lessMtime) {
            return $cssPath;
        }

        $lessDir = dirname($lessPath);
        $parser = new \Less_Parser([
            'compress' => false,
            'relativeUrls' => true,
        ]);
        $parser->SetImportDirs([$lessDir => $lessDir]);
        $parser->parseFile($lessPath, $lessDir);

        $css = $parser->getCss();

        $cssDir = dirname($cssPath);
        if (!is_dir($cssDir)) {
            $mask = umask(0);
            mkdir($cssDir, 0777, true);
            umask($mask);
        }

        if (@file_put_contents($cssPath, $css) === false) {
            throw new \RuntimeException('Unable to write CSS file: ' . $cssPath);
        }

        @touch($cssPath, $lessMtime);

        return $cssPath;
    }

    public static function resolvePublicPath(string $webPath): string
    {
        $webPath = '/' . ltrim(str_replace('\\', '/', $webPath), '/');

        return rtrim(ROOT_PATH, '/') . '/public' . $webPath;
    }

    public static function toWebPath(string $filesystemPath): string
    {
        $publicRoot = realpath(ROOT_PATH . 'public') ?: (rtrim(ROOT_PATH, '/') . '/public');
        $resolved = realpath($filesystemPath) ?: $filesystemPath;

        $publicRoot = str_replace('\\', '/', $publicRoot);
        $resolved = str_replace('\\', '/', $resolved);

        if (str_starts_with($resolved, $publicRoot)) {
            $webPath = substr($resolved, strlen($publicRoot));

            return $webPath === '' ? '/' : $webPath;
        }

        return $filesystemPath;
    }

    private static function cssPathFor(string $lessPath): string
    {
        if (preg_match('/\.less$/i', $lessPath) !== 1) {
            throw new \InvalidArgumentException('LESS path must end with .less');
        }

        return preg_replace('/\.less$/i', '.css', $lessPath) ?? $lessPath;
    }

    private static function resolveFilesystemPath(string $path): string
    {
        if ($path === '') {
            throw new \InvalidArgumentException('LESS path cannot be empty');
        }

        if ($path[0] === '/') {
            return self::resolvePublicPath($path);
        }

        return $path;
    }

    private static function boot(): void
    {
        if (self::$booted) {
            return;
        }

        require_once __DIR__ . '/Lib/Autoloader.php';
        \Less_Autoloader::register();
        self::$booted = true;
    }
}
