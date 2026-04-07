<?php

namespace abilityspmmp\elc\commands;

use pocketmine\player\Player;

final class HelpSubcommand {

    public string $cmdName = "help";
    public string $cmdDesc = "Obten ayuda sobre el comando /help";

    public function use(Player $player): void {

    }

}