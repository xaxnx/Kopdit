<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* author inogalwargan
*/

class dum_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Anggota_model");
        $this->load->model('Audit_model');

        $this->load->model("dum_model");
     
        $this->load->library('form_validation');
    }

    public function index()
    {
        $start_date = '2024-01-01';
        $end_date = '2024-12-31';
        $data["daftar_uang_masuk"] = $this->dum_model->getListdum();
       
        //$data['total'] = $this->dum_model->total();
        $data['total_sum'] = $this->dum_model->total_sum();
        
        
        
        
       
        $this->load->view("dum/lihat_dum", $data);
    }

    //public function detail($id){
        // $data['anggota'] = $this->SimpananWajib_model->detail_simpanan_pokokall();
      //  $data['simpanan_wajib'] = $this->SimpananWajib_model->detail_simpanan_wajib($id);
      //  $data['tot'] = $this->SimpananWajib_model->total_simpanan_wajib($id);
     //   $this->load->view("simpanan_wajib/detail_simpanan_wajib", $data);
    //}

    public function list_anggota(){
    	$data['anggota'] = $this->Anggota_model->getAll();
        $this->load->view("dum/list_anggota_dum", $data);
    }

    public function add($id)
    {   
        $anggota = $this->Anggota_model;
        $daftar_uang_masuk = $this->dum_model;
        $validation = $this->form_validation;
        $validation->set_rules($daftar_uang_masuk->rules());

        if ($validation->run()) {
            $daftar_uang_masuk->save();
            $this->session->set_flashdata('success', 'Tambahan Berhasil Disimpan');
            redirect('dum_controller/index');
            
        }
        $data['anggota'] = $this->Anggota_model->getById($id);
        
        $this->load->view("dum/tambah_dum", $data);
    }

    public function edit($id){
        $anggota = $this->Anggota_model; //object model
    	$daftar_uang_masuk = $this->dum_model; //object model
        $validation = $this->form_validation; //object validasi
        $validation->set_rules($daftar_uang_masuk->rules()); //terapkan rules di Anggota_model.php

        if ($validation->run()) { //lakukan validasi form
            $daftar_uang_masuk->update($id); // update data
            $this->session->set_flashdata('success', 'Data Berhasil Diubah');
            redirect($_SERVER ['HTTP_REFERER']);

        }
         // $data['anggota'] = $this->Anggota_model->getById($id);
     
        $data['daftar_uang_masuk'] = $this->dum_model->getById($id);
        $this->load->view('dum/edit_dum', $data);
    }

    // public function hide($id){
    // 	$this->Anggota_model->update($id);
    // 	$this->session->set_flashdata('success', 'Data Pegawai Berhasil Dihapus');
    // 	redirect('Anggota_controller/index');
    // }

    public function delete($id){
	    $this->dum_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php
	    $this->session->set_flashdata('success', 'Data Berhasil Dihapus');
	    redirect($_SERVER['HTTP_REFERER']);
	}
}
