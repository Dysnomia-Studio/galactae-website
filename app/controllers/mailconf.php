<?php 
	$uid = htmlentities(htmlspecialchars($_GET['mid']));
	$username = htmlentities(htmlspecialchars($_GET['username']));

	$mongoDB = new MongoInterface();

	$data = $mongoDB->getCondContent('galactae','mailconfirmations',[
		'mailconfirm_uid' => $uid
	]);

	if(count($data) > 0 && isset($data[0])) {
		$data = (array) $data[0];
	}

	$activated = (count($data) > 0 && isset($data['user_name']) && $data['user_name']==$username);

	if($activated) {
		// Activate account
		$mongoDB->removeContent('galactae','mailconfirmations',[
			'_id' => $data['_id']
		]);

		$mongoDB->updateContent('galactae','users',
			['_id' => $data['_id']],
			['$set' => ['activated' => 1]]
		);
	}