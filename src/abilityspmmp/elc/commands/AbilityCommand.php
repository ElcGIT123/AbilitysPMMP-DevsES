<?php

namespace abilityspmmp\elc\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

use abilityspmmp\elc\Main;

final class AbilityCommand extends Command {

    private Main $pluginMain;
    private array $subcmd;

    public function __construct(Main $pluginMain) {
        parent::__construct("ability", "para informacion /ability help", "/giveability <id> <amount>");
        $this->pluginMain = $pluginMain;

        $this->setSubcmd(new HelpSubcommand());
        $this->setSubcmd(new ListSubcommand());
        $this->setSubcmd(new DebugSubcommand());

        $this->setPermission("abilityspmmp_cmd_ability");
    }

    private function setSubcmd($class) {
        $this->subcmd[$class->cmdName] = $class;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if($sender instanceof Player) {
            if(count($args) < 1) {
                $sender->sendMessage("Mira los comandos con /ability help");
                return;
            }

            $subcmd = strtolower($args[0] ?? "help");
            if(isset($this->subcmd[$subcmd])) {
                if(count($args) === 0) {
                    $this->subcmd[$subcmd]->use($sender);
                } else {
                    $this->subcmd[$subcmd]->use($sender, $args);
                }
            } else {
                $sender->sendMessage("argumento [". $subcmd. "] no encontrado.");
            }
           
        } else {
            $this->pluginMain->getLogger()->info("Este comando solo puede ser usado por una instancia de Player");
        } 
    }

}

?>