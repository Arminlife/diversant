<!-- check server dir to use in .httpwd -->

<?php

echo '<pre>';
echo "ABSPATH: " . ABSPATH . "\n";
echo "DOCUMENT_ROOT: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "getcwd(): " . getcwd() . "\n";
echo "realpath('.'): " . realpath('.') . "\n";
echo "Template Directory: " . get_template_directory() . "\n";
echo "WP_CONTENT_DIR: " . WP_CONTENT_DIR . "\n";
echo "__DIR__: " . __DIR__ . "\n";
echo "Upload Dir: " . wp_upload_dir()['basedir'] . "\n";
echo '</pre>';