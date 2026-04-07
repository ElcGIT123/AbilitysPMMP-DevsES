<?php

namespace abilityspmmp\elc\ability\abilityItems;

use abilityspmmp\elc\ability\AbilityItem;
use abilityspmmp\elc\ability\AbilityThrowing;

use abilityspmmp\elc\ability\AbilityCooldown;
use abilityspmmp\elc\ability\AbilitySetting;
use abilityspmmp\elc\ability\AbilityEffects;
use pocketmine\player\Player;
use pocketmine\item\ItemTypeIds;
use pocketmine\world\sound\BowShootSound;
use pocketmine\world\particle\FlameParticle;

final class AbilityBarchaos extends AbilityItem implements AbilityThrowing {

    private AbilityCooldown $cooldManager;

    public function __construct(AbilitySetting $settings) {
        parent::__construct(ItemTypeIds::BLAZE_POWDER, $settings);

        $this->cooldManager = new AbilityCooldown($settings->cooldownTime, $this);
    }

    public static function getAbilityId(): string {
        return "ability_barchaos";
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

    public function use(Player $playerVictim, Player $playerDamager): void {
       $inventory = $playerVictim->getInventory();
       $swapIterations = $this->settings->custom["swap_iterations"] ?? 6;

       for($i = 0; $i <= $swapIterations; $i++) {
            $itemOneIndex = rand(0, 9);
            $itemTwoIndex = rand(0, 9);
            $inventory->swap($itemOneIndex, $itemTwoIndex);
       }
    }

}