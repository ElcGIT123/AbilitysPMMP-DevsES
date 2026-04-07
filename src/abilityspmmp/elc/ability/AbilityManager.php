<?php

declare(strict_types=1);

namespace abilityspmmp\elc\ability;

use pocketmine\item\Item;
use pocketmine\player\Player;
use abilityspmmp\elc\ability\AbilityItem;

final class AbilityManager {

    const ABILITY_TAG = "ability_id";

    public static function isAbilityItem(Item $item): bool {
        return $item->getNamedTag()->getTag(self::ABILITY_TAG) !== null;
    }

    public static function onUse(Player $player, AbilityItem $ability) {
        $ability->sendAbilityEffects($player);
        $ability->getCooldownManager()->addCooldown($player);
    }

    public static function getAllAbilityInfo(?int $limit =  null): string {
        $info = "\n". str_pad(" AbilitysInfo ", 30, "=", STR_PAD_BOTH);
        $i = 0;
        foreach(AbilityFactory::getAll() as $abilityID => $ability) {
            if($limit !== null && $i >= $limit) { break; }
            $separator = str_pad(" [" . $i . "] ", 30, "-", STR_PAD_BOTH);
            $i++;
            $info .= $separator;
            $info .= "\n". " [Name]: ". $ability->getAbilityName();
            $info .= "\n". " [ID]: ". $abilityID. "\n";
        }

        $info .= str_repeat("=", 30). "\n";
        $info .= "\n -------------------------------------------";
        return $info;
    }

}

?>