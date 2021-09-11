<?php

namespace MyPlot\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat;

class HelpSubCommand extends SubCommand
{
    public function canUse(CommandSender $sender) {
        return $sender->hasPermission("myplot.command.help");
    }

    /**
     * @return \MyPlot\Commands
     */
    private function getCommandHandler()
    {
        return $this->getPlugin()->getCommand($this->translateString("command.name"));
    }

    public function execute(CommandSender $sender, array $args) {
        if (count($args) === 0) {
            $pageNumber = 1;
        } elseif (is_numeric($args[0])) {
            $pageNumber = (int) array_shift($args);
            if ($pageNumber <= 0) {
                $pageNumber = 1;
            }
        } else {
            return false;
        }

        if ($sender instanceof ConsoleCommandSender) {
            $pageHeight = PHP_INT_MAX;
        } else {
            $pageHeight = 5;
        }

        $commands = [];
        foreach ($this->getCommandHandler()->getCommands() as $command) {
            if ($command->canUse($sender)) {
                $commands[$command->getName()] = $command;
            }
        }
        ksort($commands, SORT_NATURAL | SORT_FLAG_CASE);
        $commands = array_chunk($commands, $pageHeight);
        /** @var SubCommand[][] $commands */

							//////
            $sender->sendMessage("SkyBlock Help");
			$sender->sendMessage("/sb auto - Tìm đảo");
			$sender->sendMessage("/sb claim - Nhận đảo đang đứng");
			$sender->sendMessage("/sb addhelper <player> - Thêm người chơi hỗ trợ đảo");
			$sender->sendMessage("/sb removehelper <player> - Loại người chơi hỗ trợ đảo");
			$sender->sendMessage("/sb home <diachi> - Về đảo");
			$sender->sendMessage("/sb homes - Xem danh sách đảo");
			$sender->sendMessage("/sb info - Xem thông tin đảo đang đứng");
			$sender->sendMessage("/sb give <player> - Cho người khác đảo đang đứng");
			$sender->sendMessage("/sb warp <diachi> - Đến đảo khác");
        return true;
    }
}