<?php

namespace abilityspmmp\elc\ability;

use pocketmine\player\Player;
use pocketmine\world\particle\Particle;
use pocketmine\world\sound\Sound;

final class AbilityEffects {

    public static function sendParticle(Player $player, int $count, float $radio, Particle $particle) {
        for($i = 0; $i < $count; $i++) {
            $angle = $i * (2 * pi() / $count);
            $x = $radio * cos($angle);
            $z = $radio * sin($angle);

            $particlePos = $player->getPosition()->add($x, 0.0, $z);
            $player->getWorld()->addParticle($particlePos, $particle);
        }
    }

    public static function sendSounds(Player $player, Sound $sound) {
        $soundWorld = $player->getWorld();
        $soundPos = $player->getPosition();

        $soundWorld->addSound($soundPos, $sound);
    }



}
