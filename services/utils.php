<?php

// Fonctions utiles
/**
 * Render une vue
 *
 * @param string $path
 * @param array $variables
 * @return void
 */
function render(string $path, array $variables = []): void {
    extract($variables);

    ob_start();
    require "$path.html.php";
    $pageContent = ob_get_clean();

    require dirname(__DIR__).'/views/layout.html.php';
}