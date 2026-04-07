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

use pocketmine\math\Vector3;
use pocketmine\world\particle\AngryVillagerParticle;
use pocketmine\world\sound\BowShootSound;

final class AbilityKickStick extends AbilityItem implements AbilityThrowing {

    private AbilityCooldown $cooldManager;
    private float $power;
    private float $impulse;

    public function __construct(AbilitySetting $settings) {
        parent::__construct(ItemTypeIds::STICK, $settings);
        $this->settings = $settings;

        $this->power = (float) ($settings->custom["power"] ?? 1.2);
        $this->impulse = (float) ($settings->custom["impulse"] ?? 0.8);
        $this->cooldManager = new AbilityCooldown($settings->cooldownTime, $this);
    }

    public static function getAbilityId(): string {
        return "ability_kickstick";
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
        $damagerDir = $playerDamager->getDirectionVector();

        $playerVictim->setMotion(new Vector3($damagerDir->x * $this->power, $this->impulse, $damagerDir->z * $this->impulse));
    }

}

?>