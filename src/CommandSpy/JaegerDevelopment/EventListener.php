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

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessEvent;

class EventListener implements Listener{

    public $plugin;

    public function  __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    public function SpyChat(PlayerCommandPreprocessEvent $event)
    {
        $sender = $event->getPlayer();
        $message = $event->getMessage();
        if ($this->getPlugin()->cfg->get("ConsoleLog.yml") == "true") {
            if ($message[0] == "/") {
                if (stripos($message, "login") || stripos($message, "log") || stripos($message, "reg") || stripos($message, "register")) {
                    $this->getPlugin()->getLogger()->info($sender->getName() . "> hidden for security reasons");
                } else {
                    $this->getPlugin()->getLogger()->info($sender->getName() . "> " . $message);
                }
            }
        }
        if (!empty($this->getPlugin()->spys)) {
            foreach ($this->getPlugin()->spys as $spy) {
                if ($message[0] == "/") {
                    if (stripos($message, "login") || stripos($message, "log") || stripos($message, "reg") || stripos($message, "register")) {
                        $spy->sendMessage("§bSpy-§eMode§8» §a " . $sender->getName() . " did the commando /" . $message);

                    }
                }
            }
        }
    }

    public function getPlugin() {
        return $this->plugin;
    }
}
