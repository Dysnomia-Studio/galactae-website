<?php
	$uid = htmlentities(htmlspecialchars($_GET['mid']));
	$username = htmlentities(htmlspecialchars($_GET['username']));

	$sqlDB = new SQLInterface();

	$data = $sqlDB->getCondContent('mailconfirmations',[
		'mailconfirm_uid' => $uid
	]);

	if(count($data) > 0 && isset($data[0])) {
		$data = (array) $data[0];
	}

	$activated = (count($data) > 0 && isset($data['user_name']) && $data['user_name']==$username);

	if($activated) {
		// Activate account
		$sqlDB->removeContent('mailconfirmations',[
			'mailconfirm_uid' => $data['mailconfirm_uid']
		]);

		$sqlDB->updateContent('users',
			['activated' => 1],
			['user_name' => $data['user_name']]
		);
	}