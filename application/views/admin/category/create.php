<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>
		标签分类管理
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> 首页</a></li>
		<li><a href="/admin/category">标签分类管理</a></li>
		<li class="active">添加标签分类</li>
	  </ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-plus"></i> 添加标签分类</h3>
						<a href="/admin/category" class="pull-right">返回</a>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-xs-12">

							    <?php if(!empty($message)){?>
								<div class="alert alert-danger alert-dismissible">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<?php echo $message;?>
								</div>
								<?php }?>

								<form action="/admin/category/create" class="form-horizontal" id="createForm" method="post" accept-charset="utf-8">
									<div class="form-group">
										<label for="name" class="col-sm-2 control-label">分类名称</label>
										<div class="col-sm-3">
											<input type="text" name="category_name" value="<?=$category_name?>" id="category_name" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" class="btn btn-primary btn-flat" style="margin-right: 5px;">提交</button>
											<a href="/admin/category" class="btn btn-default btn-flat">取消</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<script src="/assets/plugins/pwstrength/pwstrength.min.js"></script>
<script src="/assets/plugins/validate/jquery.validate.min.js"></script>

<script>
	$(function(){
		$("#createForm").validate();
	});
</script>
