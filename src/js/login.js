$(document).ready(function(){
	$(".login-btn").on('click', function(){
		var account = $(".login-input[name='账号']").val();
		var password = $(".login-input[name='密码'").val();
		if(account == ''){
			$(".login-warning").text('请输入账号');
			return;
		}
		if(password == ''){
			$(".login-warning").text('请输入密码');
			return;
		}
		// password = $.md5(password).toUpperCase();
		var data = {
			"account": account,
			"password": password
		};
		$(".login-warning").text('登录中...');
		$(".login-warning").css('color', 'gray');
		$.ajax({
			"url": '/user/login',
			"method": 'post',
			"data": data,
			"dataType": 'json',
			"success": function(result){
				console.log(result);
				$(".login-warning").css('color', 'red');
				$(".login-warning").text(result.message);
				if(result.code == 0){
					window.location.reload();
				}
			},
			"error": function(e){
				console.log(e);
			}
		});
	});

	$('.login-claim').on('click', function(){
		alert('我们会将您的密码加密处理，您不必担心您的密码被泄露');
	});
});