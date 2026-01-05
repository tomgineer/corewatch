<?php

    declare(strict_types=1);

    $config = require __DIR__ . '/app/php/config.php';
    require __DIR__ . '/app/php/api_client.php';
    require __DIR__ . '/app/php/helpers.php';
    require __DIR__ . '/app/php/controller.php';

    $urls = $config['api_urls'] ?? [];
    $token = $config['api_token'] ?? '';
    $results = fetch_monitoring_batch($urls, $token);
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts & Styles -->
    <link href="app/assets/fonts/fonts.css" rel="stylesheet">
    <link href="app/css/tailwind.css?v=" rel="stylesheet">

    <title>Server Monitoring</title>
</head>

<body>

    <main class="container mx-auto py-12 lg:py-24 px-4">
        <!--<h1>Server Monitoring</h1>-->

        <?php if (empty($results)): ?>
            <p>No API URLs configured.</p>
        <?php else: ?>
            <?php foreach ($results as $item): ?>
                <?php
                    $response = $item['response'] ?? [];
                    $data = $response['data'] ?? null;
                    $error = $response['error'] ?? null;
                    $status = $response['status'] ?? 0;
                    $raw = $response['raw'] ?? null;
                ?>
                <section>
<!--                    <h2>API </?=esc(($item['index'] + 1))?></h2>
                    <p></?=esc($item['url'])?></p>-->

                    <?php if ($error !== null): ?>
                        <p>API error (status <?=esc($status)?>):
                            <?=esc($error)?>
                        </p>
                    <?php endif; ?>

                    <?php if (is_array($data)): ?>
                        <?php
                            $view = build_display_context($data);
                            $server = $view['server'];
                            $insights = $view['insights'];
                        ?>
                        <?php require __DIR__ . '/display.php'; ?>
                    <?php elseif ($raw !== null): ?>
                        <pre><?=esc($raw)?></pre>
                    <?php else: ?>
                        <p>No data returned.</p>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>

</body>
</html>
