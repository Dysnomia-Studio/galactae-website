<?php
	$mintime = time() - (24*60*60);
	$sqlDB = new SQLInterface();

	// Set password
	if(isset($_POST['password'], 
		$_POST['confpassword'],
		$_POST['pid'],
		$_POST['username'])) {

		$password = htmlentities(htmlspecialchars($_POST['password']));
		$confpassword = htmlentities(htmlspecialchars($_POST['confpassword']));
		$encpassword = Security::hashV1($password);
		$uid = htmlentities(htmlspecialchars($_POST['pid']));
		$username = htmlentities(htmlspecialchars($_POST['username']));
		
		$message = '';

		if(strlen($password)<$config['pass-minsize']) { // Password size
			$message = ERR_TOO_LONG_SHORT_PASS;
		} elseif($password==$confpassword) {
			$data = $sqlDB->getCondContent('recoverpasses',
				['passforgot_uid' => $uid]
			);

			if(count($data) > 0) {
				$data = (array) $data[0];
			}

			if(isset($data['user_name']) && $data['user_name']==$username && $data['passforgot_time'] > $mintime) { 
				// Set db
				$sqlDB->removeContent('recoverpasses',
					['user_id' => $data['user_id']]);

				$sqlDB->updateContent('users',
					['user_passwd' => $encpassword],
					['id' => $data['user_id']]
				);
			} else { // Invalid data
				$pageData['pageName'] = "login.php";
				$message = PASS_INVALID_LINK;
			}
		} else {
			$message = ERR_NOT_SAME_PASSWD;
		}

		if($message=='') {
			$pageData['pageName'] = "login.php";
			$message = PASS_CHANGED.CLICK_LOGIN;
		}
		
	} else {
		$uid = (isset($_GET['pid']))?htmlentities(htmlspecialchars($_GET['pid'])):'';
		$username = (isset($_GET['username']))?htmlentities(htmlspecialchars($_GET['username'])):'';
		
		$data = $sqlDB->getCondContent('recoverpasses',
			['passforgot_uid' => $uid]
		);

		if(count($data) > 0 && isset($data[0])) {
			$data = (array) $data[0];
		}

		if(count($data) == 0 || !isset($data['user_name']) || $data['user_name']!=$username || $data['passforgot_time'] < $mintime) { 
			$pageData['pageName'] = "login.php";
			$message = PASS_INVALID_LINK;
		}
	}