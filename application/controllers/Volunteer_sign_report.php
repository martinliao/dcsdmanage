<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Volunteer_sign_report extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->database('phy');

        $this->load->model('volunteer_select_model');
        $this->load->model('volunteer_manage_model');

        session_start();
        $_SESSION['userID'] = isset($_SESSION['userID'])?$_SESSION['userID']:-1;

        // 測試機DEBUG用
        if($_SERVER['HTTP_HOST'] == '172.16.10.31')
        {
            $_SESSION['userID'] = 1;
            $_SESSION['role_id'] = 36;
        }


        if($_SESSION['userID'] == '-1' || $_SESSION['role_id'] != '19'){
            die('您無此權限');
        }

        $left['list'] = $this->volunteer_manage_model->get_volunteer_category_detail2();
        $this->load->view('volunteer_manage/header',$left);

    }    
    
    public function index() { 
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $name = $this->input->post('firstname');
        $category = $this->input->post('category');

        $data['category'] = $this->volunteer_manage_model->get_volunteer_category_detail2();
        
        $users_name =  $this->volunteer_manage_model->get_users_name() ;
        $name_array = [];

        foreach ($users_name as $row => $name)
        {
            $name_array[] = $name['name'] ;
        }

        $data['name_array'] = $name_array ;
// seedata($name_array ,1);
        $this->load->view('volunteer_manage/volunteer_sign_report',$data);
        $this->load->view('volunteer_manage/footer');
    }

    public function volunteer_traffic_report(){
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $category = $this->input->post('category');

        $data['category'] = $this->volunteer_manage_model->get_volunteer_category_detail2();

        $this->load->view('volunteer_manage/volunteer_traffic_report',$data);
        $this->load->view('volunteer_manage/footer');
    }

    public function Volunteer_sign_report_output() 
    {   
        $year = $this->input->post('year');
        $month_start = $this->input->post('month_start');
        $month_end = $this->input->post('month_end');
        $name = $this->input->post('firstname');
        $category = $this->input->post('category');

        //把all刪掉，只留ID
        if (($key = array_search("all", $category)) !== false) 
        {
            unset($category[$key]);
        }

        $volunteer_category = [] ;
        $category_id = '';
        foreach ($category as $row => $id )
        {
            $volunteer_category[$row] = $this->volunteer_manage_model->get_volunteer_category($id);
            $category_id .= $id.',';
        }

        $category_id = substr($category_id, 0,-1);

        $detail = $this->volunteer_manage_model->get_volunteer_sign_report($name,$year,$month_start,$month_end,$category_id);

   // seedata ($volunteer_category,1);
        $this->load->library('Download_xlsx');

        $this->download_xlsx->Volunteer_sign_report_output($volunteer_category,$detail,$name,$month_start,$month_end,$year);

    }

    public function volunteer_traffic_report_output() 
    {   
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $category = $this->input->post('category');

        //把all刪掉，只留ID
        if (($key = array_search("all", $category)) !== false) 
        {
            unset($category[$key]);
        }

        $volunteer_category = [] ;
        $category_id = '';
        foreach ($category as $row => $id )
        {
            $volunteer_category[$row] = $this->volunteer_manage_model->get_volunteer_category($id);
            $category_id .= $id.',';
        }

        $category_id = substr($category_id, 0,-1);

        $detail = $this->volunteer_manage_model->get_volunteer_traffic_report($year,$month,$category_id);
           
        $this->load->library('Download_xlsx');

        $this->download_xlsx->volunteer_traffic_report_output($volunteer_category,$detail,$year,$month);

    }

}
