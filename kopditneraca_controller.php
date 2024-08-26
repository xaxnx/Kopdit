<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* author inogalwargan
*/

class kopditneraca_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("PerkiraanAkuntansi_model");
        $this->load->model("kopditneraca_model");
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["kopdit_neraca"] = $this->kopditneraca_model->getListneraca();
        $data['total'] = $this->kopditneraca_model->total();
        $this->load->view("kopdit_neraca/lihat_neraca", $data);
    }

    public function detail($id){
        // $data['anggota'] = $this->SimpananWajib_model->detail_simpanan_pokokall();
        $data['simpanan_wajib'] = $this->SimpananWajib_model->detail_simpanan_wajib($id);
        $data['tot'] = $this->SimpananWajib_model->total_simpanan_wajib($id);
        $this->load->view("simpanan_wajib/detail_simpanan_wajib", $data);
    }

    public function list_neraca(){
    	$data['perkiraan_akuntansi'] = $this->PerkiraanAkuntansi_model->getAll();
        $this->load->view("kopdit_neraca/list_neraca", $data);
    }

    public function add($id)
    {   
        $perkiraan_akuntansi = $this->PerkiraanAkuntansi_model;
        $kopdit_neraca = $this->kopditneraca_model;
        $validation = $this->form_validation;
        $validation->set_rules($kopdit_neraca->rules());

        if ($validation->run()) {
            $kopdit_neraca->save();
            $this->session->set_flashdata('success', 'Berhasil Disimpan');
            redirect('kopditneraca_controller/index');
        }
        $data['perkiraan_akuntansi'] = $this->PerkiraanAkuntansi_model->getById($id);
        $this->load->view("kopdit_neraca/tambah_neraca", $data);
    }

    public function edit($id){
        $perkiraan_akuntansi = $this->PerkiraanAkuntansi_model; //object model
    	$kopdit_neraca = $this->kopditneraca_model; //object model
        $validation = $this->form_validation; //object validasi
        $validation->set_rules($kopdit_neraca->rules()); //terapkan rules di Anggota_model.php

        if ($validation->run()) { //lakukan validasi form
            $kopdit_neraca->update($id); // update data
            $this->session->set_flashdata('success  Berhasil Diubah');
            redirect('kopditneraca_controller/index');

        }
         // $data['anggota'] = $this->Anggota_model->getById($id);
     
        $data['kopdit_neraca'] = $this->kopditneraca_model->getById($id);
        $this->load->view('kopdit_neraca/edit_neraca', $data);
    }

    // public function hide($id){
    // 	$this->Anggota_model->update($id);
    // 	$this->session->set_flashdata('success', 'Data Pegawai Berhasil Dihapus');
    // 	redirect('Anggota_controller/index');
    // }

    public function delete($id){
	    $this->kopditneraca_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php
	    $this->session->set_flashdata('success', 'Data Pinjaman Berhasil Dihapus');
	    redirect($_SERVER['HTTP_REFERER']);
	}
}
