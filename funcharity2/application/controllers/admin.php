<?php
class Admin extends CI_Controller{
 
	function __construct(){
		parent::__construct();
	
		if($this->session->userdata('status') != "login"){
			redirect(base_url("index.php/login"));
		}
		$this->load->helper('form');
		$this->load->model('agenda_m');
	}
 
	function index(){
		$data['agenda'] = $this->agenda_m->getAgendaCount();
		$data['donasi'] = $this->agenda_m->getDonasiCount();
		$this->load->view('dashboard',$data);
	}
    
	function form_agenda() {
		$data['title']= 'Admin FunCharity';
        $data['groups'] = $this->agenda_m->getAllAdmin();
        $this->load->view('buat_agenda',$data);
	}
	
	
	//insert table agenda
    function create_agenda(){
		
		$data = array(
			'judul_agenda' => $this->input->post('judulAgenda'),
			'alamat_agenda' => $this->input->post('alamatAgenda'),
			'tgl_setor' => $this->input->post('tglSetor'),
			'target_dana' => $this->input->post('targetDana'),
			'deskripsi_agenda' => $this->input->post('deskripsiAgenda'),
			'no_admin' => $this->input->post('adminChooice')
		);
				
		$insert = $this->agenda_m->insert_agenda($data);
		if($insert){
			echo "<script>alert ('Berhasil Menambahkan berhasil di Tambahkan'); window.location.href='".base_url()."index.php/admin/agenda_table'</script>";
		}else{
			echo "<script>alert ('Terjadi kesalahan saat menambahkan Agend'); window.location.href='".base_url()."index.php/admin/index'</script>";
		}
	}
    
	//view table agenda
    function agenda_table(){
		$this->load->database();
		$jumlah_data = $this->agenda_m->jumlah_data();
		$this->load->library('pagination');
		$config['base_url'] = base_url().'index.php/admin/agenda_table/';
		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = 6;
		$from = $this->uri->segment(3);
		$this->pagination->initialize($config);		
		$data['agenda'] = $this->agenda_m->data($config['per_page'],$from);
        $this->load->view('tabel_agenda.php',$data);
    }
    
  
	//delete from table agenda
	function delete_agenda($no_agenda){
		$del = $this->agenda_m->delete_agenda($no_agenda);
			if($del){
				redirect('admin/agenda_table');
			}
			else{
				echo "gagal";
			}	
	}
	
	//edit from table agenda
	function edit_age($no_agenda){
		$data['agenda'] = $this->agenda_m->show_agenda($no_agenda);
		$this->load->view('edit_agenda',$data);
	}
	
	function action_edit_agenda(){
			
			$id= $this->input->post('kodeAgenda');
			$value = array(
				'judul_agenda' => $this->input->post('judulAgenda'),
				'alamat_agenda' => $this->input->post('alamatAgenda'),
				'tgl_setor' => $this->input->post('tglSetor'),
				'target_dana' => $this->input->post('targetDana'),
				'deskripsi_agenda' => $this->input->post('deskripsiAgenda'),
				'no_admin' => $this->input->post('adminChooice')
			);
			$this->agenda_m->edit_agendas($id,$value);
			redirect('admin/agenda_table');
	}
	
	//view table donatur
	
	function donatur_table(){
		$this->load->database();
		$jumlah_data = $this->agenda_m->jumlah_data();
		$this->load->library('pagination');
		$config['base_url'] = base_url().'index.php/admin/agenda_table/';
		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = 6;
		$from = $this->uri->segment(3);
		$this->pagination->initialize($config);		
		$data['donatur'] = $this->agenda_m->data2($config['per_page'],$from);
        $this->load->view('tabel_donatur.php',$data);
    }
	
}
?>