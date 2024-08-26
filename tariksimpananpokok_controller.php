<?php defined('BASEPATH') OR exit('No direct script access allowed');


class tariksimpananpokok_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Anggota_model");
        $this->load->model("tariksimpananpokok_model");
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["anggota"] = $this->Anggota_model->getAll();
        $this->load->view("tarik_simpananpokok/lihat_tarik_simpananpokok", $data);
    }

    public function detail($id){

        // $data['anggota'] = $this->SimpananWajib_model->detail_simpanan_pokokall();
        $data['tarik_simpananpokok'] = $this->tariksimpananpokok_model->detail_tarik_simpananpokok($id);
        $data['tot'] = $this->tariksimpananpokok_model->total_tarik_simpananpokok($id);
        $this->load->view("tarik_simpananpokok/detail_tarik_simpananpokok", $data);
    }

    public function add($id)
    {   
        $anggota = $this->Anggota_model;
        $tarik_simpananpokok = $this->tariksimpananpokok_model;
        $validation = $this->form_validation;
        $validation->set_rules($tarik_simpananpokok->rules());

        if ($validation->run()) {
            $tarik_simpananpokok->save();
            $this->session->set_flashdata('success', 'Tambah Simpanan Sukarela Sebesar Rp. '.$tarik_simpananpokok->jumlah.' Berhasil Disimpan');
            redirect('tariksimpananpokok_controller/index');
        }
        $data['anggota'] = $this->Anggota_model->getById($id);
        $this->load->view("tarik_simpananpokok/tambah_tarik_simpananpokok", $data);
    }

    public function edit($id){
        $anggota = $this->Anggota_model; //object model
    	$tarik_simpananpokok = $this->tariksimpananpokok_model; //object model
        $validation = $this->form_validation; //object validasi
        $validation->set_rules($tarik_simpananpokok->rules()); //terapkan rules di Anggota_model.php

        if ($validation->run()) { //lakukan validasi form
            $tarik_simpananpokok->update($id); // update data
            $this->session->set_flashdata('success', 'Data Simpanan Sukarela Sebesar Rp. '.$tarik_simpananpokok->getById($id)->jumlah.' Berhasil Diubah');
            redirect($_SERVER ['HTTP_REFERER']);

        }
        $data['tarik_simpananpokok'] = $this->tariksimpananpokok_model->getById($id);
        $this->load->view('tarik_simpananpokok/edit_tarik_simpananpokok', $data);
    }

    public function hide($id){
    	$this->Anggota_model->update($id);
    	$this->session->set_flashdata('success', 'Data Pegawai Berhasil Dihapus');
    	redirect('Anggota_controller/index');
    }

    public function delete($id){
	    $this->tariksimpananpokok_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php
	    $this->session->set_flashdata('success', 'Data Simpanan Sukarela Berhasil Dihapus');
	    redirect($_SERVER['HTTP_REFERER']);
	}
}
