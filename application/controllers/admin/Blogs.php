<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs extends Admin_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->model('Blog_model');
	}

	public function index()
	{
		$admin_id = $this->checkLogin('A');
		if(!empty($admin_id)){

			$keyword = $this->input->get("keyword");
			$this->data['keyword'] = $keyword;
			$page = $this->input->get("per_page");

			//此配置文件可自行独立
			$this->load->library('pagination');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['first_link'] = '&laquo;';
			$config['last_link'] = '&raquo;';
			$config['next_link'] = '下一页';
			$config['prev_link'] = '上一页';

			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';

			$base_url = base_url('/admin/blogs/index');
			if(!empty($keyword)){
				$base_url .="?keyword=".$keyword;
			}
			$config['base_url'] = $base_url;
			$config['total_rows'] = $this->Blog_model->getCount($keyword);
			$config['per_page'] = 20;

			if($page > 1){
				$page = $page - 1;
			}
			else{
				$page = 0;
			}

			$show_begin = $config['per_page'] * $page;
			if($config['total_rows'] > 0)$show_begin = $show_begin+1;

			$show_end = $config['per_page'] * ($page + 1);
			if($config['total_rows'] < $show_end)$show_end = ($config['per_page'] * $page) + ($config['total_rows'] % $config['per_page']);

			$offset = $config['per_page'] * $page;
			$this->data['blogs_show_begin'] = $show_begin;
			$this->data['blogs_show_end'] = $show_end;
			$this->data['blogs_total_rows'] = $config['total_rows'];
			$this->data['blogs_list'] = $this->Blog_model->getAll($config['per_page'], $offset, $keyword);

			//初始化分页
			$this->load->library('pagination');
			$this->pagination->initialize($config);

			//加载模板
			$this->template->admin_load('admin/blogs/index', $this->data);
		}else{
			redirect("/admin/admin");
		}

	}

	//查看用户
	public function view($id)
	{
		$id = $this->uri->segment(4);

		//获取数据
		$blog = $this->Blog_model->find($id);
		if(empty($blog)){
			redirect('admin/blogs', 'refresh');
		}

		// 传递数据
		$this->data['blog']  = $blog;

		//当前列表页面的url
		$form_url = empty($_SERVER['HTTP_REFERER']) ? '' : $_SERVER['HTTP_REFERER'];
		if(strripos($form_url,"admin/blogs/index") === FALSE){
			$form_url = "/admin/blogs";
		}
		$this->data['form_url'] = $form_url;


		//加载模板
		$this->template->admin_load('admin/blogs/view', $this->data);
	}


	//删除用户
	public function del($id=0)
	{
		$id = $this->uri->segment(4);
		if(empty($id)){
			redirect('admin/blogs', 'refresh');
		}
		$data = array();

		//获取数据
		$blog = $this->Blog_model->find($id);
		if(empty($blog)){
			redirect('admin/blogs', 'refresh');
		}
		else{

			if($this->input->post("id") == $id)
			{
				if($this->Blog_model->delete($id)){
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('message', "删除成功！");
				}
				else{
					$data["message"] = "<div class=\"alert alert-danger alert-dismissable\"><button class=\"close\" data-dismiss=\"alert\">&times;</button>删除数据时发生错误，请稍后再试！</div>";
				}
			}
		}

		$data['blog'] = $blog;
		$this->load->view('admin/blogs/modals/del', $data);
	}

	//更新用户信息
	public function edit($id = 0)
	{
		$id = $this->uri->segment(4);

		//获取数据
		$blog = $this->Blog_model->find($id);
		if(empty($blog)){
			redirect('admin/blogs', 'refresh');
		}

		if($this->input->method() == "post")
		{

			// 表单校验
			$this->form_validation->set_rules('name', '姓名', 'required|min_length[2]|max_length[20]');
			$this->form_validation->set_rules('blogname', '昵称', 'required|min_length[2]|max_length[20]');
			$this->form_validation->set_rules('mobile', '手机', 'required|min_length[11]|max_length[11]');
			$this->form_validation->set_rules('active', '状态', 'required');


			if ($this->form_validation->run() == TRUE)
			{
				$name = $this->input->post('name');
				$blogname = $this->input->post('blogname');
				$mobile = $this->input->post('mobile');
				$password = $this->input->post('password');
				$active = $this->input->post('active');
				$gender = $this->input->post('gender');
				$birthday = $this->input->post('birthday');
				$info = $this->input->post('info');


				$data = array(
					'name' => $name,
					'blogname'  => $blogname,
					'mobile'  => $mobile,
					'password'  => $password,
					'active'  => $active,
					'updated'	=> time(),
					'birthday'	=> $birthday,
					'gender'	=> $gender,
					'info'	=> $info,
				);

				$this->Blog_model->update($id, $data);

				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('message', "修改成功！");

				//返回列表页面
				$form_url = $this->session->blogdata('list_page_url');
				if(empty($form_url)){
					$form_url = "/admin/blogs";
				}
				else{
					$this->session->unset_blogdata('list_page_url');
				}

				redirect($form_url, 'refresh');
			}
			else{
				// 传递错误信息
				$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

				$this->data['name'] = $this->form_validation->set_value('name');
				$this->data['blogname'] = $this->form_validation->set_value('blogname');
				$this->data['mobile'] = $this->form_validation->set_value('mobile');
				$this->data['password'] = $this->form_validation->set_value('password');
				$this->data['active'] = $this->form_validation->set_value('active');


				//当前列表页面的url
				$form_url = $this->session->blogdata('list_page_url');
				if(empty($form_url)){
					$form_url = "/admin/blogs";
				}
				$this->data['form_url'] = $form_url;

			}
		}
		else{
			//当前列表页面的url
			$form_url = empty($_SERVER['HTTP_REFERER']) ? '' : $_SERVER['HTTP_REFERER'];
			if(!(strripos($form_url,"admin/blogs/index") === FALSE)){
				$this->session->set_blogdata('list_page_url', $form_url);
			}
			else{
				$form_url = "/admin/blogs";
			}
			$this->data['form_url'] = $form_url;

		}

		// 传递数据
		$this->data['blog'] = $blog;

		$this->data['name'] = isset($this->data['name']) ? $this->data['name'] : $blog->name ;
		$this->data['blogname'] = isset($this->data['blogname']) ? $this->data['blogname'] : $blog->blogname ;
		$this->data['mobile'] = isset($this->data['mobile']) ? $this->data['mobile'] : $blog->mobile ;
		$this->data['password'] = isset($this->data['password']) ? $this->data['password'] : $blog->password ;
		$this->data['active'] = isset($this->data['active']) ? $this->data['active'] : $blog->active ;
		$this->data['birthday'] = isset($this->data['birthday']) ? $this->data['birthday'] : $blog->birthday ;
		$this->data['gender'] = isset($this->data['gender']) ? $this->data['gender'] : $blog->gender ;
		$this->data['info'] = isset($this->data['info']) ? $this->data['info'] : $blog->info ;

		//加载模板
		$this->template->admin_load('admin/blogs/edit', $this->data);
	}

	//创建用户
	public function create()
	{
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		if($this->input->method() == "post"){

			// 表单校验
			$this->form_validation->set_rules('title', '标题', 'required|min_length[2]|max_length[50]');
			$this->form_validation->set_rules('content', '内容', 'required');
			$this->form_validation->set_rules('status', '状态', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				$title = $this->input->post('title');
				$content = $this->input->post('content');
				$author = $this->input->post('author');
				$status = $this->input->post('status');

				$data = array(
					'title' => $title,
					'content'  => $content,
                    'author' => $author,
					'status'  => $status,
					'pub_time'	=> time(),
					'create_time'	=> time()
				);
				$this->Blog_model->create($data);

				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('message', "添加成功！");

				redirect('admin/blogs', 'refresh');
			}
			else
			{
				$this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

				$this->data['title'] = $this->form_validation->set_value('title');
				$this->data['content'] = $this->form_validation->set_value('content');
				$this->data['author'] = $this->form_validation->set_value('author');
				$this->data['mobile'] = $this->form_validation->set_value('mobile');
				$this->data['active'] = $this->form_validation->set_value('active');
			}
		}

		//加载模板
		$this->template->admin_load('admin/blogs/create', $this->data);
	}

	//重置密码
	public function reset_password()
	{
		$id = $this->uri->segment(4);
		if(empty($id)){
			redirect('admin/blogs', 'refresh');
		}
		//获取数据
		$blog = $this->Blog_model->find($id);
		if(empty($blog)){
			redirect('admin/blogs', 'refresh');
		}else{
			if($this->input->post("id") == $id)
			{
				//TODO优化加密，以及重置方式
				$password = md5("11111");
				$data = array(
					'password'  => $password,
					'updated'	=> time(),
//                    'updated'	=> date('Y-m-d H:i:s'),
				);
				if($this->Blog_model->update($id, $data)){
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('message', "重置成功！");
				}else{
					$data["message"] = "<div class=\"alert alert-danger alert-dismissable\"><button class=\"close\" data-dismiss=\"alert\">&times;</button>重置密码时发生错误，请稍后再试！</div>";
				}
			}
		}
		$data['blog'] = $blog;
		$this->load->view('admin/blogs/modals/reset_password', $data);
	}

	/**
	 * 用户积分兑换记录
	 */
	public function integral()
	{
		$admin_id = $this->checkLogin('A');
		if(!empty($admin_id)){
			$keyword = $this->uri->segment(4);
			if(empty($keyword)){
				redirect('admin/blogs', 'refresh');
			}
			$this->data['keyword'] = $keyword;
			$page = $this->input->get("per_page");

			//此配置文件可自行独立
			$this->load->library('pagination');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['first_link'] = '&laquo;';
			$config['last_link'] = '&raquo;';
			$config['next_link'] = '下一页';
			$config['prev_link'] = '上一页';

			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';

			$base_url = base_url('/admin/blogs/integral');
			if(!empty($keyword)){
				$base_url .="?keyword=".$keyword;
			}
			$config['base_url'] = $base_url;
			$config['total_rows'] = $this->blogbonus_model->getCount('',$keyword);
			$config['per_page'] = 20;

			if($page > 1){
				$page = $page - 1;
			}
			else{
				$page = 0;
			}

			$show_begin = $config['per_page'] * $page;
			if($config['total_rows'] > 0)$show_begin = $show_begin+1;

			$show_end = $config['per_page'] * ($page + 1);
			if($config['total_rows'] < $show_end)$show_end = ($config['per_page'] * $page) + ($config['total_rows'] % $config['per_page']);

			$offset = $config['per_page'] * $page;
			$this->data['integrals_show_begin'] = $show_begin;
			$this->data['integrals_show_end'] = $show_end;
			$this->data['integrals_total_rows'] = $config['total_rows'];
			$this->data['integrals_list'] = $this->blogbonus_model->getAll($config['per_page'], $offset, '',$keyword);

			//初始化分页
			$this->load->library('pagination');
			$this->pagination->initialize($config);

			//加载模板
			$this->template->admin_load('admin/blogs/integral', $this->data);
		}else{
			redirect("/admin");
		}

	}

	/**
	 * 用户乘车记录
	 */
	public function rides()
	{
		$admin_id = $this->checkLogin('A');
		if(!empty($admin_id)){
			$keyword = $this->uri->segment(4);
			if(empty($keyword)){
				redirect('admin/blogs', 'refresh');
			}
			$this->data['keyword'] = $keyword;
			$page = $this->input->get("per_page");

			//此配置文件可自行独立
			$this->load->library('pagination');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['first_link'] = '&laquo;';
			$config['last_link'] = '&raquo;';
			$config['next_link'] = '下一页';
			$config['prev_link'] = '上一页';

			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';

			$base_url = base_url('/admin/blogs/rides');
			if(!empty($keyword)){
				$base_url .="?keyword=".$keyword;
			}
			$config['base_url'] = $base_url;
			$config['total_rows'] = $this->Blog_model->find_rides_count_by_mobile($keyword);
			$config['per_page'] = 20;

			if($page > 1){
				$page = $page - 1;
			}
			else{
				$page = 0;
			}

			$show_begin = $config['per_page'] * $page;
			if($config['total_rows'] > 0)$show_begin = $show_begin+1;

			$show_end = $config['per_page'] * ($page + 1);
			if($config['total_rows'] < $show_end)$show_end = ($config['per_page'] * $page) + ($config['total_rows'] % $config['per_page']);

			$offset = $config['per_page'] * $page;
			$this->data['rides_show_begin'] = $show_begin;
			$this->data['rides_show_end'] = $show_end;
			$this->data['rides_total_rows'] = $config['total_rows'];
			$this->data['rides_list'] = $this->Blog_model->find_rides_by_mobile($config['per_page'], $offset, $keyword);

			//初始化分页
			$this->load->library('pagination');
			$this->pagination->initialize($config);

			//加载模板
			$this->template->admin_load('admin/blogs/rides', $this->data);
		}else{
			redirect("/admin");
		}

	}

	/**
	 * 订单评价记录
	 */
	public function evaluation()
	{
		$admin_id = $this->checkLogin('A');
		if(!empty($admin_id)){
			$keyword = $this->input->get("keyword");
			$blog_id = $this->uri->segment(4);
			if(empty($blog_id)){
				redirect('admin/blogs', 'refresh');
			}
			$this->data['keyword'] = $keyword;
			$this->data['blog_id'] = $blog_id;
			$page = $this->input->get("per_page");

			//此配置文件可自行独立
			$this->load->library('pagination');
			$config['use_page_numbers'] = TRUE;
			$config['page_query_string'] = TRUE;
			$config['first_link'] = '&laquo;';
			$config['last_link'] = '&raquo;';
			$config['next_link'] = '下一页';
			$config['prev_link'] = '上一页';

			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';

			$base_url = base_url('/admin/blogs/evaluation');
			if(!empty($keyword)){
				$base_url .="?keyword=".$keyword;
			}
			$config['base_url'] = $base_url;
			$config['total_rows'] = $this->evaluation_model->getCount($keyword,$blog_id);
			$config['per_page'] = 20;

			if($page > 1){
				$page = $page - 1;
			}
			else{
				$page = 0;
			}

			$show_begin = $config['per_page'] * $page;
			if($config['total_rows'] > 0)$show_begin = $show_begin+1;

			$show_end = $config['per_page'] * ($page + 1);
			if($config['total_rows'] < $show_end)$show_end = ($config['per_page'] * $page) + ($config['total_rows'] % $config['per_page']);

			$offset = $config['per_page'] * $page;
			$this->data['evaluations_show_begin'] = $show_begin;
			$this->data['evaluations_show_end'] = $show_end;
			$this->data['evaluations_total_rows'] = $config['total_rows'];
			$this->data['evaluations_list'] = $this->evaluation_model->getAll($config['per_page'], $offset, $keyword, $blog_id);

			//初始化分页
			$this->load->library('pagination');
			$this->pagination->initialize($config);

			//加载模板
			$this->template->admin_load('admin/blogs/evaluation', $this->data);
		}else{
			redirect("/admin");
		}

	}
}
