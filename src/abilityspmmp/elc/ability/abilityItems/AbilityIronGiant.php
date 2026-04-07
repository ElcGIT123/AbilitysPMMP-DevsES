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
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\world\particle\FlameParticle;

final class AbilityIronGiant extends AbilityItem implements AbilityBoosting {

    private AbilityCooldown $cooldManager;

    public function __construct(AbilitySetting $settings) {
        parent::__construct(ItemTypeIds::IRON_INGOT, $settings);

        $this->cooldManager = new AbilityCooldown($settings->cooldownTime, $this);
    }

    public static function getAbilityId(): string {
        return "ability_irongiant";
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
        $effects = [
            "healthboost" => VanillaEffects::HEALTH_BOOST(),
            "slowness" => VanillaEffects::SLOWNESS(),
            "regeneration" => VanillaEffects::REGENERATION(),
        ];
        $configCustom = $this->settings->custom;

        foreach($effects as $yml_key => $effect) {
            $effectDuration = (int) ($configCustom["effect_".$yml_key."_duration"] ?? 7);
            $effectLevel = (int) ($configCustom["effect_".$yml_key."_level" ?? 1]);
            $player->getEffects()->add(new EffectInstance($effect, 20 * $effectDuration, $effectLevel));
        }
    }

}