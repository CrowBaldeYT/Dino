<?php

declare(strict_types=1);

namespace Dino;

use pocketmine\event\Listener;

use pocketmine\event\player\{
    PlayerJoinEvent, PlayerQuitEvent, PlayerChangeSkinEvent
};

// (!) Dino by xXNiceYT

class EventListener implements Listener {

    // (?) To store skin data
    public static $skin = [];

    public function onJoin(PlayerJoinEvent $e): void {
        // (?) Save player skin to revert to later on.
        $player = $e->getPlayer();
        self::$skin[$player->getName()] = $player->getSkin();
    }

    public function onQuit(PlayerQuitEvent $e): void {
        // (?) Revert to original player skin
        $player = $e->getPlayer();
        unset(self::$skin[$player->getName()]);
    }

    public function onChangeSkin(PlayerChangeSkinEvent $e): void {
        // (?) Set saved skin to new skin since the user changed skins
        $player = $e->getPlayer();
        self::$skin[$player->getName()] = $player->getSkin();
    }

}