<html>
<head>
	<title>知派教师端 - 学生列表</title>
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
				$now = '学生列表';
				foreach ($menulist as $element) { ?>
				<div class="menu-element <?=$now==$element['name'] ? ' menu-ele-select' : '' ?>" <?php if($now!=$element['name']){?>onclick="window.location.assign('<?=$element["url"]?>')"<?php }?>>
					<?= $element['name']?>
				</div>
				<?php } ?>
			</div>
			<div class="menu-history">
				<div class="history-content">
				</div>	
			</div>
		</div>
		<div class="operator">
			<div class="operator-control">
				<div class="control-element">
					<label class="control-label">年级</label>
					<div class="control-select">
						<span class="c-s-checkspan" id="control-grade">全部<i></i></span>
						<ul>
							<li value="">全部</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<label class="control-label">专业</label>
					<div class="control-select">
						<span class="c-s-checkspan" id="control-major">全部<i></i></span>
						<ul>
							<li value="">全部</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<label class="control-label">班级</label>
					<div class="control-select">
						<span class="c-s-checkspan" id="control-class">全部<i></i></span>
						<ul>
							<li value="">全部</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<label class="control-label">政治面貌</label>
					<div class="control-select">
						<span class="c-s-checkspan" id="control-zzmm">全部<i></i></span>
						<ul>
							<li value="">全部</li>
							<li value="01">中国党员</li>
							<li value="02">中国预备党员</li>
							<li value="03">共青团员</li>
							<li value="13">群众</li>
							<li value="04">中国国民党革命委员会会</li>
							<li value="05">中国民主同盟盟员</li>
							<li value="06">中国民主建国会会员</li>
							<li value="07">中国民主促进会会员</li>
							<li value="08">中国农工民主党党员</li>
							<li value="09">中国致公党党员</li>
							<li value="10">九三学社社员</li>
							<li value="11">台湾民主自治同盟盟员</li>
							<li value="12">无党派人士</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<label class="control-label">性别</label>
					<div class="control-select">
						<span class="c-s-checkspan" id="control-sex">全部<i></i></span>
						<ul>
							<li value=
							<li value="1">男</li>
							<li value="2">女</li>
							<li value="9">未说明的性别</li>
						</ul>
					</div>
				</div>
				<div class="control-element">
					<label class="control-label">学号</label>
					<input class="control-input" type-"text" id="control-number" />
				</div>
				<div class="control-element">
					<label class="control-label">姓名</label>
					<input class="control-input" type-"text" id="control-name" />
				</div>
				<div class="control-element">
					<label class="control-label">身份证号</label>
					<input class="control-input" type-"text" id="control-id" />
				</div>
				<div class="control-element">
					<div class="control-btn">搜索</div>
				</div>
			</div>
			<!-- ---------------------------------------------------- -->
			<div class="operator-show">
				<div class="operator-show-up">
					<span class="o-s-up-message">正在为您加载...</span>
					<button class="o-s-up-cancle">取消加载</button>
					<button class="o-s-up-print">导出Excel</button>
					<button class="o-s-up-close">删除此记录</button>
				</div>
				<div class="operator-show-down">
					<div class="o-s-d-thead">
						<li>学号</li>
						<li class="shortLi">姓名</li>
						<li class="shortLi">性别</li>
						<li>专业名称</li>
						<li>班级</li>
						<li>当前所在级</li>
						<li class="shortLi">政治面貌</li>
					</div>
					<div class="o-s-d-tbody-container">
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li class="shortLi">男</li>
							<li>计算机科学与技术</li>
							<li>计算机科学与技术02</li>
							<li>2016</li>
							<li class="shortLi">共青团员</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li class="shortLi">男</li>
							<li>计算机科学与技术</li>
							<li>计算机科学与技术02</li>
							<li>2016</li>
							<li class="shortLi">共青团员</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li class="shortLi">男</li>
							<li>计算机科学与技术</li>
							<li>计算机科学与技术02</li>
							<li>2016</li>
							<li class="shortLi">共青团员</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li class="shortLi">男</li>
							<li>计算机科学与技术</li>
							<li>计算机科学与技术02</li>
							<li>2016</li>
							<li class="shortLi">共青团员</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li class="shortLi">男</li>
							<li>计算机科学与技术</li>
							<li>计算机科学与技术02</li>
							<li>2016</li>
							<li class="shortLi">共青团员</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li class="shortLi">男</li>
							<li>计算机科学与技术</li>
							<li>计算机科学与技术02</li>
							<li>2016</li>
							<li class="shortLi">共青团员</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li class="shortLi">男</li>
							<li>计算机科学与技术</li>
							<li>计算机科学与技术02</li>
							<li>2016</li>
							<li class="shortLi">共青团员</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li class="shortLi">男</li>
							<li>计算机科学与技术</li>
							<li>计算机科学与技术02</li>
							<li>2016</li>
							<li class="shortLi">共青团员</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li class="shortLi">男</li>
							<li>计算机科学与技术</li>
							<li>计算机科学与技术02</li>
							<li>2016</li>
							<li class="shortLi">共青团员</li>
						</div>
						<div class="o-s-d-tbody o-s-d-thead">
							<li>2016214111</li>
							<li class="shortLi">小明</li>
							<li class="shortLi">男</li>
							<li>计算机科学与技术</li>
							<li>计算机科学与技术02</li>
							<li>2016</li>
							<li class="shortLi">共青团员</li>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">var type = 'student';</script>
</body>
</html>