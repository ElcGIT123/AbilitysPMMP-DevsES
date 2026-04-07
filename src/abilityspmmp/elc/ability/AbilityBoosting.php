<?php

namespace abilityspmmp\elc\ability;

use pocketmine\player\Player;

interface AbilityBoosting {
    public function use(Player $player): void; 
}

?>