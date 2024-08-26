<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('lksb_model');
    }

    public function generatePDF()
    {
        // Load Dompdf library
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        // Fetch data from the model
        $data['lksb_puskopdit'] = $this->lksb_model->getListlksbneraca();
        $data['total_aktiva_lancar'] = $this->lksb_model->getTotalByJenisAkun('aktiva_lancar');
        $data['total_aktiva_lancar_kemarin'] = $this->lksb_model->getTotalBulanKemarinByJenisAkun('aktiva_lancar');
        $data['total_penyertaan'] = $this->lksb_model->getTotalByJenisAkun('penyertaan');
        $data['total_penyertaan_kemarin'] = $this->lksb_model->getTotalBulanKemarinByJenisAkun('penyertaan');
        $data['total_aktiva_tetap'] = $this->lksb_model->getTotalByJenisAkun('aktiva_tetap');
        $data['total_aktiva_tetap_kemarin'] = $this->lksb_model->getTotalBulanKemarinByJenisAkun('aktiva_tetap');
        $data['total_aktiva'] = $this->lksb_model->total_Aktiva();
        $data['total_aktiva_kemarin'] = $this->lksb_model->total_Aktiva_Kemarin();
        $data['total_pasiva'] = $this->lksb_model->total_pasiva();
        $data['total_pasiva_kemarin'] = $this->lksb_model->total_pasiva_kemarin();

        // Load the view
        $html = $this->load->view('pdf_template', $data, true);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF (force download)
        $dompdf->stream('report.pdf', array('Attachment' => 0));
    }
}
