<?php
    require_once __DIR__ . '/app/php/helpers.php';
    $server = $server ?? 'Unknown server';
    $insights = is_array($insights ?? null) ? $insights : [];
?>
<section>
    <h1><?=esc($server)?></h1>

    <div class="grid">
        <?php if (!empty($insights)): ?>
            <?php foreach ($insights as $insight): ?>
                <?php
                    $title = $insight['title'] ?? '';
                    $value = $insight['value'] ?? '';
                    $desc = $insight['desc'] ?? '';
                ?>
                <div class="stats shadow">
                    <div class="stat">
                        <div class="stat-title"><?=esc($title)?></div>
                        <div class="stat-value"><?=esc($value)?></div>
                        <div class="stat-desc"><?=esc($desc)?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No insights returned.</p>
        <?php endif; ?>
    </div>
</section>
