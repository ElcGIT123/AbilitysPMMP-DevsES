<?php

declare(strict_types=1);

namespace abilityspmmp\elc\ability;

use pocketmine\player\Player;
use abilityspmmp\elc\ability\AbilityItem;
use abilityspmmp\elc\ConfigManager;

final class AbilityCooldown {

    public int $cooldTime;
    public bool $cooldVar;
    public AbilityItem $ability;

    private array $coolds = [];

    public function __construct(int $cooldTime, AbilityItem $ability) {
        $this->cooldTime = $cooldTime;
        $this->ability = $ability;
    }

    public function addCooldown(Player $player): void {
        $this->coolds[$player->getName()][$this->ability->getAbilityName()] = time() + $this->cooldTime;
    }
    
    public function inCooldown(Player $player): bool {
        $name = $player->getName();
        $abilityName = $this->ability->getAbilityName();

        if(!isset($this->coolds[$name][$abilityName])) {
            return false;
        }

        if(time() >= $this->coolds[$name][$abilityName]) {
            unset($this->coolds[$name][$abilityName]);
            return false;
        }

        $remainingTime = (int) (time() - $this->coolds[$name][$abilityName]);
        $message = ConfigManager::getSetting("in_cooldown_message", "!No puedes usarla pasados {SECONDS}s");
        $finalMessage = str_replace("{SECONDS}", (string)$remainingTime, $message);
        $player->sendPopup($finalMessage);

        return true;
    }

}