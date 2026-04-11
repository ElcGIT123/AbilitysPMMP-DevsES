<?php

namespace abilityspmmp\elc\listener;

use abilityspmmp\elc\ability\AbilityBoosting;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\player\Player;

use abilityspmmp\elc\ConfigManager;
use abilityspmmp\elc\ability\AbilityItem;
use abilityspmmp\elc\ability\AbilityManager;
use abilityspmmp\elc\ability\AbilityThrowing;
use abilityspmmp\elc\ability\AbilityFactory;

final class PlayerDamageListener implements Listener {

    public function PlayerDamage(EntityDamageByEntityEvent $event) {
        $victim = $event->getEntity(); 
        $damager = $event->getDamager();

        if($damager instanceof Player && $victim instanceof Player) {
            $itemInHand = $damager->getInventory()->getItemInHand();

            if(AbilityManager::isAbilityItem($itemInHand)) {
                $id = $itemInHand->getNamedTag()->getString(AbilityItem::ABILITY_TAG);
                $abstractAbility = AbilityFactory::get($id);

                if($abstractAbility instanceof AbilityThrowing){                    
                    if(!$abstractAbility->getCooldownManager()->inCooldown($damager)) {
                        $abstractAbility->use($victim, $damager);
                        AbilityManager::onUse($damager, $abstractAbility);
                        $damager->getInventory()->removeItem($abstractAbility->setCount(1));

                        if(ConfigManager::getSetting("announcement_to_victim", true)){
                            $message = ConfigManager::getSetting("announcement_to_victim_msg", "Han usado [{ABILITY_NAME}] contra ti!");
                            $messageFinal = str_replace("{ABILITY_NAME}", $abstractAbility->getAbilityName(), $message);
                            $victim->sendPopup($messageFinal);
                        }
                    }
                } elseif($abstractAbility instanceof AbilityBoosting) {
                    $message = ConfigManager::getSetting("use_boostable_to_throwable_msg", "Esta ability es boosteable no arrojable!");
                }
            }

        }
    }

}

?>