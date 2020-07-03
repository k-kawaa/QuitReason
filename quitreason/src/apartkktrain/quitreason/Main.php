<?php

namespace apartkktrain\quitreason;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Main extends PluginBase implements Listener
{

  private $config;

    public function onEnable()
    {
        $this->getLogger()->notice("----------------------");
        $this->getLogger()->notice("quitplugin構築完了 BY APARTKKTRAIN。");
        $this->getLogger()->notice("----------------------");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

                $this->config = new Config($this->getDataFolder() . "quitmessage.yml", Config::YAML, array(
            "通常退室" => "§6[§b退室§6]§a %name が自らの意思で退室しました。",
            "タイムアウト" => "§6[§b退室§6]§a $%ame がタイムアウトにより退室しました。",
            "サーバーエラー" => "§6[§b退室§6]§a %name がサーバーエラーにより退室しました。\n§4サーバー管理者又は開発者まで報告をお願いします。",
            ));

    }

    public function onquit(PlayerQuitEvent $event)
    {
    	$reason = $event->getQuitReason();
    	$player = $event->getPlayer();
    	$name   = $event->getPlayer()->getName();

         ///取得
        $quit1 = $this->config->get("通常退室") ;
        $quit2 = $this->config->get("タイムアウト");
        $quit3 = $this->config->get("サーバーエラー");
        ///変数の置き換え
        $quit1 = str_replace("%name", $name, $quit1);
        $quit2 = str_replace("%name", $name, $quit2);
        $quit3 = str_replace("%name", $name, $quit3);
    	if ($reason === 'client disconnect') {
    		$event->setQuitMessage($quit1);
    		return true;

    	}
    	if ($reason === 'timeout') {
    		$event->setQuitMessage("§6[§b退室§6]§a $name がタイムアウトにより退室しました。");
    		return true;
    	}
    	if ($reason === 'Internal server error') {
    		$event->setQuitMessage("§6[§b退室§6]§a $name がサーバーエラーにより退室しました。\n§4サーバー管理者又は開発者まで報告をお願いします。");
    		return true;
    	}
    }
}
