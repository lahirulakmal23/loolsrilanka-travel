<?php
// Run from the WordPress root with the site's configured PHP CLI.
// This tool creates optional WebP sidecars; originals and DB records stay intact.
if ( PHP_SAPI !== 'cli' ) {
    http_response_code(403);
    exit;
}
require dirname(__DIR__, 4) . '/wp-load.php';
if ( ! wp_image_editor_supports(array('mime_type' => 'image/webp')) ) {
    fwrite(STDERR, "WebP encoding is unavailable.\n");
    exit(1);
}
$base = wp_get_upload_dir()['basedir'];
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS));
$created = 0;
$before = 0;
$after = 0;
foreach ($files as $file) {
    if (!$file->isFile() || !preg_match('/\.(?:jpe?g|png)$/i', $file->getFilename())) continue;
    $source = $file->getPathname();
    $result = ls_generate_webp_copy($source);
    if ($result) {
        $created++;
        $before += filesize($source);
        $after += filesize($result);
        if (0 === $created % 50) echo 'Optimized ', $created, " images\n";
    }
}
echo json_encode(array('optimized' => $created, 'original_bytes' => $before, 'webp_bytes' => $after, 'saved_bytes' => $before - $after)), PHP_EOL;