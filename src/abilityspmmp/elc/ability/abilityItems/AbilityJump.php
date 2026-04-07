<?php

declare(strict_types=1);

namespace abilityspmmp\elc\ability\abilityItems;

use pocketmine\player\Player;
use pocketmine\item\ItemTypeIds;

use abilityspmmp\elc\ability\AbilityItem;
use abilityspmmp\elc\ability\AbilityBoosting;
use abilityspmmp\elc\ability\AbilityCooldown;
use abilityspmmp\elc\ability\AbilityEffects;
use abilityspmmp\elc\ability\AbilitySetting;

use pocketmine\math\Vector3;
use pocketmine\world\particle\ExplodeParticle;
use pocketmine\world\sound\BowShootSound;

final class AbilityJump extends AbilityItem implements AbilityBoosting {

    private float $power;
    private float $impulse;
    private AbilityCooldown $cooldManager;

    public function __construct(AbilitySetting $settings) {
        parent::__construct(ItemTypeIds::RABBIT_FOOT, $settings);

        $this->power = (float) ($settings->custom["power"] ?? 1.2);
        $this->impulse = (float) ($settings->custom["impulse"] ?? 0.8);
        $this->cooldManager = new AbilityCooldown($settings->cooldownTime, $this);
    }

    public static function getAbilityId(): string {
        return "ability_jump";
    }

    public function getCooldownManager(): AbilityCooldown {
        return $this->cooldManager;
    }

    public function sendAbilityEffects(Player $player) {
        AbilityEffects::sendParticle($player, 
        $this->settings->particleDensity, $this->settings->particleRange, 
        new ExplodeParticle());
        AbilityEffects::sendSounds($player, new BowShootSound());
    }

    public function use(Player $player): void {
        $power = $this->settings->custom["power"] ?? 1.2;
        $impulse = $this->settings->custom["impulse"] ?? 0.8;
        $yaw = $player->getLocation()->getYaw();
        $x = -sin(deg2rad($yaw));
        $z = cos(deg2rad($yaw));

        $player->setMotion(new Vector3($x * $impulse, $power, $z * $impulse));
    }

}

?>