<section class="px-2 lg:px-4 py-6 lg:py-12 max-w-5xl mx-auto" data-display-wrapper>
    <?php
        $results = is_array($displayResults ?? null) ? $displayResults : [];
    ?>
    <?php if (empty($results)): ?>
        <p>No API URLs configured.</p>
    <?php endif; ?>
    <?php foreach ($results as $item): ?>
        <?php
            $mode = $item['mode'] ?? 'empty';
            $status = (int) ($item['status'] ?? 0);
            $message = $item['message'] ?? null;
            $server = $item['server'] ?? 'Unknown server';
            $insights = is_array($item['insights'] ?? null) ? $item['insights'] : [];
            $raw = $item['raw'] ?? null;
        ?>
        <?php if ($mode === 'error'): ?>
            <p>API error (status <?= esc($status) ?>): <?= esc((string) $message) ?></p>
        <?php elseif ($mode === 'stats'): ?>
            <h2 class="mb-4 ml-2 lg:ml-0">Server: <span class="text-accent"><?= esc((string) $server) ?></span></h2>
            <div class="grid grid-cols-2 md:grid-cols-[repeat(auto-fit,minmax(220px,1fr))] gap-3 mb-12">
                <?php foreach ($insights as $insight): ?>
                    <?php
                        $title = $insight['title'] ?? '';
                        $value = $insight['value'] ?? '';
                        $desc = $insight['desc'] ?? '';
                    ?>
                    <div class="stats bg-base-300">
                        <div class="stat">
                            <div class="stat-title"><?= esc((string) $title) ?></div>
                            <div class="stat-value"><?= esc((string) $value) ?></div>
                            <div class="stat-desc text-wrap"><?= esc((string) $desc) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif ($mode === 'raw' && is_string($raw)): ?>
            <pre><?= esc($raw) ?></pre>
        <?php else: ?>
            <p><?= esc((string) ($message ?? 'No data returned.')) ?></p>
        <?php endif; ?>
    <?php endforeach; ?>
</section>
