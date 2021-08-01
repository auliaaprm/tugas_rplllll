<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// **
		// load model
		$this->load->model('MemberModel','model');
		$this->load->model('MenuModel','menu_model');
		$this->load->model('PesananModel','pesanan_model');

		// **
		// get user session
		$this->user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		// **
		// layout to be loaded
		$this->layout = "templates/user/default.php";
	}

	public function index()
	{
		$data['title'] = 'User Dashboard';
		$data['user'] = $this->user;

		// **
		// view file to be loaded
		$data['view_file'] = 'dashboard';
		$this->load->view($this->layout, $data, FALSE);

		// $this->load->view('user/index', $data);
	}

	function keranjang_page()
	{
		$data['title'] = "Keranjang";
		$data['user'] = $this->user;

		// **
		// view file to be loaded
		$data['view_file'] = 'keranjang_page';
		$data['title_page'] = 'Pesanan Anda';

		// **
		// data on that page
		$data['menu_list'] = $this->menu_model->menu_get_list();
		$this->load->view($this->layout, $data, FALSE);
	}

	function menu_page()
	{
		$data['title'] = "Daftar Menu";
		$data['user'] = $this->user;

		// **
		// view file to be loaded
		$data['view_file'] = 'daftar_menu_page';

		// **
		// data on that page
		$data['menu_list'] = $this->menu_model->menu_get_list();
		$this->load->view($this->layout, $data, FALSE);
	}

	function daftar_member_page()
	{
		$data['title'] = "Halaman Member";
		$data['user'] = $this->user;

		// **
		// view file to be loaded
		$data['view_file'] = 'daftar_member_page';
		$this->load->view($this->layout, $data, FALSE);
	}

	function daftar_member()
	{
		$post = $this->input->post();
		try {
			$member_id = $this->model->member_save($post);

			// **
			// data notif
			$notif_data = array();
			$notif_data['result'] = "success";
			$notif_data['message'] = "Berhasil mendaftar sebagai member";
			$this->create_notif($notif_data);
		} catch (Exception $e) {
			// **
			// data notif
			$notif_data = array();
			$notif_data['result'] = "danger";
			$notif_data['message'] = $e->getMessage();
			$this->create_notif($notif_data);
		}
		redirect('user/member/daftar','refresh');
	}

	function ajax_add_item_to_cart()
	{
		// **
		// prevent non ajax to access the page
		if (!$this->input->is_ajax_request()) {
			redirect(base_url()."user",'refresh');
		}

		// **
		// set session variable, and check session
		// redirect to home if no session found
		$session = $this->session->userdata();
		if (count($session) < 1) {
			redirect(base_url()."user",'refresh');
		}

		// **
		// create variable to store post value
		$post = $this->input->post();
		try {
			// **
			// access menu model to get total_harga (value needed in pesanan table)
			$total_harga = $this->menu_model->pesanan_hitung_total_harga($post);
			$post['total_harga'] = $total_harga;

			// **
			// access model to add item to cart
			$post['id_bayar'] = "0";
			echo $this->pesanan_model->pesanan_save($post);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function ajax_get_cart_item_amount()
	{
		// **
		// prevent non ajax to access the page
		if (!$this->input->is_ajax_request()) {
			redirect(base_url()."user",'refresh');
		}

		// **
		// set session variable, and check session
		// redirect to home if no session found
		$session = $this->session->userdata();
		if (count($session) < 1) {
			redirect(base_url()."user",'refresh');
		}

		// **
		// access model to save pesanan with where condition
		$where = array();
		$where['pesanan.id_user'] = $session['id_user'];
		$pesanan_list = $this->pesanan_model->pesanan_get_list($where);
		echo count($pesanan_list);
	}

	function create_notif($data)
	{
		// **
		// set notification
		$notif_data = array();
		$notif_data['result'] = $data['result'];
		$notif_data['message'] = $data['message'];
		$this->session->set_flashdata('notif', $notif_data);
	}
}
