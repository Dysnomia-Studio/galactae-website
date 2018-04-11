<?php
if($currentpage == "header") {
	http_response_code(404);
	include_once('errors/404.html');
	die();
}
?>

<!-- JAVASCRIPT INCLUDE -->
<?php if($currentpage!='login' && $currentpage!='portal' && substr($currentpage, -2) != '42' && substr($currentpage, 5) != 'admin') { ?>
<script type="text/javascript" src="https://***REMOVED***/website/js/iconselect/control/iconselect.js"></script>
<script type="text/javascript" src="https://***REMOVED***/website/js/iconselect/iscroll.js"></script>
<script type="text/javascript" src="https://***REMOVED***/website/js/language-list-170203.js"></script>
<?php } ?>