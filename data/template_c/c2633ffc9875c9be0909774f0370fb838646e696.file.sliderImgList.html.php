<?php /* Smarty version Smarty-3.1.16, created on 2017-04-26 19:05:10
         compiled from "tpl\admin\sliderImgList.html" */ ?>
<?php /*%%SmartyHeaderCode:1826158a4881e83b1b9-13219272%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c2633ffc9875c9be0909774f0370fb838646e696' => 
    array (
      0 => 'tpl\\admin\\sliderImgList.html',
      1 => 1492740102,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1826158a4881e83b1b9-13219272',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_58a4881e8fe6e7_71798959',
  'variables' => 
  array (
    'data' => 0,
    'value' => 0,
    'classId' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58a4881e8fe6e7_71798959')) {function content_58a4881e8fe6e7_71798959($_smarty_tpl) {?><!doctype html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>后台管理系统</title>
	
	<link rel="stylesheet" href="img/css/layout.css" type="text/css" media="screen" />
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="img/css/ie.css" type="text/css" media="screen" />
	<script src="img/js/html5.js"></script>
	<![endif]-->
	<script src="img/js/jquery1.9.js" type="text/javascript"></script>
	<script src="img/js/hideshow.js" type="text/javascript"></script>
	<script src="img/js/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="img/js/jquery.equalHeight.js"></script>
	<script type="text/javascript" src="img/js/sliderImgUp.js"></script>
	<script type="text/javascript">
	$(document).ready(function() 
    	{ 
      	  $(".tablesorter").tablesorter(); 
   	 } 
	);
	$(document).ready(function() {

	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

});
    </script>
    <script type="text/javascript">
    $(function(){
        $('.column').equalHeight();
    });
</script>

</head>


<body>

	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="#">后台管理面板</a></h1>
			<h2 class="section_title"></h2><div class="btn_view_site"><a href="index.php">查看网站</a></div>
		</hgroup>
	</header> <!-- end of header bar -->
	
	<section id="secondary_bar">
		<div class="user">
			<p>admin</p>
			<!-- <a class="logout_user" href="#" title="Logout">Logout</a> -->
		</div>
		<div class="breadcrumbs_container">
			<article class="breadcrumbs">
				<a href="admin.php?controller=admin">后台管理中心</a>
				<div class="breadcrumb_divider"></div> <a class="current">新闻管理列表</a>
			</article>
		</div>
	</section><!-- end of secondary bar -->

	<?php echo $_smarty_tpl->getSubTemplate ('admin/leftmenu.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


	<section id="main" class="column">
		
		<article class="module width_full">
		<header><h3 class="tabs_involved">新闻管理列表</h3>
		</header>
		
		<div class="tab_container">
			<div id="tab1" class="tab_content">
				<table class="tablesorter" cellspacing="0" style="margin:0"> 
					<thead> 
						<tr>  
			    				<th>序号</th>
			    				<th>内容</th>
			    				<th>图片</th>
			    				<th>操作</th>
						</tr> 
					</thead>
					<tbody>
					<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
						<tr>
		    				<td><?php echo $_smarty_tpl->tpl_vars['value']->value['position'];?>
</td>
		    				<td><?php echo $_smarty_tpl->tpl_vars['value']->value['text'];?>
</td> 
		    				<td><img src="<?php echo ('uploads/').($_smarty_tpl->tpl_vars['value']->value['name']);?>
" alt="" style="width:100px;height:100px;"></td> 
		    				<td>
		    					<input type="image" src="img/images/icn_trash.png" title="Trash" onclick=
										"window.location.href='admin.php?controller=admin&method=sliderImgDel&id=<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
&name=<?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
&classId=<?php echo $_smarty_tpl->tpl_vars['classId']->value;?>
'">
		    					<input type="file" value="修改图片">
		    				</td>
						</tr>
						
					<?php } ?>

					</tbody>
				</table>
				<form action="admin.php?controller=admin&method=addSliderImg" method="post" enctype="multipart/form-data" id='tab2'>
					<table class="tablesorter" cellspacing="0" style="margin:0">
						
					</table>

					<span id="sliderImgAdd">添加图片+</span>
					<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['classId']->value;?>
" name='classId'/>
					<input type="submit" value="提交">
				</form>	
				
			</div><!-- end of #tab1 -->

		</div><!-- end of .tab_container -->
		
		</article><!-- end of content manager article -->
		<div class="spacer"></div>
	</section>


</body>

</html><?php }} ?>
