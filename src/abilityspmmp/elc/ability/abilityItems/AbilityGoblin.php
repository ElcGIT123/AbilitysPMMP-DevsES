<?php

namespace abilityspmmp\elc\ability\abilityItems;

use abilityspmmp\elc\ability\AbilityItem;
use abilityspmmp\elc\ability\AbilityBoosting;

use abilityspmmp\elc\ability\AbilityCooldown;
use abilityspmmp\elc\ability\AbilitySetting;
use abilityspmmp\elc\ability\AbilityEffects;

use pocketmine\player\Player;
use pocketmine\item\ItemTypeIds;
use pocketmine\world\sound\BowShootSound;
use pocketmine\world\particle\FlameParticle;

use abilityspmmp\elc\Main;
use pocketmine\scheduler\ClosureTask;

final class AbilityGoblin extends AbilityItem implements AbilityBoosting {

    private AbilityCooldown $cooldManager;

    public function __construct(AbilitySetting $settings) {
        parent::__construct(ItemTypeIds::GOLD_INGOT, $settings);

        $this->cooldManager = new AbilityCooldown($settings->cooldownTime, $this);
    }

    public static function getAbilityId(): string {
        return "ability_goblin";
    }

    public function getCooldownManager(): AbilityCooldown {
        return $this->cooldManager;
    }

    public function sendAbilityEffects(Player $player) {
        AbilityEffects::sendParticle($player, 
        $this->settings->particleDensity, $this->settings->particleRange, 
        new FlameParticle());
        AbilityEffects::sendSounds($player, new BowShootSound());
    }

    public function use(Player $player): void {
        $customSettings = $this->settings->custom;
        $scale = (float) ($customSettings["goblin_scale"] ?? 0.5);
        $effect_duration = (int) ($customSettings["effects_duration"] ?? 5);

        $player->setScale($scale);

        Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(
            function() use($player): void {
                $player->setScale(1.0);
        }), 20 * $effect_duration);
    }

}