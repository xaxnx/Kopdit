<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* author inogalwargan
*/

class koreksi_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("PerkiraanAkuntansi_model");
        $this->load->model("shu_model");
        $this->load->model("koreksi_model");
        $this->load->library('form_validation');
    }

    








    public function index()
    {
        
        
        $data['koreksi_fiskal'] = $this->koreksi_model->getALL();

        $data['koreksi_fiskal'] = $this->koreksi_model->get_koreksi_fiskal();
        $jenis_akun_list = ['pendapatan_operasional', 'pendapatan_nonoperasional', 'biaya_bunga_modal', 'biaya_operasional', 'biaya_nonoperasional']; // Sesuaikan dengan jenis akun Anda
        $data['total_by_jenis_akun'] = [];
        foreach ($jenis_akun_list as $jenis_akun) {
            $data['total_by_jenis_akun'][$jenis_akun] = $this->koreksi_model->get_total_by_jenis_akun($jenis_akun);
        }
        $data["total_pendapatan_operasional"] = $this->koreksi_model->getTotalsekarangByJenisAkun('pendapatan_operasional');
        $data['total_koreksi_positif_operasional'] = $this->koreksi_model->getTotalpositifByJenisAkun('pendapatan_operasional');
        $data['total_koreksi_negatif_operasional'] = $this->koreksi_model->getTotalnegatifByJenisAkun('pendapatan_operasional');
        $data["total_pendapatan_nonoperasional"] = $this->koreksi_model->getTotalsekarangByJenisAkun('pendapatan_nonoperasional');
        $data['total_koreksi_positif_nonoperasional'] = $this->koreksi_model->getTotalpositifByJenisAkun('pendapatan_nonoperasional');
        $data['total_koreksi_negatif_nonoperasional'] = $this->koreksi_model->getTotalnegatifByJenisAkun('pendapatan_nonoperasional');
        $data["total_biaya_bunga_modal"] = $this->koreksi_model->getTotalsekarangByJenisAkun('biaya_bunga_modal');
        $data['total_koreksi_positif_biaya_bunga'] = $this->koreksi_model->getTotalpositifByJenisAkun('biaya_bunga_modal');
        $data['total_koreksi_negatif_biaya_bunga'] = $this->koreksi_model->getTotalnegatifByJenisAkun('biaya_bunga_modal');
        $data['total_biaya_operasional'] = $this->koreksi_model->getTotalsekarangByJenisAkun('biaya_operasional');
        $data['total_koreksi_positif_biaya_operasional'] = $this->koreksi_model->getTotalpositifByJenisAkun('biaya_operasional');
        $data['total_koreksi_negatif_biaya_operasional'] = $this->koreksi_model->getTotalnegatifByJenisAkun('biaya_operasional');
        $data['total_biaya_nonoperasional'] = $this->koreksi_model->getTotalsekarangByJenisAkun('biaya_nonoperasional');
        $data['total_koreksi_positif_biaya_nonoperasional'] = $this->koreksi_model->getTotalpositifByJenisAkun('biaya_nonoperasional');
        $data['total_koreksi_negatif_biaya_nonoperasional'] = $this->koreksi_model->getTotalnegatifByJenisAkun('biaya_nonoperasional');


        
        $this->load->view("koreksi_fiskal/lihat_koreksi", $data);
    }

    

    public function detail($id){
        // $data['anggota'] = $this->SimpananWajib_model->detail_simpanan_pokokall();
        $data['simpanan_wajib'] = $this->SimpananWajib_model->detail_simpanan_wajib($id);
        $data['tot'] = $this->SimpananWajib_model->total_simpanan_wajib($id);
        $this->load->view("simpanan_wajib/detail_simpanan_wajib", $data);
    }

    public function list_koreksi(){
    	
        $data['koreksi_fiskal_details'] = $this->koreksi_model->get_koreksi_fiskal_with_details();

        $this->load->view("koreksi_fiskal/list_koreksi", $data);
    }

    public function add($id_Akuntansi, $id_shu) {   
        $perkiraan_akuntansi = $this->PerkiraanAkuntansi_model->getById($id_Akuntansi);
        $laporan_shu = $this->shu_model->getById($id_shu);
        $koreksi_fiskal = $this->koreksi_model;
        $validation = $this->form_validation;
        $validation->set_rules($koreksi_fiskal->rules());
    
        if ($validation->run()) {
            $data = array(
                'id_Akuntansi' => $id_Akuntansi,
                'id_shu' => $id_shu,
                'nomor_akun' => $this->input->post('nomor_akun'),
                'nama_akun' => $this->input->post('nama_akun'),
                'bulan_sekarang' => $this->input->post('bulan_sekarang'),
                'koreksi_positif' => $this->input->post('koreksi_positif'),
                'koreksi_negatif' => $this->input->post('koreksi_negatif')
            );
            $koreksi_fiskal->save($data);
            $this->session->set_flashdata('success', 'Berhasil Disimpan');
            redirect('koreksi_controller/index');
        }
        
        $data['perkiraan_akuntansi'] = $perkiraan_akuntansi;
        $data['laporan_shu'] = $laporan_shu;
    
        $this->load->view("koreksi_fiskal/tambah_koreksi", $data);
    
    }
    public function edit($id){
        $perkiraan_akuntansi = $this->PerkiraanAkuntansi_model; //object model
    	$laporan_shu = $this->shu_model; //object model
        $koreksi_fiskal = $this->koreksi_model;
        $validation = $this->form_validation; //object validasi
        $validation->set_rules($koreksi_fiskal->rules()); //terapkan rules di Anggota_model.php

        if ($validation->run()) { //lakukan validasi form
            $koreksi_fiskal->update($id); // update data
            $this->session->set_flashdata('success', 'Data  Berhasil Diubah');
            redirect("koreksi_controller/index");

        }
         // $data['anggota'] = $this->Anggota_model->getById($id);
     
        $data['koreksi_fiskal'] = $this->koreksi_model->getById($id);
        $this->load->view('koreksi_fiskal/edit_koreksi', $data);
    }


    


    // public function hide($id){
    // 	$this->Anggota_model->update($id);
    // 	$this->session->set_flashdata('success', 'Data Pegawai Berhasil Dihapus');
    // 	redirect('Anggota_controller/index');
    // }
   public function delete($id)
{
    $this->koreksi_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php
    $this->session->set_flashdata('success', 'Data koreksi fiskal Berhasil Dihapus');
    redirect($_SERVER['HTTP_REFERER']);
}
   


   

    
    

    
}
