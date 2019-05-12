$(function(){
	$('#control-showWay').val(1);
	$('.control-btn').on('click', function(){
		var data = {
			"grade": $('#control-grade').val(),
			"major": $('#control-major').val(),
			"class": $('#control-class').val(),
			"term": $('#control-term').val(),
			"type": $('#control-type').val(),
			"lesson": $('#control-lesson').val(),
			"student": $('#control-student').val(),
			"showWay": $('#control-showWay').val(),
			"gradeV": $('#control-grade').html(),
			"majorV": $('#control-major').html(),
			"classV": $('#control-class').html(),
			"termV": $('#control-term').html(),
			"typeV": $('#control-type').html(),
			"showWayV": $('#control-showWay').html(),
		};
		var title = (data.grade == '' ? '' : '-' + data.grade.substr(2, 2))
			+ (data.major == '' ? '' : '-' + $('#control-major').html())
			+ (data.class == '' ? '' : $('#control-class').html().substr($('#control-class').html().length - 9, 2))
			+ (data.term == '' ? '' : '-' + $('#control-term').html().substr(2, 2) + ($('#control-term').html().substr(10) == '1' ? '上' : '下'))
			+ (data.type == '' ? '' : '-' + $('#control-type').html())
			+ (data.lesson == '' ? '' : '-' + $('#control-lesson').val())
			+ (data.student == '' ? '' : '-' + $('#control-student').val());
		console.log(data.grade == '' ? '' : '-' + data.grade.substr(2, 2))
		console.log(title);
		if(title == '')
			title = '-本学院全部成绩';
		title += '-' + $('#control-showWay').html().substr(2, 2);
		data.title = title.substr(1);
		$.ajax({
			"url": "/score/start",
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
				loadHistory('score', false, result.id);
			},
			"error": function(err){
				console.log(err);
			}
		});
	});
	
});