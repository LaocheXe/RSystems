<?php
    session_start();
    
    if (empty($_SESSION['pin'])) {
        require_once('libraries/TeamSpeak3/TeamSpeak3.php');
        require_once('config.php');
        try {
            TeamSpeak3::init();
            $ts3 = TeamSpeak3::factory("serverquery://". $config['teamspeak']['loginname'] .":". $config['teamspeak']['loginpass'] ."@". $config['teamspeak']['ip'] .":". $config['teamspeak']['queryport'] ."/?server_port=". $config['teamspeak']['serverport'] ."&nickname=". urlencode($config['teamspeak']['displayname']) ."");
        } catch(Exception $e) {
            exit();
        };
        $_SESSION['pin'] = generateRandomString();
        $ts3->clientGetByUid($_SESSION['uid'])->poke("KOD: [b][color=blue]". $_SESSION['pin'] ."[/color][/b]");
    }
    
    
    function generateRandomString() {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 4; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return 'MPC.'.$randomString;
    }
?>