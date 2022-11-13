<?php

test('it can generate document', function () {
    $this->artisan('documentor:generate', [
        'path' => [
            __DIR__ . '/Support',
        ],
        '--directory' => __DIR__ . '/temp',
        '--output-file' => 'document.md',
    ])->assertExitCode(0);
});
