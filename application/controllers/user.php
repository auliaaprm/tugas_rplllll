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
		$this->load->model('PembayaranModel','pembayaran_model');
		$this->load->model('ShipmentModel','shipment_model');
		$this->load->model('ReservasiModel','reservasi_model');

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
		$data['title_page'] = 'Keranjang';

		// **
		// where condition for getting pesanan list
		$where = array();
		$where['pesanan.id_user'] = $this->session->userdata()['id_user'];
		$where['pesanan.id_bayar'] = "0";
		
		// **
		// data to show on page
		$data['pesanan_list'] = $this->pesanan_model->pesanan_get_list($where);
		$data['pembayaran_list'] = $this->pembayaran_model->pembayaran_get_list();
		$data['shipment_list'] = $this->shipment_model->shipment_get_list();

		// **
		// data on that page
		$data['menu_list'] = $this->menu_model->menu_get_list();
		$this->load->view($this->layout, $data, FALSE);
	}

	function keranjang_bayar()
	{
		try {
			$post = $this->input->post();
			$receipt_number = $this->pesanan_model->pesanan_bayar($post);
			redirect("user/receipt?number=$receipt_number",'refresh');
			// $this->receipt_details_page($receipt_number);
		} catch (Exception $e) {
			// **
			// data notif
			$notif_data = array();
			$notif_data['result'] = "danger";
			$notif_data['message'] = $e->getMessage();
			$this->create_notif($notif_data);
		}
	}

	function keranjang_update()
	{
		try {
			$post = $this->input->post();
			$this->pesanan_model->pesanan_update($post);

			// **
			// data notif
			$notif_data = array();
			$notif_data['result'] = "success";
			$notif_data['message'] = "Berhasil update keranjang";
			$this->create_notif($notif_data);
		} catch (Exception $e) {
			// **
			// data notif
			$notif_data = array();
			$notif_data['result'] = "danger";
			$notif_data['message'] = $e->getMessage();
			$this->create_notif($notif_data);
		}
		redirect('user/keranjang','refresh');
	}

	function riwayat_transaksi_page()
	{
		$data['title'] = "Riwayat Transaksi";
		$data['user'] = $this->user;

		// **
		// view file to be loaded
		$data['view_file'] = 'riwayat_transaksi_page';
		$data['pesanan_list'] = $this->pesanan_model->riwayat_transaksi_get_list();
		$data['reservasi_list'] = $this->reservasi_model->riwayat_reservasi_get_list();

		$this->load->view($this->layout, $data, FALSE);
	}

	function receipt_page()
	{
		$data['title'] = "Bukti Pesanan";
		$data['user'] = $this->user;

		// **
		// view file to be loaded
		$data['view_file'] = 'receipt_page';

		if ($this->input->get('number')) {
			// **
			// data to show on page
			$where = array();
			$where['receipt_number'] = $this->input->get('number');
		}
		$data['pesanan_list'] = $this->pesanan_model->pesanan_get_list($where ?? null);

		$this->load->view($this->layout, $data, FALSE);
	}

	function reservasi_page()
	{
		$data['user'] = $this->user;
		
		// **
		// open specific reservasi page according to 'number' query on URL
		if ($this->input->get('number')) {
			$data['title'] = "Bukti Reservasi";
			
			// **
			// data to show on page
			$where = array();
			$where['kode_reservasi'] = $this->input->get('number');

			// **
			// get reservasi list
			$reservasi_list = $this->reservasi_model->reservasi_get_list($where);
			$data['reservasi_details'] = array();
			if (count($reservasi_list) > 0) {
				$data['reservasi_details'] = $reservasi_list[0];
			}

			$data['view_file'] = 'reservasi_details_page';
		} else {
			$data['title'] = "Form Reservasi";

			// **
			// view file to be loaded
			$data['view_file'] = 'reservasi_page';
			
			// **
			// data shown on page
			$data['pembayaran_list'] = $this->pembayaran_model->pembayaran_get_list();
		}

		$this->load->view($this->layout, $data, FALSE);
	}

	function reservasi()
	{
		try {
			$post = $this->input->post();
			$reservasi_id = $this->reservasi_model->reservasi_save($post);

			// **
			// data notif
			$notif_data = array();
			$notif_data['result'] = "success";
			$notif_data['message'] = "Berhasil melakukan reservasi tempat";
			$this->create_notif($notif_data);
		} catch (Exception $e) {
			// **
			// data notif
			$notif_data = array();
			$notif_data['result'] = "danger";
			$notif_data['message'] = $e->getMessage();
			$this->create_notif($notif_data);
		}
		redirect('user/reservasi','refresh');
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
		// check data member by email
		// where condition
		$where = array();
		$where['email'] = $this->session->userdata()['email'];
		$member_list = $this->model->member_get_list($where);

		// **
		// view file to be loaded
		if (count($member_list) > 0) {
			$data['member_details'] = $member_list[0];
			$data['view_file'] = "membership_page";
		} else {
			$data['view_file'] = 'daftar_member_page';
		}
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
		$where['pesanan.id_bayar'] = "0";
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
