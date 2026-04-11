<?php

namespace abilityspmmp\elc\commands;

use abilityspmmp\elc\ConfigManager;
use pocketmine\player\Player;

final class DebugSubcommand {

    public string $cmdName = "debug";
    public string $cmdDesc = "Configura el modo Debug para las abilitys, true o false";

    public function use(Player $player, ?array $args = null): void {
        if(!isset($args[1])) {
            $player->sendMessage("Es necesario especificar el estado de DebugMode [on | off]");
            return;
        }
        switch($args[1]) {
            case "off": 
                ConfigManager::setSettings("debug_mode", false); 
                $player->sendMessage("DEBUGG Mode: [off]");
            break;
            case "on": 
                ConfigManager::setSettings("debug_mode", true); 
                $player->sendMessage("DEBUGG Mode: [on]");
            break;
            defualt: 
                $player->sendMessage("Solo es valido ['on'] o ['off']"); 
            break;
        }
    }

}