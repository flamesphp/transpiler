# Flames Transpiler

Asset transpilation for Flames (SCSS → CSS, and related compilers).

## SCSS

Mesh templates use `{% asset '/assets/foo.scss' %}`, which delegates to `Flames\Transpiler\Scss\Parser`.

### Third-party sources

The SCSS engine bundles vendored dependencies under `ThirdParty/` (SourceSpan, League Uri).

Run once after clone:

```bash
php vendor/flamesphp/transpiler/integrate-third-party.php
```

Optional: place zip files in `vendor/flamesphp/transpiler/bundles/` to avoid downloads.
