<?php

declare(strict_types=1);
require __DIR__ . '/app/php/bootstrap.php';
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts & Styles -->
    <link href="app/assets/fonts/fonts.css?v=<?=MONITORING_VERSION?>" rel="stylesheet">
    <link href="app/css/tailwind.css?v=<?=MONITORING_VERSION?>" rel="stylesheet">

    <!-- JS -->
    <script src="app/js/monitoring-dist.js?v=<?=MONITORING_VERSION?>" defer></script>

    <title>Server Monitoring</title>
</head>

<body class="min-h-screen flex flex-col">

    <main class="mx-auto py-6 pb-12 lg:py-12 lg:pb-24 px-4 flex-1 min-w-full">

        <?php require __DIR__ . '/options.php'; ?>

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
                    <?php if ($error !== null): ?>
                        <p>API error (status <?= esc($status) ?>):
                            <?= esc($error) ?>
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
                        <pre><?= esc($raw) ?></pre>
                    <?php else: ?>
                        <p>No data returned.</p>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>

    <?php require __DIR__ . '/footer.php'; ?>

</body>

</html>