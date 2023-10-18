<?php
session_start();
require_once("private/controllers/switchpage_controller.php");
$switchpagecontroler = new SwichPageControler();
$switchpagecontroler->SwitchPage();
?>