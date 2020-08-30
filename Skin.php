<?php

namespace NutzatvchZ\Skin;

use pocketmine\plugin\PluginBase;

use pocketmine\Player;

use pocketmine\Server;

use pocketmine\event\Listener;

use pocketmine\utlis\Config;

use pocketmine\command\Command;

use pocketmine\command\CommandSender;

use NutzatvchZ\libs\jojoe77777\FormAPI\CustomForm;

class Skin extends PluginBase implements Listener

{

  /**

   * urlskin = https://crafatar.com/skins/uuid

   * url = ttpss://api.mojang.com/users/profiles/minecraft/

   ***/

   public function onEnable (){

    $this->getServer()->getPluginManager ()->registerEvents ($this, $this);

    @mkdir($this->getDataFolder () . "skins");

   }

  public function fetchuuid($input){

   $url = "https://api.mojang.com/users/profiles/minecraft/" . $input;

   $ch = curl_init($url);

   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

   $result = curl_exec($ch);

   var_dump($result);

   curl_close($ch);

   return $result;

  }

  public function fetchskin($uuid, $input){

   $json = json_encode($uuid);

   $url = "https://crafatar.com/skins/" . $json->id;

 curl_setopt($start, CURLOPT_URL, $url);

  curl_setopt($start, CURLOPT_RETURNTRANSFER, 1);

  curl_setopt($start, CURLOPT_SSLVERSION, 3);

  $file_data = curl_exec($start);

  curl_close($start);

  $file_path = $this->getDataFolder () .  "skins/" . $input . ".png";

  $file = fopen($file_path, "w+");

  fputs($file, $file_data);

  fclose($file);

  }

   public function onCommand(CommandSender $p, Command $cmd, string $label, array $args) : bool {

     switch ($cmd->getName()) {

      case "skin":

         if ($p instanceof Player) {

          $this->Form($p);

         }else{

          $p->sendMessage("§cUse comamnd in game only!!");

          return true;

         }

       break;

     }

     return true;

    }

  public function Form(Player $p){

   $form = new CustomForm(function (Player $p, $data){

    if($data === null){

     return true;

    }

    $input = $data[0];

    if($data[0] === null){

     $p->sendMessage($this->getConfig()->get("data-null"));

    }else{

        $this->Mulitly($p, $input);

    }

   });

   $form->setTitle($this->getConfig ()->get("title"));

   $form->addInput($this->getConfig ()->get("input-title"), "Steve");

   $form->sendToPlayer($p);

   return $form;

  }

  public function Mulitly(Player $p, $input){

   if (!file_exists($this->getDataFolder () . "skins/" . $input . ".png")) {

    

    $uuid = $this->fetchuuid($input);

    $this->fetchskin($uuid, $input);

    $json = json_decode($uuid);

    $skin = $player->getSkinn();

    if(!$json->erro === null){

     $skin = $player->getSkin();

$path = $this->getDataFolder () . "skins/" . $input . ".png";

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

$p->setSkin(new Skin($skin->getSkinId(), $skinbytes));

$p->sendSkin();

$p->sendMessage($this->getConfig()->get("success -change"));

$p->sendMessage($this->getConfig()->get("success-change"));

}else{

 $p->sendMessage($this->getConfig->get("not-found-player"));

}

   }

  }

  }
