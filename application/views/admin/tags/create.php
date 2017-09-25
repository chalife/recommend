<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>
		标签管理
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> 首页</a></li>
		<li><a href="/admin/tags">标签管理</a></li>
		<li class="active">添加标签</li>
	  </ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-plus"></i> 添加标签</h3>
						<a href="/admin/tags" class="pull-right">返回</a>
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

								<form action="/admin/tags/create" class="form-horizontal" id="createForm" method="post" accept-charset="utf-8">
									<div class="form-group">
										<label for="name" class="col-sm-2 control-label">标签分类</label>
										<div class="col-sm-3">
                                            <select name="category_id" id="category_id" class="form-control">
												<option value="">请选择分类</option>
                                                <?php foreach($category_name as $val){?>
                                                <option value="<?php echo $val->category_id;?>" ><?php echo $val->category_name;?></option>
                                                <?php }?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="tag_name" class="col-sm-2 control-label">标签名称</label>
										<div class="col-sm-3">
											<input type="text" name="tag_name" value="<?=$tag_name?>" id="description" class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label for="active" class="col-sm-2 control-label">状态</label>
										<div class="col-sm-3">
											<select name="status" id="status" class="form-control">
												<option value="1" <?=($status == '1')?'selected = "selected"':''?>>正常</option>
												<option value="0" <?=($status == '0')?'selected = "selected"':''?>>禁用</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" class="btn btn-primary btn-flat" style="margin-right: 5px;">提交</button>
											<a href="/admin/tags" class="btn btn-default btn-flat">取消</a>
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
