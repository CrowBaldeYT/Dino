<?php

declare(strict_types=1);

namespace Dino;

use pocketmine\entity\Skin;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat as C;

use pocketmine\command\{
    Command, CommandSender
};

// (!) Dino by xXNiceYT

class Commands implements Listener {

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
        // (?) Check if command ran is the dino command
        if($cmd->getName() == "dino") {
            if(count($args) < 1) {
                $sender->sendMessage(C::RED . "Usage: /dino [dino/diplo/robo]");
                return false;
            }
            switch(strtolower($args[0])) {
                // (?) Check if the user selected a known type
                case "dino":
                    $this->setSkin($sender, "Dino", ".png", "dino");
                    break;
                case "diplo":
                    $this->setSkin($sender, "Diplo", ".png", "diplo");
                    break;
                case "robo":
                    $this->setSkin($sender, "Robo", ".png", "dino");
                    break;
                case "reset":
                    $sender->setSkin(EventListener::$skin[$sender->getName()]);
                    $sender->sendSkin();
                    $sender->sendMessage(C::GREEN . "Successfully changed skin to normal.");
                    break;
                default:
                    $sender->sendMessage(C::RED . "Usage: /dino [dino/diplo/robo]");
                    break;
            }
        }
        return false;
    }

    // (?) Set the users skin to a dino
    public function setSkin($player, string $file, string $ex, string $geo) {
        $skin = $player->getSkin();
        $path = Main::getMainInstance()->getDataFolder() . $file . $ex;
        $img = @imagecreatefrompng($path);
        $skinbytes = "";
        $s = (int)@getimagesize($path)[1];

        for($y = 0; $y < $s; $y++) {
            for($x = 0; $x < 64; $x++) {
                $colorat = @imagecolorat($img, $x, $y);
                $a = ((~((int)($colorat >> 24))) << 1) & 0xff;
                $r = ($colorat >> 16) & 0xff;
                $g = ($colorat >> 8) & 0xff;
                $b = $colorat & 0xff;
                $skinbytes .= chr($r) . chr($g) . chr($b) . chr($a);
            }
        }

        @imagedestroy($img);

        $player->setSkin(new Skin($skin->getSkinId(), $skinbytes, "", "geometry.rmsp." . $geo, file_get_contents(Main::getMainInstance()->getDataFolder() . "geometry.json")));
        $player->sendSkin();
        $player->sendMessage(C::GREEN . "You have disguise as " . $file);
    }

}