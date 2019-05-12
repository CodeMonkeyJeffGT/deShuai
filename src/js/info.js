$(function(){
	$("#reload").on('click', function(){
		$.ajax({
			"url": "/user/reload",
			"method": "post",
			"data": {'reload':true},
			"dataType": 'json',
			"success": function(result){
				if(result.code == 0)
				{
					alert('刷新成功');
				}
				window.location.reload();
			}
		});
	});
	$("#logout").on('click', function(){
		$.ajax({
			"url": "/user/logout",
			"method": "post",
			"data": {'logout':true},
			"dataType": 'json',
			"success": function(result){
				console.log(result);
				window.location.reload();
			},
			"error": function(err){
				console.log(err);
			}
		});
	});
});