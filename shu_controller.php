<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* author inogalwargan
*/


class shu_controller extends MY_Controller
{

    public function generate_pdf()
    {
        $this->load->library('pdf'); // Load library dompdf

        // Ambil data yang diperlukan
        $data["laporan_shu"] = $this->shu_model->getListlaporanshu();
        $data["total_pendapatan_operasional"] = $this->shu_model->getTotalByJenisAkun('pendapatan_operasional');
        $data["total_pendapatan_nonoperasional"] = $this->shu_model->getTotalByJenisAkun('pendapatan_nonoperasional');
        
        $data["total_pendapatan_operasional_kemarin"] = $this->shu_model->getTotalBulanKemarinByJenisAkun('pendapatan_operasional');
        $data["total_pendapatan_nonoperasional_kemarin"] = $this->shu_model->getTotalBulanKemarinByJenisAkun('pendapatan_nonoperasional');
        $data['total_pendapatan'] = $this->shu_model->total_pendapatan();
        $data['total_pendapatan_kemarin'] = $this->shu_model->total_pendapatan_Kemarin();
        $data["total_biaya_bunga_modal"] = $this->shu_model->getTotalByJenisAkun('biaya_bunga_modal');
        $data["total_biaya_bunga_modal_kemarin"] = $this->shu_model->getTotalBulanKemarinByJenisAkun('biaya_bunga_modal');
        $data["total_biaya_operasional"] = $this->shu_model->getTotalByJenisAkun('biaya_operasional');
        $data["total_biaya_operasional_kemarin"] = $this->shu_model->getTotalBulanKemarinByJenisAkun('biaya_operasional');
        $data["total_biaya_nonoperasional"] = $this->shu_model->getTotalByJenisAkun('biaya_nonoperasional');
        $data["total_biaya_nonoperasional_kemarin"] = $this->shu_model->getTotalBulanKemarinByJenisAkun('biaya_nonoperasional');

        $data['total_biaya'] = $this->shu_model->total_biaya();
        $data['total_biaya_kemarin'] = $this->shu_model->total_biaya_Kemarin();

        // Load view to string
        $html = $this->load->view('laporan_shu/lihat_shu_copy', $data, true);

        // Generate PDF
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->render();
        $this->pdf->stream("shu_report.pdf", array("Attachment" => 0));
    }
   




    public function __construct()
    {
        parent::__construct();
        $this->load->model("PerkiraanAkuntansi_model");
        $this->load->model("shu_model");
        $this->load->library('form_validation');
       
    }

    
      





    public function index()
    {
        $data["laporan_shu"] = $this->shu_model->getListshu();
        $data["laporan_shu"] = $this->shu_model->getListlaporanshu();
        $data["total"] = $this->shu_model->total();
        $data["total_kemarin"] = $this->shu_model->total_kemarin();
        $data["total_pendapatan_operasional"] = $this->shu_model->getTotalByJenisAkun('pendapatan_operasional');
        $data["total_pendapatan_nonoperasional"] = $this->shu_model->getTotalByJenisAkun('pendapatan_nonoperasional');
        $data["total_penyertaan"] = $this->shu_model->getTotalByJenisAkun('penyertaan');
        $data["total_pendapatan_operasional_kemarin"] = $this->shu_model->getTotalBulanKemarinByJenisAkun('pendapatan_operasional');
        $data["total_pendapatan_nonoperasional_kemarin"] = $this->shu_model->getTotalBulanKemarinByJenisAkun('pendapatan_nonoperasional');
        $data["total_penyertaan_kemarin"] = $this->shu_model->getTotalBulanKemarinByJenisAkun('penyertaan');
        $data['total_pendapatan'] = $this->shu_model->total_pendapatan();

        $data['total_pendapatan_kemarin'] = $this->shu_model->total_pendapatan_Kemarin();
        $data["total_biaya_bunga_modal"] = $this->shu_model->getTotalByJenisAkun('biaya_bunga_modal');
        $data["total_biaya_bunga_modal_kemarin"] = $this->shu_model->getTotalBulanKemarinByJenisAkun('biaya_bunga_modal');
        $data["total_biaya_operasional"] = $this->shu_model->getTotalByJenisAkun('biaya_operasional');
        $data["total_biaya_nonoperasional"] = $this->shu_model->getTotalByJenisAkun('biaya_nonoperasional');
        $data["total_biaya_nonoperasional_kemarin"] = $this->shu_model->getTotalBulanKemarinByJenisAkun('biaya_nonoperasional');

        $data["total_biaya_operasional_kemarin"] = $this->shu_model->getTotalBulanKemarinByJenisAkun('biaya_operasional');
        $data['total_biaya'] = $this->shu_model->total_biaya();
        $data['total_biaya_kemarin'] = $this->shu_model->total_biaya_Kemarin();

        $data['shu_tahun_berjalan'] = $this->shu_model->shu_tahun_berjalan();
        $data['shu_tahun_berjalan_kemarin'] = $this->shu_model->shu_tahun_berjalan_kemarin();
        $data['shu_setelah_pajak'] = $this->shu_model->shu_setelah_pajak();
        $data['shu_setelah_pajak_kemarin'] = $this->shu_model->shu_setelah_pajak_kemarin();

        $data["total_biaya_lainlain"] = $this->shu_model->getTotalByJenisAkun('biaya_lainlain');
        $data["total_biaya_lainlain_kemarin"] = $this->shu_model->getTotalBulanKemarinByJenisAkun('biaya_lainlain');

        $this->load->view("laporan_shu/lihat_shu", $data);
    }

   // public function detail($id){
        // $data['anggota'] = $this->SimpananWajib_model->detail_simpanan_pokokall();
       // $data['simpanan_wajib'] = $this->SimpananWajib_model->detail_simpanan_wajib($id);
       // $data['tot'] = $this->SimpananWajib_model->total_simpanan_wajib($id);
        //$this->load->view("simpanan_wajib/detail_simpanan_wajib", $data);
   // }

    public function list_shu(){
    	$data['perkiraan_akuntansi'] = $this->PerkiraanAkuntansi_model->getAll();
        $this->load->view("laporan_shu/list_shu", $data);
    }

    public function add($id)
    {   
        $perkiraan_akuntansi = $this->PerkiraanAkuntansi_model;
        $laporan_shu = $this->shu_model;
        $validation = $this->form_validation;
        $validation->set_rules($laporan_shu->rules());

        if ($validation->run()) {
            $laporan_shu->save();
            $this->session->set_flashdata('success', 'Berhasil Disimpan');
            redirect('shu_controller/index');
        }
        $data['perkiraan_akuntansi'] = $this->PerkiraanAkuntansi_model->getById($id);
        $this->load->view("laporan_shu/tambah_shu", $data);
    }
    



    public function edit($id){
        $perkiraan_akuntansi = $this->PerkiraanAkuntansi_model; //object model
    	$laporan_shu = $this->shu_model; //object model
        $validation = $this->form_validation; //object validasi
        $validation->set_rules($laporan_shu->rules()); //terapkan rules di Anggota_model.php

        if ($validation->run()) { //lakukan validasi form
            $laporan_shu->update($id); // update data
            $this->session->set_flashdata('success', 'Data  Berhasil Diubah');
            redirect("shu_controller/index");

        }
         // $data['anggota'] = $this->Anggota_model->getById($id);
     
        $data['laporan_shu'] = $this->shu_model->getById($id);
        $this->load->view('laporan_shu/edit_shu', $data);
    }

    // public function hide($id){
    // 	$this->Anggota_model->update($id);
    // 	$this->session->set_flashdata('success', 'Data Pegawai Berhasil Dihapus');
    // 	redirect('Anggota_controller/index');
    // }

    public function delete($id){
	    $this->shu_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php
	    $this->session->set_flashdata('success', 'Data shu Berhasil Dihapus');
	    redirect($_SERVER['HTTP_REFERER']);
	}
    


    
    
    
}
