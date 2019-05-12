<html>
<head>
	<title>知派教师端 - 个人信息</title>
</head>
<body>
	<div class="platform">
		<div class="menu">
			<div class="menu-userinfo">
				<div class="userinfo-name"><?=$sentence?>，<?=$name?>老师 <div class="userinfo-img img-<?=$css?>"></div></div>
				<div class="userinfo-college"><?=$college?>学院</div>
			</div>
			<div class="menu-menu">
				<?php 
				$now = '个人信息';
				foreach ($menulist as $element) { ?>
				<div class="menu-element <?=$now==$element['name'] ? ' menu-ele-select' : '' ?>" <?php if($now!=$element['name']){?>onclick="window.location.assign('<?=$element["url"]?>')"<?php }?>>
					<?= $element['name']?>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="operator">
			<div class="operator-control">
				<div class="control-element">
				</div>
				<div class="control-element">
					<label class="control-label">姓名</label>
					<input class="control-input" type-"text" id="control-student" value="<?=$_SESSION['teacher']['name']?>" disabled />
				</div>
				<div class="control-element">
				</div>
				<div class="control-element">
				</div>
				<div class="control-element">
					<label class="control-label">学院</label>
					<input class="control-input" type-"text" id="control-student" value="<?=$_SESSION['teacher']['college']?>学院" disabled />
				</div>
				<div class="control-element">
				</div>
				<div class="control-element">
				</div>
				<div class="control-element">
					<div class="control-btn" id="reload">刷新个人信息</div>
				</div>
				<div class="control-element">
				</div>
				<div class="control-element">
				</div>
				<div class="control-element">
					<div class="control-btn" id="logout">退出登录</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>