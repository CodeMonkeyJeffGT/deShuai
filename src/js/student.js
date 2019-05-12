$(function(){
	$('.control-btn').on('click', function(){
		var data = {
			"grade": $('#control-grade').val(),
			"major": $('#control-major').val(),
			"class": $('#control-class').val(),
			"zzmm": $('#control-zzmm').val(),
			"sex": $('#control-sex').val(),
			"number": $('#control-number').val(),
			"name": $('#control-name').val(),
			"id": $('#control-id').val(),
			"gradeV": $('#control-grade').html(),
			"majorV": $('#control-major').html(),
			"classV": $('#control-class').html(),
			"zzmmV": $('#control-zzmm').html(),
			"sexV": $('#control-sex').html(),
		};
		var title = (data.grade == '' ? '' : '-' + data.grade.substr(2, 2))
			+ (data.major == '' ? '' : '-' + $('#control-major').html())
			+ (data.class == '' ? '' : '-' + $('#control-class').html().substr($('#control-class').html().length - 9, 2))
			+ (data.zzmm == '' ? '' : '-' + $('#control-zzmm').html())
			+ (data.sex == '' ? '' : '-' + $('#control-sex').html())
			+ (data.number == '' ? '' : '-' + $('#control-number').val())
			+ (data.name == '' ? '' : '-' + $('#control-name').val())
			+ (data.id == '' ? '' : '-' + $('#control-id').val());
		if(title == '')
			title = '-本学院所有学生';
		data.title = title.substr(1);
		$.ajax({
			"url": "/student/start",
			"method": "post",
			"data": data,
			"dataType": "json",
			"success": function(result){
				if(result.code == 1)
				{
					alert(result.message);
					return;
				}
				else if(result.code == 2)
				{
					window.location.reload();
					return;
				}
				result = result.data;
				loadHistory('student', false, result.id);
			},
			"error": function(err){
				console.log(err);
			}
		});
	});
});