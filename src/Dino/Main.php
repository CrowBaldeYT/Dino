<?php

declare(strict_types=1);

namespace Dino;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

// (!) Dino by xXNiceYT

class Main extends PluginBase implements Listener {

    // (!) Instance
    protected static $instance;

	public function onEnable(): void {
	    // (?) Save geometry and skins for each dino
		foreach(["Dino.png", "Diplo.png", "Robo.png", "geometry.json"] as $file) {
			$this->saveResource($file);
		}
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

    public static function getMainInstance(): self {
        // (?) Returns instance
        return self::$instance;
    }

}