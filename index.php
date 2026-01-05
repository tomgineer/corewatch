<?php

    declare(strict_types=1);

    $config = require __DIR__ . '/app/php/config.php';
    require __DIR__ . '/app/php/api_client.php';
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
    <!-- <link href="app/fonts/style.css" rel="stylesheet"> -->
    <link href="app/css/tailwind.css?v=" rel="stylesheet">

    <title>Server Monitoring</title>
</head>

<body>

    <h1>Server Monitoring</h1>

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
                <h2>API <?php echo htmlspecialchars((string) ($item['index'] + 1), ENT_QUOTES, 'UTF-8'); ?></h2>
                <p><?php echo htmlspecialchars((string) $item['url'], ENT_QUOTES, 'UTF-8'); ?></p>

                <?php if ($error !== null): ?>
                    <p>API error (status <?php echo htmlspecialchars((string) $status, ENT_QUOTES, 'UTF-8'); ?>):
                        <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
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
                    <pre><?php echo htmlspecialchars((string) $raw, ENT_QUOTES, 'UTF-8'); ?></pre>
                <?php else: ?>
                    <p>No data returned.</p>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>
