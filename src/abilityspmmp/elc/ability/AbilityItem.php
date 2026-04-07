<?php

declare(strict_types=1);

namespace abilityspmmp\elc\ability;

use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\player\Player;

abstract class AbilityItem extends Item {

    const ABILITY_TAG = "ability_id";

    protected AbilitySetting $settings;

    protected function __construct(int $itemID, AbilitySetting $settings) {
        parent::__construct(new ItemIdentifier($itemID), $settings->name);
        $this->settings = $settings;

        $this->getNamedTag()->setString("ability_id", $this->getAbilityId());
        $this->setCustomName($settings->name);
        $this->setLore($settings->itemLore);
        $this->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 5));
    }

    abstract public static function getAbilityId(): string;
    abstract public function getCooldownManager(): AbilityCooldown;
    abstract public function sendAbilityEffects(Player $player);

    public function getAbilityName(): string {
        return $this->settings->name;
    }

    public function getAbilityInfo(): string {
        return $this->settings->info;
    }

}