<?php

namespace abilityspmmp\elc\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

use abilityspmmp\elc\Main;
use abilityspmmp\elc\ability\AbilityFactory;

final class GiveabilityCommand extends Command {

    private Main $pluginMain;

    public function __construct(Main $pluginMain) {
        parent::__construct("giveability", "obten una abilidad mediante su id", "/giveability <id> <amount>");
        $this->pluginMain = $pluginMain;

        $this->setPermission("abilityspmmp_cmd_giveability");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if($sender instanceof Player) {
            if(count($args) <= 1) {
                $sender->sendMessage("Uso correcto: [/giveability <id> <amount>]");
                return;
            }
            $abilityId = $args[0];
            $amount = $args[1];
            $ability = AbilityFactory::get($abilityId);

             if($abilityId === 'all') {
                foreach(AbilityFactory::getAll() as $abilityInstance) {
                    $sender->getInventory()->addItem($abilityInstance->setCount($amount));
                }
                return;
            }
            if(is_null($ability)) {
                $sender->sendMessage('Ability ['. $abilityId. '] no registrada, busque con /ability "id" \n o use /giveability "all" <amount> para obtener todas las abilitys en <amount> unidades');
                return;    
            }

            $sender->getInventory()->addItem($ability->setCount($amount));
            $sender->sendMessage("Ability [". $ability->getAbilityName(). "] Obtenida en <". $amount. "> cantidad!");
        } else {
            $this->pluginMain->getLogger()->info("Este comando solo puede ser usado por una instancia de Player");
        } 
    }

}

?>