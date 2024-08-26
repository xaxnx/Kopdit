<?php defined('BASEPATH') OR exit('No direct script access allowed');


class tariksimpanansukarela_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Anggota_model");
        $this->load->model("tariksimpanansukarela_model");
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["anggota"] = $this->Anggota_model->getAll();
        $this->load->view("tarik_simpanansukarela/lihat_tarik_simpanansukarela", $data);
    }

    public function detail($id){

        // $data['anggota'] = $this->SimpananWajib_model->detail_simpanan_pokokall();
        $data['tarik_simpanansukarela'] = $this->tariksimpanansukarela_model->detail_tarik_simpanansukarela($id);
        $data['tot'] = $this->tariksimpanansukarela_model->total_tarik_simpanansukarela($id);
        $this->load->view("tarik_simpanansukarela/detail_tarik_simpanansukarela", $data);
    }

    public function add($id)
    {   
        $anggota = $this->Anggota_model;
        $tarik_simpanansukarela = $this->tariksimpanansukarela_model;
        $validation = $this->form_validation;
        $validation->set_rules($tarik_simpanansukarela->rules());

        if ($validation->run()) {
            $tarik_simpanansukarela->save();
            $this->session->set_flashdata('success', 'Tambah Simpanan Sukarela Sebesar Rp. '.$tarik_simpanansukarela->jumlah.' Berhasil Disimpan');
            redirect('tariksimpanansukarela_controller/index');
        }
        $data['anggota'] = $this->Anggota_model->getById($id);
        $this->load->view("tarik_simpanansukarela/tambah_tarik_simpanansukarela", $data);
    }

    public function edit($id){
        $anggota = $this->Anggota_model; //object model
    	$tarik_simpanansukarela = $this->tariksimpanansukarela_model; //object model
        $validation = $this->form_validation; //object validasi
        $validation->set_rules($tarik_simpanansukarela->rules()); //terapkan rules di Anggota_model.php

        if ($validation->run()) { //lakukan validasi form
            $tarik_simpanansukarela->update($id); // update data
            $this->session->set_flashdata('success', 'Data Simpanan Sukarela Sebesar Rp. '.$tarik_simpanansukarela->getById($id)->jumlah.' Berhasil Diubah');
            redirect($_SERVER ['HTTP_REFERER']);

        }
        $data['tarik_simpanansukarela'] = $this->tariksimpanansukarela_model->getById($id);
        $this->load->view('tarik_simpanansukarela/edit_tarik_simpanansukarela', $data);
    }

    public function hide($id){
    	$this->Anggota_model->update($id);
    	$this->session->set_flashdata('success', 'Data Pegawai Berhasil Dihapus');
    	redirect('Anggota_controller/index');
    }

    public function delete($id){
	    $this->tariksimpanansukarela_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php
	    $this->session->set_flashdata('success', 'Data Simpanan Sukarela Berhasil Dihapus');
	    redirect($_SERVER['HTTP_REFERER']);
	}
}
