<?php
    require_once __DIR__ . '/app/php/helpers.php';
    $server = $server ?? 'Unknown server';
    $insights = is_array($insights ?? null) ? $insights : [];
?>

<div class="max-w-5xl mx-auto" data-display-wrapper>
    <h1 class="mb-4">Server: <span class="text-accent"><?=esc($server)?></span></h1>

    <div class="grid grid-cols-[repeat(auto-fit,minmax(220px,1fr))] gap-2 mb-12">
        <?php if (!empty($insights)): ?>
            <?php foreach ($insights as $insight): ?>
                <?php
                    $title = $insight['title'] ?? '';
                    $value = $insight['value'] ?? '';
                    $desc = $insight['desc'] ?? '';
                ?>
                <div class="stats lg:shadow-[0_20px_50px_-10px_rgba(0,0,0,0.6)] bg-base-200">
                    <div class="stat">
                        <div class="stat-title text-sm"><?=esc($title)?></div>
                        <div class="stat-value"><?=esc($value)?></div>
                        <div class="stat-desc"><?=esc($desc)?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No insights returned.</p>
        <?php endif; ?>
    </div>
</div>
