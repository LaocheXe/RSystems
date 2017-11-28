<?php

    /*
		GroupAssigner 1.1
		Author: Borygard
		v-Author: Multivitamin
    */

    $config = array();

    /*
    ******************************
    **** Teamspeak GŁÓWNY Config****
    ******************************
    */
    //Teamspeak Adres IP
    $config['teamspeak']['ip'] = '127.0.0.1';      
    //Teamspeak Query Port
    $config['teamspeak']['queryport'] = '10011';   
    //Teamspeak Server IP
    $config['teamspeak']['serverport'] = '9987';      
    //Teamspeak Login Query
    $config['teamspeak']['loginname'] = 'serveradmin'; 
    //Teamspeak Hasło Query
    $config['teamspeak']['loginpass'] = 'password';              
    //Teamspeak Nick bota 
    $config['teamspeak']['displayname'] = 'Group Assigner';   
    //Limit grup ( 0 = brak limitu)
    $config['teamspeak']['maxgroups'] = 2;
    //Weryfikacja adresu IP true=tak | false=nie
    $config['teamspeak']['ip-verify'] = true;
    //Które grupa nie może korzystać w skryptu
    $config['teamspeak']['groups'] = "2";
    //Only = te grupy mogą korzystać ze skryptu
    //ignore =  te grupy nie mogą korzystać ze skryptu
    $config['teamspeak']['group-mode'] = "ignore";

    /*
        Kopiowanie:
        -----------------------
        
    $config['groups'][] = array(
        'grpid' => '',                  //ID grupy
        'name' => '',                   //Nazwa grupy
        'icon' => '',                   //Ikonka grupy
    );
        
        
    */
    
    //KONFIGURACJA GRUPY
	
    $config['groups'][] = array(
        'grpid' => '6',
        'name' => 'Server Admin',
        'icon' => 'http://www.mpcforum.pl/favicon.ico',
    );
    
    $config['groups'][] = array(
        'grpid' => '7',
        'name' => 'Normal',
        'icon' => 'http://www.mpcforum.pl/favicon.ico',
    );
    
?>