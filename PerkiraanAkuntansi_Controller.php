<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* author inogalwargan
*/

class PerkiraanAkuntansi_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("PerkiraanAkuntansi_model");
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data["perkiraan_akuntansi"] = $this->PerkiraanAkuntansi_model->getAll();
		$data['aktiva_lancar'] = $this->PerkiraanAkuntansi_model->getByJenisAktiva('aktiva_lancar');
        $data['aktiva_tetap'] = $this->PerkiraanAkuntansi_model->getByJenisAktiva('aktiva_tetap');
		$data['penyertaan'] = $this->PerkiraanAkuntansi_model->getByJenisAktiva('penyertaan');
		$data['kewajiban_utang'] = $this->PerkiraanAkuntansi_model->getByJenisAktiva('kewajiban_utang');
		$data['modal_sendiri'] = $this->PerkiraanAkuntansi_model->getByJenisAktiva('modal_sendiri');
		$data['biaya_bunga_modal'] = $this->PerkiraanAkuntansi_model->getByJenisAktiva('biaya_bunga_modal');
		$data['biaya_operasional'] = $this->PerkiraanAkuntansi_model->getByJenisAktiva('biaya_operasional');
		$data['biaya_lainlain'] = $this->PerkiraanAkuntansi_model->getByJenisAktiva('biaya_lainlain');
		$data['biaya_nonoperasional'] = $this->PerkiraanAkuntansi_model->getByJenisAktiva('biaya_nonoperasional');
		$data['pendapatan_operasional'] = $this->PerkiraanAkuntansi_model->getByJenisAktiva('pendapatan_opersional');
        $data['pendapatan_nonopersional'] = $this->PerkiraanAkuntansi_model->getByJenisAktiva('pendapatan_nonoperasional');

        $this->load->view("perkiraan_akuntansi/lihat_Perkiraan", $data);
    }


    public function add()
    {
        $perkiraan_akuntansi = $this->PerkiraanAkuntansi_model;
        $validation = $this->form_validation;
        $validation->set_rules($perkiraan_akuntansi->rules());

        if ($validation->run()) {
            $perkiraan_akuntansi->save();
            $this->session->set_flashdata('success', 'Tambah Akun '.$perkiraan_akuntansi->nama.' Berhasil Disimpan');
            redirect('PerkiraanAkuntansi_controller/index');
        }

        $this->load->view("perkiraan_akuntansi/tambah_akun");
    }

    public function edit($id){

    	$perkiraan_akuntansi = $this->PerkiraanAkuntansi_model; //object model
        $validation = $this->form_validation; //object validasi
        $validation->set_rules($perkiraan_akuntansi->rules()); //terapkan rules di Anggota_model.php

        if ($validation->run()) { //lakukan validasi form
            $perkiraan_akuntansi->update($id); // update data
            $this->session->set_flashdata('success', 'Data'.$perkiraan_akuntansi->getById($id)->nama.' Berhasil Diubah');
            redirect('PerkiraanAkuntansi_controller/index');

        }
        $data['perkiraan_akuntansi'] = $this->PerkiraanAkuntansi_model->getById($id);
        $this->load->view('perkiraan_akuntansi/edit_akun', $data);
    }

    public function hide($id){
    	$this->PerkiraanAkuntansi_model->update($id);
    	$this->session->set_flashdata('success', 'Data Pegawai Berhasil Dihapus');
    	redirect('PekiraanAkuntansi_controller/index');
    }

    public function delete($id){
	    $this->PerkiraanAkuntansi_model->delete($id); // Panggil fungsi delete() yang ada di SiswaModel.php
	    $this->session->set_flashdata('success', 'Data Pegawai Berhasil Dihapus');
	    redirect('PerkiraanAkuntansi_controller/index');
	}

	public function export(){
		// Load plugin PHPExcel nya
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		// Settingan awal fil excel
		$excel->getProperties()->setCreator('Ino Galwargan')
			->setLastModifiedBy('Ino Galwargan')
			->setTitle("Data Pegawai")
			->setSubject("Pegawai")
			->setDescription("Laporan Semua Data Anggota")
			->setKeywords("Data Anggota");
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
			'font' => array('bold' => true), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA PEGAWAI"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "NIS"); // Set kolom B3 dengan tulisan "NIS"
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "JENIS KELAMIN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$excel->setActiveSheetIndex(0)->setCellValue('E3', "ALAMAT"); // Set kolom E3 dengan tulisan "ALAMAT"
		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		// Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
		$anggota = $this->Anggota_model->getAll();
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach($anggota as $data){ // Lakukan looping pada variabel siswa
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->nia);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->nama);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->jenis_kelamin);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->alamat);

			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);

			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}
		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Laporan Data Anggota");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data Anggota.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}
}
