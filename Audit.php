<?php
class Audit extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Audit_model');
    }

    // Fungsi untuk menampilkan semua log audit trail
    public function index() {
        $data['audit_trails'] = $this->Audit_model->get_audit_trails();
        $this->load->view('audit/index', $data);
    }

    
}
