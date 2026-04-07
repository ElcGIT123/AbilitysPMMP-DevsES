<?php

declare(strict_types=1);

namespace abilityspmmp\elc\ability;

use abilityspmmp\elc\ConfigManager;
use abilityspmmp\elc\ability\AbilitySetting;

final class AbilityFactory {

    private static array $abilitys = [];

    private static function registry(string $id, AbilityItem $ability): void {
        self::$abilitys[$id] = $ability;
    }

    public static function get(string $id): ?AbilityItem {
        return self::$abilitys[$id] ?? null;
    }

    public static function getAll(): array {
        return self::$abilitys;
    }

    public static function getAbilityArray(): array {
        return self::$abilitys;
    }

    public static function loadSettings(string $pathyml): AbilitySetting {
        return new AbilitySetting(
            (string) ConfigManager::getSetting($pathyml.".name", "undefined"),
            (string) ConfigManager::getSetting($pathyml.".info", "undefined"),
            (array) ConfigManager::getSetting($pathyml.".item_lore", ["undefined"]),
            (int) ConfigManager::getSetting($pathyml.".cooldown_time", 1),
            (int) ConfigManager::getSetting($pathyml.".particle_density", 30),
            (float) ConfigManager::getSetting($pathyml.".particle_range", 2.0),
            (array) ConfigManager::getSetting($pathyml.".custom", [])
        );
    }

    public static function registreAllAbility(): void {
        $directory = __DIR__ . "/abilityItems/";
        $abilityNamespace = __NAMESPACE__ . "\\abilityItems\\";
        foreach(glob($directory. "*.php") as $abilityFile) {
            $className = $abilityNamespace . basename($abilityFile, ".php");
                if(class_exists($className)) {
                    $id = $className::getAbilityId();
                self::registry(
                    $id,
                    new $className(self::loadSettings("abilities.".$id))
                );
            } 
        }
    }

}