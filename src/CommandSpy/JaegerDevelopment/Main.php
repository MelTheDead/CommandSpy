<?php
/*
 *
 *  *
 *  *   Copyright (c) 2022. jaegerness
 *  *
 *  *   Permission is hereby granted, free of charge, to any person obtaining a copy
 *  *   of this software and associated documentation files (the "Software"), to deal
 *  *   in the Software without restriction, including without limitation the rights
 *  *   to use, copy, modify, merge, publish, distribute, sublicense, andor sell
 *  *   copies of the Software, and to permit persons to whom the Software is
 *  *   furnished to do so, subject to the following conditions:
 *  *
 *  *   The above copyright notice and this permission notice shall be included in all
 *  *   copies or substantial portions of the Software.
 *  *
 *  *   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  *   IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  *   FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  *   AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  *   LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  *   OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 *  *   SO
 *
 */

namespace CommandSpy\JaegerDevelopment;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase{

    public $spys = [];

    public function onEnable(){
        @mkdir($this->getDataFolder());
        $this->getLogger()->info("§7--------------------------");
        $this->getLogger()->info("☾    §eCommand§bSpy    ☽");
        $this->getLogger()->info("      §cVersion: §f1");
        $this->getLogger()->info("      §cAuthor: §fjaegerness");
        $this->getLogger()->info("☾    §eCommand§bSpy    ☽");
        $this->getLogger()->info("§7--------------------------");

        $this->cfg = new Config($this->getDataFolder() . "ConsoleLog.yml", Config::YAML, array(
            "Console.Logger" => "true",
        ));
        $this->Events();
    }

    public function Events(){
        $register = $this->getServer()->getPluginManager();
        $register->registerEvents(new EventListener($this), $this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        if(strtolower($command->getName()) == "commandspy" or strtolower($command->getName()) == "cspy") {
            if ($sender instanceof Player){
                if($sender->hasPermission("commandspy.jd.use")) {
                    if (isset($this->spys[$sender->getName()])){
                        $sender->sendMessage("§bSpy-§eMode§8» §aYou are in Spy Mode");
                        $this->spys[$sender->getName()] = $sender;
                        return true;
                    } else {
                        $sender->sendMessage("§bSpy-§eMode§8» §cYou are in Spy Mode");
                        unset($this->spys[$sender->getName()]);
                        return true;
                    }
                } else {
                    $sender->sendMessage("§bSpy-§eMode§8» §cYou are not allowed to use this command!");
                    return true;
                }
            }
        }
        return true;
    }
}
