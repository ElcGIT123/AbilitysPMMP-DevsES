<?php

declare(strict_types=1);

namespace abilityspmmp\elc;

use pocketmine\plugin\PluginBase;

use abilityspmmp\elc\ability\AbilityFactory;
use abilityspmmp\elc\ability\AbilityManager;
use abilityspmmp\elc\listener\PlayerDamageListener;
use abilityspmmp\elc\listener\PlayerInteractListener;
use abilityspmmp\elc\commands\GiveabilityCommand;
use abilityspmmp\elc\commands\AbilityCommand;

final class Main extends PluginBase {

    private static Main $instance;

    public static function getInstance(): self {
        return self::$instance;
    }

    protected function onEnable(): void {
        $this->getLogger()->info("Cargando instancia de Main");
        self::$instance = $this;
        $this->getLogger()->info("Cargando config.yml...");
        $this->saveDefaultConfig();
        $this->getConfig()->reload();
        ConfigManager::init($this);
        $this->getLogger()->info("Registrando eventos...");
        $this->getServer()->getPluginManager()->registerEvents(new PlayerDamageListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerInteractListener(), $this);
        $this->getLogger()->info("Registrando comandos...");
        $this->getServer()->getCommandMap()->register("abilityspmmp_deves", new GiveabilityCommand($this));
        $this->getServer()->getCommandMap()->register("abilityspmmp_deves", new AbilityCommand($this));
        $this->getLogger()->info("Registrando abilitys...");
        AbilityFactory::registreAllAbility();
        $this->getLogger()->info(AbilityManager::getAllAbilityInfo());
        $this->getLogger()->info("Plugin AbilitysPMMPDevs-ES inicializado correctamente");
    }

}