<?php

declare(strict_types=1);

namespace abilityspmmp\elc;

final class ConfigManager {

    private static Main $plugin;

    public static function init(Main $plugin): void {
        self::$plugin = $plugin;
    }

    public static function getSetting(string $path, mixed $value = null): mixed {
        return self::$plugin->getConfig()->getNested($path, $value);
    }

    public static function setSettings(string $path, mixed $value = null): void {
        self::$plugin->getConfig()->setNested($path, $value);
    }

    public static function seeSettings(): null {
        return var_dump(self::$plugin->getConfig()->getAll());
    }

}

?>