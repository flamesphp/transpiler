<?php

declare(strict_types=1);

/**
 * PSR-4 autoloader for vendored third-party sources under ThirdParty/.
 *
 * Maps:
 *   SourceSpan\     -> ThirdParty/SourceSpan/
 *   League\Uri\     -> ThirdParty/League/
 */
(function (): void {
    $thirdPartyRoot = dirname(__DIR__, 2) . '/ThirdParty';

    $prefixes = [
        'SourceSpan\\' => $thirdPartyRoot . '/SourceSpan/',
        'League\\Uri\\' => $thirdPartyRoot . '/League/',
    ];

    spl_autoload_register(static function (string $class) use ($prefixes): void {
        foreach ($prefixes as $prefix => $baseDir) {
            if (!str_starts_with($class, $prefix)) {
                continue;
            }

            $relativeClass = substr($class, strlen($prefix));
            $file = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';

            if (is_file($file)) {
                require $file;
            }

            return;
        }
    });
})();
