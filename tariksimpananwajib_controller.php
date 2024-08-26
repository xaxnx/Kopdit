<?php defined('BASEPATH') OR exit('No direct script access allowed');


class tariksimpananwajib_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Anggota_model");
        $this->load->model("tariksimpananwajib_model");
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["anggota"] = $this->Anggota_model->getAll();
        $this->load->view("tarik_simpananwajib/lihat_tarik_simpananwajib", $data);
    }

    public function detail($id){

        // $data['anggota'] = $this->SimpananWajib_model->detail_simpanan_pokokall();
        $data['tarik_simpananwajib'] = $this->tariksimpananwajib_model->detail_tarik_simpananwajib($id);
        $data['tot'] = $this->tariksimpananwajib_model->total_tarik_simpananwajib($id);
        $this->load->view("tarik_simpananwajib/detail_tarik_simpananwajib", $data);
    }

    public function add($id)
    {   
        $anggota = $this->Anggota_model;
        $tarik_simpananwajib = $this->tariksimpananwajib_model;
        $validation = $this->form_validation;
        $validation->set_rules($tarik_simpananwajib->rules());

        if ($validation->run()) {
            $tarik_simpananwajib->save();
            $this->session->set_flashdata('success', 'Tambah Simpanan Sukarela Sebesar Rp. '.$tarik_simpananwajib->jumlah.' Berhasil Disimpan');
            redirect('tariksimpananwajib_controller/index');
        }
        $data['anggota'] = $this->Anggota_model->getById($id);
        $this->load->view("tarik_simpananwajib/tambah_tarik_simpananwajib", $data);
    }

    public function edit($id){
        $anggota = $this->Anggota_model; //object model
    	$tarik_simpananwajib = $this->tariksimpananwajib_model; //object model
        $validation = $this->form_validation; //object validasi
        $validation->set_rules($tarik_simpananwajib->rules()); //terapkan rules di Anggota_model.php

        if ($validation->run()) { //lakukan validasi form
            $tarik_simpananwajib->update($id); // update data
            $this->session->set_flashdata('success', 'Data Simpanan Sukarela Sebesar Rp. '.$tarik_simpananwajib->getById($id)->jumlah.' Berhasil Diubah');
            redirect($_SERVER ['HTTP_REFERER']);

        }
        $data['tarik_simpananwajib'] = $this->tariksimpananwajib_model->getById($id);
        $this->load->view('tarik_simpananwajib/edit_tarik_simpananwajib', $data);
    }

    public function hide($id){
    	$this->Anggota_model->update($id);
    	$this->session->set_flashdata('success', 'Data Pegawai Berhasil Dihapus');
    	redirect('Anggota_controller/index');
    }

    public function delete($id){
	    $this->tariksimpananwajib_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php
	    $this->session->set_flashdata('success', 'Data Simpanan Sukarela Berhasil Dihapus');
	    redirect($_SERVER['HTTP_REFERER']);
	}
}
