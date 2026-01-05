<section class="px-4 py-12 max-w-5xl mx-auto" data-display-wrapper>
    <?php
        $results = is_array($apiResults['apis'] ?? null) ? $apiResults['apis'] : [];
    ?>
    <?php foreach ($results as $item): ?>
        <?php
            $response = is_array($item['response'] ?? null) ? $item['response'] : [];
            $data = is_array($response['data'] ?? null) ? $response['data'] : null;
            $error = $response['error'] ?? null;
            $status = (int) ($response['status'] ?? 0);
            $raw = $response['raw'] ?? null;
        ?>
        <?php if ($error !== null): ?>
            <p>API error (status <?= esc($status) ?>): <?= esc($error) ?></p>
        <?php endif; ?>

        <?php if (is_array($data)): ?>
            <?php
                $payload = is_array($data['data'] ?? null) ? $data['data'] : $data;
                $server = $payload['server'] ?? 'Unknown server';
                $insights = is_array($payload['insights'] ?? null) ? $payload['insights'] : [];
            ?>
            <h2 class="mb-4">Server: <span class="text-accent"><?= esc($server) ?></span></h2>
            <div class="grid grid-cols-[repeat(auto-fit,minmax(220px,1fr))] gap-3 mb-12">
                <?php if (!empty($insights)): ?>
                    <?php foreach ($insights as $insight): ?>
                        <?php
                            $title = $insight['title'] ?? '';
                            $value = $insight['value'] ?? '';
                            $desc = $insight['desc'] ?? '';
                        ?>
                        <div class="stats lg:shadow-[0_20px_50px_-10px_rgba(0,0,0,0.6)] bg-base-200">
                            <div class="stat">
                                <div class="stat-title"><?= esc($title) ?></div>
                                <div class="stat-value"><?= esc($value) ?></div>
                                <div class="stat-desc"><?= esc($desc) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No insights returned.</p>
                <?php endif; ?>
            </div>
        <?php elseif ($raw !== null): ?>
            <pre><?= esc($raw) ?></pre>
        <?php else: ?>
            <p>No data returned.</p>
        <?php endif; ?>
    <?php endforeach; ?>
</section>
