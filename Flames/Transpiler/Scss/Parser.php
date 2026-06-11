<?php

declare(strict_types=1);

namespace Flames\Transpiler\Scss;

/**
 * Compiles SCSS files to CSS using the bundled scssphp engine.
 */
final class Parser
{

    /**
     * Compiles $scssPath to CSS when the output is missing or stale.
     *
     * Returns the absolute filesystem path of the generated CSS file.
     */
    public static function parse(string $scssPath, ?string $cssPath = null): string
    {
        $scssPath = self::resolveFilesystemPath($scssPath);
        if (!is_file($scssPath)) {
            throw new \RuntimeException('SCSS file not found: ' . $scssPath);
        }

        $cssPath ??= self::cssPathFor($scssPath);
        $scssMtime = filemtime($scssPath) ?: time();

        if (is_file($cssPath) && (filemtime($cssPath) ?: 0) === $scssMtime) {
            return $cssPath;
        }

        $compiler = new Compiler();
        $compiler->addImportPath(dirname($scssPath));

        $css = $compiler->compileFile($scssPath)->getCss();

        $cssDir = dirname($cssPath);
        if (!is_dir($cssDir)) {
            $mask = umask(0);
            mkdir($cssDir, 0777, true);
            umask($mask);
        }

        if (@file_put_contents($cssPath, $css) === false) {
            throw new \RuntimeException('Unable to write CSS file: ' . $cssPath);
        }

        @touch($cssPath, $scssMtime);

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

    private static function cssPathFor(string $scssPath): string
    {
        if (preg_match('/\.scss$/i', $scssPath) !== 1) {
            throw new \InvalidArgumentException('SCSS path must end with .scss');
        }

        return preg_replace('/\.scss$/i', '.css', $scssPath) ?? $scssPath;
    }

    private static function resolveFilesystemPath(string $path): string
    {
        if ($path === '') {
            throw new \InvalidArgumentException('SCSS path cannot be empty');
        }

        if ($path[0] === '/') {
            return self::resolvePublicPath($path);
        }

        return $path;
    }

}
