<!DOCTYPE html>
<html>
<head>
	<title>補登時數</title>
</head>
<body>
<form id="post_form" method="POST" action="<?php echo base_url('/Volunteer_card_log/sign').'/'.$id.'/'.$sign_date; ?>">
<h1>請輸入時間</h1>
<br>
<div style="text-align: center;">
<input type="text" name="hour" size="5" style="margin-left: 1px;margin-right: 10px"></input>時<input type="text" name="minute" size="5" style="margin-left: 1px;margin-right: 10px"></input>分<input type="text" name="second" size="5" style="margin-left: 1px;margin-right: 10px"></input>秒
<div>
<br>
<div style="text-align: right;">
	<button type="button" class="btn btn-success btn-flat" onclick="sendFun()">新增</button>
</div>
</form>
</body>
</html>

<script type="text/javascript">
	function sendFun() {
		obj = document.getElementById('post_form');
		obj.submit();
	}
</script>