<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>
		文章管理
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> 首页</a></li>
		<li><a href="/admin/users">文章管理</a></li>
		<li class="active">添加文章</li>
	  </ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-plus"></i> 添加文章</h3>
						<a href="/admin/users" class="pull-right">返回</a>
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

								<form action="/admin/blogs/create" class="form-horizontal" id="createForm" method="post" accept-charset="utf-8">
									<div class="form-group">
										<label for="name" class="col-sm-2 control-label">标题</label>
										<div class="col-sm-3">
											<input type="text" name="name" value="<?=$title?>" id="title" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label for="username" class="col-sm-2 control-label">内容</label>
										<div class="col-sm-3">
                                            <textarea type="text" name="content" id="content" value="<?=$content?>" class="form-control"></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="gender" class="col-sm-2 control-label">状态</label>
										<div class="col-sm-3">
											<select name="gender" id="gender" class="form-control">
												<option value="">请选择状态</option>
												<option value="0" <?=($status == '0')?'selected = "selected"':''?>>禁用</option>
												<option value="1" <?=($status == '1')?'selected = "selected"':''?>>正常</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" class="btn btn-primary btn-flat" style="margin-right: 5px;">提交</button>
											<a href="/admin/users" class="btn btn-default btn-flat">取消</a>
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
