<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Monitoring App — Verdin Dynamics</title>
    <link rel="stylesheet" href="<?= base_url() ?>css/tailwind.css?v=<?=MONITORING_VERSION?>">
    <link rel="stylesheet" href="<?= base_url() ?>assets/fonts/fonts.css?v=<?=MONITORING_VERSION?>">
    <script src="<?= base_url() ?>js/monitoring-dist.js?v=<?=MONITORING_VERSION?>" defer></script>
</head>

<body class="min-h-screen flex flex-col">
    <header>
        <?= $this->include('nav') ?>
    </header>

    <main class="flex-1">
        <?= $this->include('main') ?>
    </main>

    <footer>
        <?= $this->include('footer') ?>
    </footer>
</body>

</html>