<?php

namespace abilityspmmp\elc\ability;

use pocketmine\player\Player;

interface AbilityThrowing {
    public function use(Player $playerVictim, Player $playerDamager): void;
}

?>