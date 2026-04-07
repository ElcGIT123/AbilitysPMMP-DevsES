<?php

declare(strict_types=1);

namespace abilityspmmp\elc\ability\abilityItems;

use pocketmine\player\Player;
use pocketmine\item\ItemTypeIds;

use abilityspmmp\elc\ability\AbilityItem;
use abilityspmmp\elc\ability\AbilityCooldown;
use abilityspmmp\elc\ability\AbilityEffects;
use abilityspmmp\elc\ability\AbilityThrowing;
use abilityspmmp\elc\ability\AbilitySetting;
use abilityspmmp\elc\Main;
use pocketmine\scheduler\ClosureTask;
use pocketmine\world\particle\AngryVillagerParticle;
use pocketmine\world\sound\BowShootSound;

final class AbilityCoold extends AbilityItem implements AbilityThrowing {

    private AbilityCooldown $cooldManager;

    public function __construct(AbilitySetting $settings) {
        parent::__construct(ItemTypeIds::SNOWBALL, $settings);
        $this->settings = $settings;

        $this->cooldManager = new AbilityCooldown($settings->cooldownTime, $this);
    }

    public static function getAbilityId(): string {
        return "ability_coold";
    }

    public function getCooldownManager(): AbilityCooldown {
        return $this->cooldManager;
    }

    public function sendAbilityEffects(Player $playerVictim) {
        AbilityEffects::sendParticle($playerVictim, 
        $this->settings->particleDensity, $this->settings->particleRange, 
        new AngryVillagerParticle());
        AbilityEffects::sendSounds($playerVictim, new BowShootSound());
    }

    public function use(Player $playerVictim, Player $playerDamager): void {
        $playerVictim->setNoClientPredictions(true);
        Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(
            function() use($playerVictim): void {
                $playerVictim->setNoClientPredictions(false); 
                $playerVictim->sendPopup($this->settings->custom["frized_end_message" ?? "Undefined"]);
        }), 20 * $this->settings->custom["frized_time"] ?? 5);
    }

}

?>