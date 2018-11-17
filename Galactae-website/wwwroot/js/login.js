window.addEventListener('load',function() {
	function active(div) {
		document.getElementById(div + '-section').className = 'login-onglet active-onglet';

		if(div == 'forgot-pass') { div = 'login'; }
		document.getElementById(div + '-td').className = 'active';
	}

	function desactive(div) {
		document.getElementById(div + '-section').className = 'login-onglet';

		if(div == 'forgot-pass') { div = 'login'; }
		document.getElementById(div + '-td').className = '';
	}

	document.getElementById('login-button').addEventListener('click', function() {
		desactive('register');
		desactive('forgot-pass');

		active('login');
	});

	function register() {
		desactive('login');
		desactive('forgot-pass');

		active('register');
	}

	document.getElementById('register-button').addEventListener('click', function() {
		register();
	});

	if(window.location.hash == '#register'){
		register();
	}

	document.getElementById('forgot-pass-button').addEventListener('click', function() {
		desactive('login');
		desactive('register');

		active('forgot-pass');
	});

	document.getElementById('rememberMe').addEventListener('change', function() {
		setCookie('rememberMe',document.getElementById('rememberMe').checked, 30);
	});
});