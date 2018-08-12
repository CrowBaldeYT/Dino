<?php

declare(strict_types=1);

namespace Dino;

use pocketmine\plugin\PluginBase;
use pocketmine\entity\Skin;
use pocketmine\utils\TextFormat as C;
use pocketmine\command\{
	Command, CommandSender
};

class Main extends PluginBase{

	public function onEnable(): void{
		foreach(["Dino.png", "Diplo.png", "Robo.png", "geometry.json"] as $file){
			$this->saveResource($file);
		}
	}

	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{
		if($cmd->getName() == "dino"){
			if(count($args) < 1){
				$sender->sendMessage("Usage: /dino <Dino|Diplo|Robo>");
				return false;
			}

			switch($args[0]){
				case "dino":
				case "Dino":
				$this->setSkin($sender, "Dino", ".png", "dino");
				break;
				case "diplo":
				case "Diplo":
				$this->setSkin($sender, "Diplo", ".png", "diplo");
				break;
				case "robo":
				case "Robo":
				$this->setSkin($sender, "Robo", ".png", "dino");
				break;
				default:
				$sender->sendMessage("Usage: /dino <Dino|Diplo|Robo>");
				break;
			}
		}
		return false;
	}

	public function SetSkin($player, string $file, string $ex, string $geo){
		$skin = $player->getSkin();
		$path = $this->getDataFolder() . $file . $ex;
		$img = @imagecreatefrompng($path);
		$skinbytes = "";
		$s = (int)@getimagesize($path)[1];

		for($y = 0; $y < $s; $y++){
			for($x = 0; $x < 64; $x++){
				$colorat = @imagecolorat($img, $x, $y);
				$a = ((~((int)($colorat >> 24))) << 1) & 0xff;
				$r = ($colorat >> 16) & 0xff;
				$g = ($colorat >> 8) & 0xff;
				$b = $colorat & 0xff;
				$skinbytes .= chr($r) . chr($g) . chr($b) . chr($a);
			}
		}
		@imagedestroy($img);

		$player->setSkin(new Skin($skin->getSkinId(), $skinbytes, "", "geometry.rmsp." . $geo, file_get_contents($this->getDataFolder() . "geometry.json")));
		$player->sendSkin();
		$player->sendMessage(C::GREEN . "You have disguise as " . $file);
	}
}