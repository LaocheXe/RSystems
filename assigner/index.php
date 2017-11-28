<?php
    session_start();
	
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 60)) {
		session_unset();
		session_destroy();
		header("Location: index.php");
	}
	$_SESSION['LAST_ACTIVITY'] = time();
	
    if (!empty($_GET['reset'])) {
        unset($_SESSION);
    };
    
    if (empty($_SESSION['do'])) {
        $_SESSION['do'] = '0';
    }
    
    
    $error = array();
    $continue = true;
    $base = false;
    require_once('libraries/TeamSpeak3/TeamSpeak3.php');
    require_once('config.php');
    
    if (($_SESSION['do'] == 0 and !empty($_POST['uid'])) or ($_SESSION['do'] == 1 and !empty($_SESSION['uid']))) {
        if ((!empty($_SESSION['uid']) and strlen($_SESSION['uid']) == 28 and $_SESSION['uid'][27] == "=") or (strlen($_POST['uid']) == 28 and $_POST['uid'][27] == "=")) {
            $groups = array();
            if (!empty($_POST['uid'])) {
                $_SESSION['uid'] = $_POST['uid'];
				$_SESSION['nick'] = $_POST['nick'];
				$_SESSION['clid'] = $_POST['clid'];
            }
            try {
                TeamSpeak3::init();
                $ts3 = TeamSpeak3::factory("serverquery://". $config['teamspeak']['loginname'] .":". $config['teamspeak']['loginpass'] ."@". $config['teamspeak']['ip'] .":". $config['teamspeak']['queryport'] ."/?server_port=". $config['teamspeak']['serverport'] ."&nickname=". urlencode('(MPC) '.$config['teamspeak']['displayname']) ."");
                $filter = array('client_unique_identifier' => str_replace('/','\/', str_replace('+', '\+', str_replace('-', '\-', str_replace('&', '\&', $_SESSION['uid'])))));
                if ($config['teamspeak']['ip-verify']) {
                    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                        $ip = $_SERVER['HTTP_CLIENT_IP'];
                    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    } else {
                        $ip = $_SERVER['REMOTE_ADDR'];
                    }
                    $filter['connection_client_ip'] = $ip;
                }
                if (count($ts3->clientList($filter)) > 0) {
                    foreach ($ts3->clientList($filter) as $client) {
                        break;
                    }
                } else {
                    unset($_SESSION);
                    $_SESSION['do'] = '0';
                    $error[] = array('type' => 'danger', 'msg' => 'Nie znaleziono uzytkownia!');
                    $continue = false;
                }
                if (strtolower($config['teamspeak']['group-mode']) === 'ignore' and $continue) {
                    $continue = true;
                } else if (strtolower($config['teamspeak']['group-mode']) === 'only' and $continue){
                    $continue = false;
                }
                if (is_object($client) and $continue) {
                    foreach (explode(",", $config['teamspeak']['groups']) as $cgrp) {
                        if (in_array($cgrp, explode(",",$client->client_servergroups)) and strtolower($config['teamspeak']['group-mode']) == 'ignore') {
                            $error[] = array('type' => 'danger', 'msg' => 'Musisz posiadaæ rangê resjetracyjna, ¿eby nadawaæ sobie rangi.');
                            $_SESSION['do'] = '0';
                            $continue = false;
                        } else if (in_array($cgrp, explode(",",$client->client_servergroups)) and strtolower($config['teamspeak']['group-mode']) == 'only') {
                            break;
                        }
                    }
                };
                if ($continue) {
                    foreach  ($config['groups'] as $grp) {
                        try {
                            $groups[$grp['grpid']] = array();
                            if (empty($grp['name']) or $grp['name'] == '') {
                                $groups[$grp['grpid']]['name'] = $ts3->serverGroupGetById($grp['grpid'])->name;
                            } else {
                                $groups[$grp['grpid']]['name'] = $grp['name'];
                            };
                            if (!empty($grp['icon']) and $grp['icon'] != '') {
                                $groups[$grp['grpid']]['icon'] = $grp['icon'];
                            }else{
								if(!file_exists('style/icons/icon_'.$grp['grpid']))
								{
									$groups[$grp['grpid']]['icon'] = $ts3->serverGroupGetById($grp['grpid'])->iconDownload();
									file_put_contents('style/icons/icon_'.$grp['grpid'], $groups[$grp['grpid']]['icon']);
								}
							};
                        } catch(Exception $e) {
                            $error[] = array('type' => 'danger', 'msg' => 'Error: '. $e->getCode() . ": " . $e->getMessage());
                        };
                    }
                    $dbid = $client->client_database_id;
                    $clientGroups = explode(',',$client->client_servergroups);
                    $_SESSION['do'] = '1';
                }
            } catch(Exception $e) {
                $error[] = array('type' => 'danger', 'msg' => 'Error: '. $e->getCode() . ": " . $e->getMessage());
            };
        } else {
            $error[] = array('type' => 'danger', 'msg' => 'Error: Wykryto z³y UID!');
        }
    }
    if ($_SESSION['do'] == 1 and (!empty($_POST['assign']))) {
        if ((!empty($_SESSION['verified']) and $_SESSION['verified']) or $_SESSION['pin'] == $_POST['pin']) {
            $assignGroups = array();
            if (!empty($_POST['chbox'])) $assignGroups = $_POST['chbox'];
            $_SESSION['verified'] = true;
            if (!empty($assignGroups) and count($assignGroups) > $config['teamspeak']['maxgroups']) {
                $error[] = array('type' => 'danger', 'msg' => 'Zmieni³eœ za du¿o rang! Limit grup wynosi: '.$config['teamspeak']['maxgroups'].'!');
            } else {
                foreach ($config['groups'] as $grp) {
                    if (in_array($grp['grpid'], $assignGroups) and !in_array($grp['grpid'], $clientGroups)) {
                        $ts3->serverGroupClientAdd($grp['grpid'], $dbid);
                        $clientGroups[] = $grp['grpid'];
                    } else if (!in_array($grp['grpid'], $assignGroups) and in_array($grp['grpid'], $clientGroups)) {
                        $ts3->serverGroupClientDel($grp['grpid'], $dbid);
						unset($clientGroups[array_search($grp['grpid'], $clientGroups)]);
                    }
                }
            }
            $error[] = array('type' => 'success', 'msg' => 'Zmieniono grupy!');
        } else {
            unset($_SESSION['pin']);
            $error[] = array('type' => 'danger', 'msg' => 'Error: Podano z³y kod!');
        }
    }
    
?>
<!DOCTYPE HTML PUBLIC "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<HTML>
<HEAD>
<META HTTP-EQUIV="content-type" CONTENT="text/html; charset=iso-8859-2">
		<title><?php if(!empty($_SESSION['nick'])) {echo $_SESSION['nick'].' - '; }?> Nadawanie Grup</title>
		<!-- Jquery -->
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- Bootstrap -->
		<link href="style/css/bootstrap.min.css" rel="stylesheet">
		<!-- Theme -->
		<link rel="stylesheet" href="style/css/bootstrap-theme.min.css">
		<!-- Custom CSS -->
		 <link href="/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="/dist/css/myboostrap.css" rel="stylesheet">
		<!--<link href="style/css/custom.css" rel="stylesheet">-->
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="style/js/bootstrap.min.js"></script>
	</head>
	<body>
	<div class="container">
	<!-- Error Displaying Starts -->
		<noscript>
			<div class="alert alert-danger" role="alert">Potrzebujsz w³¹czyæ obs³ugê javascript!</div>
        </noscript>
        <?php foreach ($error as $err) { ?>
			<div class="alert alert-<?php echo $err['type']; ?>" role="alert"><?php echo $err['msg']; ?></div>        
       <?php } ?>
    <!-- Error Displaying Ends -->
	<center>
		<div class="row">		
			<div class="panel panel-default">
				<div class="panel-heading" style="color:#2b3e50">
					<?php if ($_SESSION['do'] == 0) {
						echo 'Wybierz swoje konto:';
					}else{
						echo 'Limit grup wynosi: '.$config['teamspeak']['maxgroups'].'';
					}
					?>
				</div>
         <div class="panel-body">
			<?php if ($_SESSION['do'] == 0) {
				$login = false;
						try {
								TeamSpeak3::init();
								$ts3 = TeamSpeak3::factory("serverquery://". $config['teamspeak']['loginname'] .":". $config['teamspeak']['loginpass'] ."@". $config['teamspeak']['ip'] .":". $config['teamspeak']['queryport'] ."/?server_port=". $config['teamspeak']['serverport'] ."&nickname=". urlencode($config['teamspeak']['displayname']) ."");
								$filter = array('client_unique_identifier' => str_replace('/','\/', str_replace('+', '\+', str_replace('-', '\-', str_replace('&', '\&', $_SESSION['uid'])))));
								if ($config['teamspeak']['ip-verify']) {
									if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
									   $ip = $_SERVER['HTTP_CLIENT_IP'];
									} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
									  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
									} else {
									  $ip = $_SERVER['REMOTE_ADDR'];
									}
									  $filter['connection_client_ip'] = $ip;
									}
								foreach($ts3->clientList() as $cld){
									if($cld["connection_client_ip"] == $ip){
										echo 
										' 
										<form action="" method="POST" class="form-inline">
											<div class="form-group">
												<input type="hidden" class="form-control" name="uid" id="uid" value="'.$cld['client_unique_identifier'].'">
												<input type="hidden" class="form-control" name="nick" id="nick" value="'.$cld['client_nickname'].'">
												<input type="hidden" class="form-control" name="clid" id="clid" value="'.$cld['clid'].'">
											</div>
											<button type="submit" class="btn btn-success">'.$cld['client_nickname'].'</button>
										</form> 
									';
									$login = true;
								}
								}
							 } catch(Exception $e) {
										$error[] = array('type' => 'danger', 'msg' => 'Error: '. $e->getCode() . ": " . $e->getMessage());
							 };
							if(!$login)
							{
								echo '<div class="alert alert-danger" role="alert">B³¹d!<br>System nie znalaz³ Ciê na serwerze.</div>';
							}

						?>
                                              
                        <?php }; ?>
                        <?php if ($_SESSION['do'] == 1) { ?>
                            <form action="" method="POST" class="form-horizontal">
                                <b></b>
                                <br/><br/>
                                <div class="col-xs-8">
                                    <center>
									<div class="bs-example" data-example-id="striped-table">
                                        <table class="table">
                                            <?php foreach ($groups as $id => $group) { ?>
                                                <tr>
                                                    <td><input type="checkbox" id="chbox[<?php echo $id; ?>]" name="chbox[]" <?php if (in_array($id, $clientGroups)) echo "checked"; ?> value="<?php echo $id; ?>"></td>
                                                    <td onclick="check(<?php echo $id; ?>)"><?php if (!empty($group['icon'])) { echo "<img src='". $group['icon'] ."' height='16' width='16'></img>"; } ?></td>
                                                    <td onclick="check(<?php echo $id; ?>)"><?php echo $group['name']; ?></td>
                                                </tr>
                                            <?php }; ?>
                                        </table>
									  </div>
                                    </center>
                                </div>
                                <div class="col-xs-2"></div>
                                <br/><br/>
                                <?php if (!empty($_SESSION['verified']) and $_SESSION['verified']) { ?>
                                    <button type="submit" class="btn btn-primary">Nadaj grupy</button>
                                <?php } else { ?>
                                    <a onclick="openconfirmation();" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#setgrps">Kolejny krok</a>
                                <?php }; ?>
                                <div class="modal fade" id="setgrps">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Kod weryfikacyjny:</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                <center>
                                                    <div style="max-width:40%" class="form-group">
                                                        <label for="pin">Wpisz kod:</label>
                                                        <input type="text" class="form-control" id="pin" name="pin">
                                                        <input type="hidden" name="assign" value="1"></input>
                                                    </div>
                                                </center>
                                            </p>
                                        </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Nadaj grupy</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>                    
                        <?php }; ?>
                        </div>
                    </div>
				</div>
        
		</center>
		<div class="row">
			<div class="col-lg-12"> 
				<hr>
							</div>
	</div>
	</div>
    </body>
    <script type="text/javascript">
        function openconfirmation() {
            $.get("confirmation.php");
            return false;
        }
    </script>
    <script>
        function check(id) {
            document.getElementById('chbox['+id+']').checked = !document.getElementById('chbox['+id+']').checked;
        }
    </script>
</html>