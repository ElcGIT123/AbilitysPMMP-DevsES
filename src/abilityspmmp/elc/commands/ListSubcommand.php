<?php

namespace abilityspmmp\elc\commands;

use abilityspmmp\elc\ability\AbilityManager;
use pocketmine\player\Player;

final class ListSubcommand {

    public string $cmdName = "list";
    public string $cmdDesc = "Obten un listado de todas las abilitys disponibles";

    public function use(Player $player): void {
        $player->sendMessage(AbilityManager::getAllAbilityInfo());
    }

}