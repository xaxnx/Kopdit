<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard_controller extends MY_Controller {

	public function index()
	{
		$this->load->model('SimpananWajib_model');
		$this->load->model('SimpananPokok_model');
		$this->load->model('SimpananSukarela_model');
		$this->load->model('Pinjaman_model');


		$this->load->model('Anggota_model');
        $data['total_anggota'] = $this->Anggota_model->get_total_anggota();
		$data['total_simpanan_wajib'] = $this->SimpananWajib_model->get_total_simpanan_wajib();
		$data['total_simpanan_sukarela'] = $this->SimpananSukarela_model->get_total_simpanan_sukarela();
       
		$data['total_simpanan_pokok'] = $this->SimpananPokok_model->get_total_simpanan_pokok();

		
		$this->load->view('admin/dashboard', $data);
	}

}

/* End of file Controllername.php */
