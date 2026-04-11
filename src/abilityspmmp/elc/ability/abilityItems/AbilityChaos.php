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

final class AbilityChaos extends AbilityItem implements AbilityBoosting {

    private AbilityCooldown $cooldManager;

    public function __construct(AbilitySetting $settings) {
        parent::__construct(ItemTypeIds::BLEACH, $settings);

        $this->cooldManager = new AbilityCooldown($settings->cooldownTime, $this);
    }

    public static function getAbilityId(): string {
        return "ability_chaos";
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
        
        $player->sendMessage("Ability Testing Passed");
    }

}