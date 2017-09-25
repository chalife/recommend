<link rel="stylesheet" href="/assets/plugins/datatables/dataTables.bootstrap.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
     标签管理 
    </h1>
    <ol class="breadcrumb">
      <li><a href="/admin/"><i class="fa fa-dashboard"></i> 首页</a></li>
      <li><a href="/admin/tags">标签管理</a></li>
      <li class="active">列表</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"><a href="/admin/tags/create" class="btn btn-block btn-primary btn-flat"><i class="fa fa-plus"></i> 添加</a></h3>

            <div class="box-tools">
              <form action="/admin/tags" method="get">
                <div class="input-group input-group" style="width: 250px;">
                  <input type="text" name="keyword" class="form-control pull-right" placeholder="搜索" value="<?=$keyword?>">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table class="table table-condensed table-hover">
              <thead>
              <tr>
                <th>编号</th>
                <th>标签分类</th>
                <th>标签名称</th>
                <th>添加时间</th>
                <th>操作</th>
              </tr>
              </thead>
              <tbody>
              <?php foreach($tags_list as $tag){?>
                <tr>
                  <td><?=$tag->tag_id;?></td>
                  <td><?=$tag->category_name;?></td>
                  <td><?=$tag->tag_name;?></td>
                  <td><?=$tag->create_time;?></td>
                  <!--<td><?/*=$tag->last_login*/?></td>
                  <td><?/*=$tag->last_ip_address*/?></td>-->
                  <!--<td><?/*=($tag->created?date('Y-m-d H:i:s',$tag->created):'')*/?></td>
                  <td><?/*=($tag->updateted?date('Y-m-d H:i:s',$tag->updateted):'')*/?></td>-->
                  <td>
                    <button data-toggle="modal" data-target="#boxModal" onclick="loadModal('/admin/tags/del/<?=$tag->id?>')" style="margin-right: 5px;" class="btn btn-danger btn-sm pull-right"><i class="fa fa-remove"></i> 删除</button>
                    <a href="/admin/tags/edit/<?=$tag->id?>" class="btn btn-primary btn-sm pull-right" style="margin-right: 5px;"><i class="fa fa-edit"></i> 编辑</a>
                    <a href="/admin/tags/view/<?=$tag->id?>" class="btn btn-success btn-sm pull-right" style="margin-right: 5px;"><i class="fa fa-eye"></i> 查看</a>
                  </td>
                </tr>
              <?php } ?>
              <?php if(empty($tags_list)){?>
                <tr>
                  <td colspan="6" class="no-data">没有数据</td>
                </tr>
              <?php } ?>
              </tfoot>
            </table>
          </div>
          <!-- /.box-body -->
          <div class="box-footer clearfix">

            <div class="row">
              <div class="col-sm-5">
                <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">显示<?=$tags_show_begin?>-<?=$tags_show_end?>条，共<?=$tags_total_rows?>条</div>
              </div>
              <div class="col-sm-7">
                <ul class="pagination pagination no-margin pull-right">
                  <?php echo $this->pagination->create_links(); ?>
                </ul>
              </div>
            </div><!-- /.row -->

          </div>
        </div>
        <!-- /.box -->
      </div>
    </div>


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
