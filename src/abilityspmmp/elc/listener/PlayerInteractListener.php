<?php

namespace abilityspmmp\elc\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;

use abilityspmmp\elc\ability\AbilityManager;
use abilityspmmp\elc\ability\AbilityFactory;
use abilityspmmp\elc\ability\AbilityBoosting;
use abilityspmmp\elc\ability\AbilityItem;
use abilityspmmp\elc\ability\AbilityThrowing;
use abilityspmmp\elc\ConfigManager;

final class PlayerInteractListener implements Listener {

    public function onPlayerInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $itemInHand = $player->getInventory()->getItemInHand();

        if ($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_BLOCK || $event->getAction() === PlayerInteractEvent::LEFT_CLICK_BLOCK) {
            if(AbilityManager::isAbilityItem($itemInHand)){
                $id = $itemInHand->getNamedTag()->getString(AbilityItem::ABILITY_TAG);
                $abstractAbility = AbilityFactory::get($id);
                if($player->isSneaking()) {
                    $player->sendMessage($abstractAbility->getAbilityInfo());
                    return;
                }
                if($abstractAbility instanceof AbilityBoosting){
                    if(!$abstractAbility->getCooldownManager()->inCooldown($player)) {
                        $abstractAbility->use($player);
                        AbilityManager::onUse($player, $abstractAbility);
                        $player->getInventory()->removeItem($itemInHand->setCount(1));
                        return;
                    }
                } else if($abstractAbility instanceof AbilityThrowing && ConfigManager::getSetting("debug_mode") ?? false) {
                    if($player->getServer()->isOp($player->getName())) {
                        $player->sendMessage("DEBUGG MODE");
                        $abstractAbility->use($player, $player);
                        AbilityManager::onUse($player, $abstractAbility);
                    } else {
                        $player->sendPopup(ConfigManager::getSetting("use_trhowable_to_boostable_msg"), "Esta ability es arrojable no boosteable");
                    }
                }
            }
        }

    }

}

?>