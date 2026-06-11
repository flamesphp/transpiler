<?php

declare(strict_types=1);

/**
 * Bundles third-party sources required by the SCSS compiler into Transpiler/ThirdParty/.
 *
 * Place zip files in vendor/flamesphp/transpiler/bundles/ (optional, avoids download):
 *   source-span.zip            -> https://github.com/scssphp/source-span/archive/refs/heads/main.zip
 *   league-uri.zip             -> https://github.com/thephpleague/uri/archive/refs/tags/7.6.0.zip
 *   league-uri-interfaces.zip  -> https://github.com/thephpleague/uri-interfaces/archive/refs/tags/7.6.0.zip
 *
 * Run once:
 *   php vendor/flamesphp/transpiler/integrate-third-party.php
 */

$transpilerRoot = __DIR__;
$cacheDir = dirname($transpilerRoot, 2) . '/.cache/vendor-bundles';
$bundlesDir = $transpilerRoot . '/bundles';
$thirdParty = $transpilerRoot . '/ThirdParty';

$sources = [
    'source-span' => [
        'url' => 'https://github.com/scssphp/source-span/archive/refs/heads/main.zip',
        'local' => $bundlesDir . '/source-span.zip',
        'target' => $thirdParty . '/SourceSpan',
        'copy' => static function (string $extractRoot) use ($thirdParty): void {
            copyTree($extractRoot . '/src', $thirdParty . '/SourceSpan');
        },
    ],
];

$leaguePackages = [
    'league-uri' => [
        'url' => 'https://github.com/thephpleague/uri/archive/refs/tags/7.6.0.zip',
        'local' => $bundlesDir . '/league-uri.zip',
    ],
    'league-uri-interfaces' => [
        'url' => 'https://github.com/thephpleague/uri-interfaces/archive/refs/tags/7.6.0.zip',
        'local' => $bundlesDir . '/league-uri-interfaces.zip',
    ],
];

if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0777, true);
}

foreach ($sources as $name => $source) {
    echo "Integrating {$name}...\n";
    integrateSource($name, $source, $cacheDir);
}

echo "Integrating league-uri packages...\n";
rmTree($thirdParty . '/League');
mkdir($thirdParty . '/League', 0777, true);

foreach ($leaguePackages as $name => $package) {
    echo "  {$name}...\n";
    $extractRoot = downloadAndExtract($name, $package, $cacheDir);
    mergePhpTree($extractRoot, $thirdParty . '/League');
}

$count = iterator_count(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($thirdParty . '/League', FilesystemIterator::SKIP_DOTS)));
echo "  -> {$count} files in {$thirdParty}/League\n";

echo "Done.\n";

function integrateSource(string $name, array $source, string $cacheDir): void
{
    $extractRoot = downloadAndExtract($name, $source, $cacheDir);

    rmTree($source['target']);
    ($source['copy'])($extractRoot);

    $count = iterator_count(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source['target'], FilesystemIterator::SKIP_DOTS)));
    echo "  -> {$count} files in {$source['target']}\n";
}

function downloadAndExtract(string $name, array $package, string $cacheDir): string
{
    $zipPath = is_file($package['local']) ? $package['local'] : ($cacheDir . '/' . $name . '.zip');
    $extractPath = $cacheDir . '/' . $name;

    if (!is_file($zipPath)) {
        echo "  downloading {$package['url']}\n";
        $data = @file_get_contents($package['url']);
        if ($data === false) {
            throw new RuntimeException('Failed to download ' . $package['url'] . '. Place ' . basename($package['local']) . ' in transpiler/bundles/ and retry.');
        }
        file_put_contents($zipPath, $data);
    }

    rmTree($extractPath);
    mkdir($extractPath, 0777, true);

    $zip = new ZipArchive();
    if ($zip->open($zipPath) !== true) {
        throw new RuntimeException('Failed to open zip ' . $zipPath);
    }
    $zip->extractTo($extractPath);
    $zip->close();

    return findSingleSubdir($extractPath);
}

function findSingleSubdir(string $path): string
{
    $entries = array_values(array_filter(scandir($path) ?: [], static fn (string $entry): bool => !in_array($entry, ['.', '..'], true)));
    if (count($entries) === 1 && is_dir($path . '/' . $entries[0])) {
        return $path . '/' . $entries[0];
    }

    return $path;
}

function copyTree(string $from, string $to): void
{
    if (!is_dir($from)) {
        throw new RuntimeException('Missing source directory ' . $from);
    }

    mkdir($to, 0777, true);

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($from, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST,
    );

    foreach ($iterator as $item) {
        $target = $to . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
        if ($item->isDir()) {
            if (!is_dir($target)) {
                mkdir($target, 0777, true);
            }
            continue;
        }

        copy($item->getPathname(), $target);
    }
}

function mergePhpTree(string $from, string $to): void
{
    if (!is_dir($from)) {
        throw new RuntimeException('Missing source directory ' . $from);
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($from, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST,
    );

    foreach ($iterator as $item) {
        if (!$item->isFile() || !str_ends_with($item->getFilename(), '.php')) {
            continue;
        }

        $relative = $iterator->getSubPathName();
        $target = $to . DIRECTORY_SEPARATOR . $relative;
        $targetDir = dirname($target);

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        copy($item->getPathname(), $target);
    }
}

function rmTree(string $path): void
{
    if (!is_dir($path)) {
        return;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST,
    );

    foreach ($iterator as $item) {
        if ($item->isDir()) {
            rmdir($item->getPathname());
            continue;
        }

        unlink($item->getPathname());
    }

    rmdir($path);
}
