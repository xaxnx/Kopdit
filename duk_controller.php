<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* author inogalwargan
*/

class duk_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Anggota_model");
        $this->load->model("duk_model");
        $this->load->model('Audit_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["duk"] = $this->duk_model->getListduk();
        //$data['total'] = $this->duk_model->total();
        $data['total_sum'] = $this->duk_model->total_sum();
        
        
        
       
        $this->load->view("duk/lihat_duk", $data);
    }

    //public function detail($id){
        // $data['anggota'] = $this->SimpananWajib_model->detail_simpanan_pokokall();
      //  $data['simpanan_wajib'] = $this->SimpananWajib_model->detail_simpanan_wajib($id);
      //  $data['tot'] = $this->SimpananWajib_model->total_simpanan_wajib($id);
     //   $this->load->view("simpanan_wajib/detail_simpanan_wajib", $data);
    //}

    public function list_anggota(){
    	$data['anggota'] = $this->Anggota_model->getAll();
        $this->load->view("duk/list_anggota_duk", $data);
    }

    public function add($id)
    {   
        $anggota = $this->Anggota_model;
        $duk = $this->duk_model;
        $validation = $this->form_validation;
        $validation->set_rules($duk->rules());

        if ($validation->run()) {
            $duk->save();
            $this->session->set_flashdata('success', 'Tambahan Berhasil Disimpan');
            redirect('duk_controller/index');
            
        }
        $data['anggota'] = $this->Anggota_model->getById($id);
        
        $this->load->view("duk/tambah_duk", $data);
    }

    public function edit($id){
        $anggota = $this->Anggota_model; //object model
    	$duk = $this->duk_model; //object model
        $validation = $this->form_validation; //object validasi
        $validation->set_rules($duk->rules()); //terapkan rules di Anggota_model.php

        if ($validation->run()) { //lakukan validasi form
            $duk->update($id); // update data
            $this->session->set_flashdata('success', 'Data Berhasil Diubah');
            redirect($_SERVER ['HTTP_REFERER']);

        }
         // $data['anggota'] = $this->Anggota_model->getById($id);
     
        $data['duk'] = $this->duk_model->getById($id);
        $this->load->view('duk/edit_duk', $data);
    }

    // public function hide($id){
    // 	$this->Anggota_model->update($id);
    // 	$this->session->set_flashdata('success', 'Data Pegawai Berhasil Dihapus');
    // 	redirect('Anggota_controller/index');
    // }

    public function delete($id){
	    $this->duk_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php
	    $this->session->set_flashdata('success', 'Data Berhasil Dihapus');
	    redirect($_SERVER['HTTP_REFERER']);
	}
}
