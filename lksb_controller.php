<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* author inogalwargan
*/


class lksb_controller extends MY_Controller
{

    public function generate_pdf()
    {
        $this->load->library('pdf'); // Load library dompdf

        // Ambil data yang diperlukan
        $data["lksb_puskopdit"] = $this->lksb_model->getListlksbneraca();
        $data["total_aktiva_lancar"] = $this->lksb_model->getTotalByJenisAkun('aktiva_lancar');
        $data["total_aktiva_tetap"] = $this->lksb_model->getTotalByJenisAkun('aktiva_tetap');
        $data["total_penyertaan"] = $this->lksb_model->getTotalByJenisAkun('penyertaan');
        $data["total_aktiva_lancar_kemarin"] = $this->lksb_model->getTotalBulanKemarinByJenisAkun('aktiva_lancar');
        $data["total_aktiva_tetap_kemarin"] = $this->lksb_model->getTotalBulanKemarinByJenisAkun('aktiva_tetap');
        $data["total_penyertaan_kemarin"] = $this->lksb_model->getTotalBulanKemarinByJenisAkun('penyertaan');
        $data['total_aktiva'] = $this->lksb_model->total_Aktiva();
        $data['total_aktiva_kemarin'] = $this->lksb_model->total_Aktiva_Kemarin();
        $data["total_kewajiban_utang"] = $this->lksb_model->getTotalByJenisAkun('kewajiban_utang');
        $data["total_kewajiban_utang_kemarin"] = $this->lksb_model->getTotalBulanKemarinByJenisAkun('kewajiban_utang');
        $data["total_modal_sendiri"] = $this->lksb_model->getTotalByJenisAkun('modal_sendiri');
        $data["total_modal_sendiri_kemarin"] = $this->lksb_model->getTotalBulanKemarinByJenisAkun('modal_sendiri');
        $data['total_pasiva'] = $this->lksb_model->total_pasiva();
        $data['total_pasiva_kemarin'] = $this->lksb_model->total_pasiva_Kemarin();

        // Load view to string
        $html = $this->load->view('lksb_puskopdit/lihat_lksb_copy', $data, true);

        // Generate PDF
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->render();
        $this->pdf->stream("lksb_report.pdf", array("Attachment" => 0));
    }
   




    public function __construct()
    {
        parent::__construct();
        $this->load->model("PerkiraanAkuntansi_model");
        $this->load->model("lksb_model");
        $this->load->library('form_validation');
       
    }

    
      





    public function index()
    {
        $data["lksb_puskopdit"] = $this->lksb_model->getListlksb();
        $data["lksb_puskopdit"] = $this->lksb_model->getListlksbneraca();
        $data["total"] = $this->lksb_model->total();
        $data["total_kemarin"] = $this->lksb_model->total_kemarin();
        $data["total_aktiva_lancar"] = $this->lksb_model->getTotalByJenisAkun('aktiva_lancar');
        $data["total_aktiva_tetap"] = $this->lksb_model->getTotalByJenisAkun('aktiva_tetap');
        $data["total_penyertaan"] = $this->lksb_model->getTotalByJenisAkun('penyertaan');
        $data["total_aktiva_lancar_kemarin"] = $this->lksb_model->getTotalBulanKemarinByJenisAkun('aktiva_lancar');
        $data["total_aktiva_tetap_kemarin"] = $this->lksb_model->getTotalBulanKemarinByJenisAkun('aktiva_tetap');
        $data["total_penyertaan_kemarin"] = $this->lksb_model->getTotalBulanKemarinByJenisAkun('penyertaan');
        $data['total_aktiva'] = $this->lksb_model->total_Aktiva();
        $data['total_aktiva_kemarin'] = $this->lksb_model->total_Aktiva_Kemarin();
        $data["total_kewajiban_utang"] = $this->lksb_model->getTotalByJenisAkun('kewajiban_utang');
        $data["total_kewajiban_utang_kemarin"] = $this->lksb_model->getTotalBulanKemarinByJenisAkun('kewajiban_utang');
        $data["total_modal_sendiri"] = $this->lksb_model->getTotalByJenisAkun('modal_sendiri');
        $data["total_modal_sendiri_kemarin"] = $this->lksb_model->getTotalBulanKemarinByJenisAkun('modal_sendiri');
        $data['total_pasiva'] = $this->lksb_model->total_pasiva();
        $data['total_pasiva_kemarin'] = $this->lksb_model->total_pasiva_Kemarin();


        $this->load->view("lksb_puskopdit/lihat_lksb", $data);
    }

   // public function detail($id){
        // $data['anggota'] = $this->SimpananWajib_model->detail_simpanan_pokokall();
       // $data['simpanan_wajib'] = $this->SimpananWajib_model->detail_simpanan_wajib($id);
       // $data['tot'] = $this->SimpananWajib_model->total_simpanan_wajib($id);
        //$this->load->view("simpanan_wajib/detail_simpanan_wajib", $data);
   // }

    public function list_lksb(){
    	$data['perkiraan_akuntansi'] = $this->PerkiraanAkuntansi_model->getAll();
        $this->load->view("lksb_puskopdit/list_lksb", $data);
    }

    public function add($id)
    {   
        $perkiraan_akuntansi = $this->PerkiraanAkuntansi_model;
        $lksb_puskopdit = $this->lksb_model;
        $validation = $this->form_validation;
        $validation->set_rules($lksb_puskopdit->rules());

        if ($validation->run()) {
            $lksb_puskopdit->save();
            $this->session->set_flashdata('success', 'Berhasil Disimpan');
            redirect('lksb_controller/index');
        }
        $data['perkiraan_akuntansi'] = $this->PerkiraanAkuntansi_model->getById($id);
        $this->load->view("lksb_puskopdit/tambah_lksb", $data);
    }

    public function edit($id){
        $perkiraan_akuntansi = $this->PerkiraanAkuntansi_model; //object model
    	$lksb_puskopdit = $this->lksb_model; //object model
        $validation = $this->form_validation; //object validasi
        $validation->set_rules($lksb_puskopdit->rules()); //terapkan rules di Anggota_model.php

        if ($validation->run()) { //lakukan validasi form
            $lksb_puskopdit->update($id); // update data
            $this->session->set_flashdata('success', 'Data  Berhasil Diubah');
            redirect("lksb_controller/index");

        }
         // $data['anggota'] = $this->Anggota_model->getById($id);
     
        $data['lksb_puskopdit'] = $this->lksb_model->getById($id);
        $this->load->view('lksb_puskopdit/edit_lksb', $data);
    }

    // public function hide($id){
    // 	$this->Anggota_model->update($id);
    // 	$this->session->set_flashdata('success', 'Data Pegawai Berhasil Dihapus');
    // 	redirect('Anggota_controller/index');
    // }

    public function delete($id){
	    $this->lksb_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php
	    $this->session->set_flashdata('success', 'Data lksb Berhasil Dihapus');
	    redirect($_SERVER['HTTP_REFERER']);
	}
}
