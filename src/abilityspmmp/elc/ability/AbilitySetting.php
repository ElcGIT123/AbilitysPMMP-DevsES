<?php

namespace abilityspmmp\elc\ability;

readonly class AbilitySetting {
    public function __construct(
        public string $name,
        public string $info,
        public array $itemLore,
        public int $cooldownTime,
        public int $particleDensity,
        public float $particleRange,
        public array $custom
    ) {}
}