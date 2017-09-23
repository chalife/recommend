<link rel="stylesheet" href="/assets/plugins/datatables/dataTables.bootstrap.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
     文章管理 
    </h1>
    <ol class="breadcrumb">
      <li><a href="/admin/"><i class="fa fa-dashboard"></i> 首页</a></li>
      <li><a href="/admin/blogs">文章管理</a></li>
      <li class="active">列表</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"><a href="/admin/blogs/create" class="btn btn-block btn-primary btn-flat"><i class="fa fa-plus"></i> 添加</a></h3>

            <div class="box-tools">
              <form action="/admin/blogs" method="get">
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
                <th>标题</th>
                <th>作者</th>
                <th>文章发布时间</th>
                <th>添加时间</th>
                <th>操作</th>
              </tr>
              </thead>
              <tbody>
              <?php foreach($blogs_list as $blog){?>
                <tr>
                  <td><?=$blog->blog_id;?></td>
                  <td><?=$blog->title;?></td>
                  <td><?=$blog->author;?></td>
                  <td><?=$blog->pub_time;?></td>
                  <td><?=$blog->create_time;?></td>
                  <!--<td><?/*=$blog->last_login*/?></td>
                  <td><?/*=$blog->last_ip_address*/?></td>-->
                  <!--<td><?/*=($blog->created?date('Y-m-d H:i:s',$blog->created):'')*/?></td>
                  <td><?/*=($blog->updateted?date('Y-m-d H:i:s',$blog->updateted):'')*/?></td>-->
                  <td>
                    <button data-toggle="modal" data-target="#boxModal" onclick="loadModal('/admin/blogs/del/<?=$blog->id?>')" style="margin-right: 5px;" class="btn btn-danger btn-sm pull-right"><i class="fa fa-remove"></i> 删除</button>
                    <a href="/admin/blogs/edit/<?=$blog->id?>" class="btn btn-primary btn-sm pull-right" style="margin-right: 5px;"><i class="fa fa-edit"></i> 编辑</a>
                    <a href="/admin/blogs/view/<?=$blog->id?>" class="btn btn-success btn-sm pull-right" style="margin-right: 5px;"><i class="fa fa-eye"></i> 查看</a>
                  </td>
                </tr>
              <?php } ?>
              <?php if(empty($blogs_list)){?>
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
                <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">显示<?=$blogs_show_begin?>-<?=$blogs_show_end?>条，共<?=$blogs_total_rows?>条</div>
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
