<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Volunteer_apply extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        // $this->load->model('volunteer_manage_model');
    }    
    
    public function index() { 
        $default_month_date = date('Y-m-d',strtotime(date('Y-m-01').'+1 month'));

        $week_list = $this->get_week_list($default_month_date);


        $data['week_list'] = $week_list;
        $this->load->view('volunteer_manage/header');
        $this->load->view('volunteer_apply/volunteer_apply_index',$data);
        $this->load->view('volunteer_manage/footer');
    }


    private function get_week_list($date='2018-12-15'){
        $week_index = array(
            'Sunday' =>0,
            'Monday' =>1,
            'Tuesday' =>2,
            'Wednesday' =>3,
            'Thursday' =>4,
            'Friday' =>5,
            'Saturday' =>6,
        );
        $first_date_in_this_year = $week_index[date('l',strtotime($date))];       

        $less = $first_date_in_this_year;
        $plus = (6-$first_date_in_this_year);

        $week_list = array();
        for ($unix_time=strtotime($date.' -'.$less.' day'); $unix_time <= strtotime($date.' +'.$plus.' day'); $unix_time+=60*60*24)
        { 
            $week_list[] = date('Y-m-d',$unix_time);
        }

        return $week_list;
    }
    
}
