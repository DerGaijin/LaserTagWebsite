<?php
$scriptDirectory = trim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
$assetPath = $scriptDirectory === '' ? '' : str_repeat('../', substr_count($scriptDirectory, '/') + 1);
?>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Lasertag Verden</title>
<link rel="icon" type="image/png" sizes="32x32" href="<?= $assetPath ?>resources/favicon-32x32.png" />
<link rel="icon" type="image/png" sizes="16x16" href="<?= $assetPath ?>resources/favicon-16x16.png" />
<script>
    window.tailwind = window.tailwind || {};
    window.tailwind.config = {
        corePlugins: { preflight: false },
        theme: {
            extend: {
                keyframes: {
                    rotation: {
                        '0%': { transform: 'rotate(0deg)' },
                        '100%': { transform: 'rotate(360deg)' },
                    },
                    rotationBack: {
                        '0%': { transform: 'rotate(0deg)' },
                        '100%': { transform: 'rotate(-360deg)' },
                    },
                },
            },
        },
    };
</script>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="<?= $assetPath ?>Shared.css" />
<script src="<?= $assetPath ?>Shared.js"></script>
