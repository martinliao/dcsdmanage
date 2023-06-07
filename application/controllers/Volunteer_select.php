<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Volunteer_select extends CI_Controller{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->database('phy');

        $this->load->model('volunteer_select_model');
        $this->load->model('volunteer_manage_model');

        session_start();
        $_SESSION['userID'] = isset($_SESSION['userID'])?$_SESSION['userID']:-1;

        if($_SESSION['userID'] == '-1' || $_SESSION['role_id'] != '19'){
            die('您無此權限');
        }

        $left['list'] = $this->volunteer_manage_model->get_volunteer_category_detail();
        $this->load->view('volunteer_manage/header',$left);

    }    
    
    public function index() { 
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $class_no = $this->input->post('class_no');
        $class_name = $this->input->post('class_name');

        $data['list'] = array();

        if(!empty($year) && !empty($month)){
            $query_start = ($year+1911).'-'.$month.'-01';
            $query_start = date('Y-m-d', strtotime($query_start));
            $query_end =  date('Y-m-t', strtotime($query_start));

            $data['list'] = $this->volunteer_select_model->get_course_detail($query_start,$query_end,$class_no,$class_name);
        }

        $this->load->view('volunteer_manage/volunteer_select_index',$data);
        $this->load->view('volunteer_manage/footer');
    }

    public function Volunteer_select_edit(){
        $cid = $this->uri->segment(3);
        $date = $this->input->post('date');
        $type = $this->input->post('type');
        $mode = $this->input->post('mode');
        $mode2 = $this->input->post('mode2');

        $data['date'] = $date;
        $data['type'] = $type;

        $data['date_list'] = $this->volunteer_select_model->get_course_date_list($cid);
        $data['course'] = $this->volunteer_select_model->get_course_detail_by_id($cid);

        if($mode == 'search'){
            $data['detail'] = array();
            $data['detail'] = $this->volunteer_select_model->get_volunteer_calendar_detail_by_id($cid,$date,$type);
            $data['persons'] = $this->volunteer_select_model->get_person_limit($cid,$date,$type);
        } else if($mode2 == 'save') {
            $data['detail'] = array();
            $post_all = $this->input->post();
            $num_got_it = $this->input->post('num_got_it');
            $vid = $this->input->post('vid');

            $this->volunteer_select_model->upd_volunteer_calendar($vid,$num_got_it);

            foreach ($post_all as $key => $value) {
                if(preg_match("/user/",$key)){
                    $tmp_key = explode('_', $key);
                    $aid = $tmp_key[1];
                    if($value == '1'){
                        $mail = $this->volunteer_select_model->upd_volunteer_calendar_apply($aid,$cid,$date,$type);
                        if(!empty($mail)){
                            $this->sendMail($mail);
                        }
                    } else if($value == '-1'){
                        $mail = $this->volunteer_select_model->del_volunteer_calendar_apply($aid,$cid,$date,$type);
                        if(!empty($mail)){
                            $this->sendMail($mail);
                        }
                    }
                }
            }

            $mail_list = $this->volunteer_select_model->makeup_volunteer_calendar_apply($vid);
            for($i=0;$i<count($mail_list);$i++) { 
                $this->sendMail($mail_list[$i]);
            }
            $data['detail'] = $this->volunteer_select_model->get_volunteer_calendar_detail_by_id($cid,$date,$type);
            $data['persons'] = $this->volunteer_select_model->get_person_limit($cid,$date,$type);
        }

        $this->load->view('volunteer_manage/volunteer_select_edit',$data);
        $this->load->view('volunteer_manage/footer');

    }

    public function Volunteer_add()
    {
        // init
        $data               = array() ;

        $data['id'] = intval($this->input->post('id'));
        $data['year'] = intval($this->input->post('year'));
        $data['class_name'] = addslashes($this->input->post('class_name'));
        $data['term'] = intval($this->input->post('term'));
        $data['sign_date'] = addslashes($this->input->post('sign_date'));
        $data['sign_time'] = intval($this->input->post('sign_time'));

        // 設定
        $data['save_url'] = base_url().'Volunteer_select/Save';
        // 輸出志工
        $data['userList']   = $this->db->where('role_id','20')->get('users')->result();

        // view
        
        $this->load->view('volunteer_manage/volunteer_add' , $data );
        $this->load->view('volunteer_manage/footer');
    }

    public function save()
    {
        $course_id = intval($this->input->post('id'));
        $user_id = intval($this->input->post('uid'));
        $sign_date = addslashes($this->input->post('sign_date'));
        $sign_time = intval($this->input->post('sign_time'));

        $url = base_url().'Volunteer_select/volunteer_select_edit/'.$course_id;
        if(!empty($course_id) && !empty($user_id) && !empty($sign_date) && !empty($sign_time)) {
            $data = $this->volunteer_select_model->getSignDetail($course_id,$sign_date,$sign_time);

            if(!empty($data)){
                $id = intval($data[0]['id']);
                $hours = intval($data[0]['hours']);
                $start_time = addslashes($data[0]['start_time']);
                $end_time = addslashes($data[0]['end_time']);
                $check = $this->volunteer_select_model->sign($user_id, $id, $hours, $start_time, $end_time);

                if($check){
                    echo '<script>alert("報名成功");location.href="'.$url.'";</script>';
                } else {
                    echo '<script>alert("報名失敗");location.href="'.$url.'";</script>';
                }
            } else {
                echo '<script>alert("無符合班期");location.href="'.$url.'";</script>';
            }
        } else {
            echo '<script>alert("資料有誤，請重新報名！");location.href="'.$url.'";</script>';
        }
    }

    public function Volunteer_others_add()
    {
        // init
        $data               = array() ;

        $data['vid'] = intval($this->input->post('add_vid'));
        $name = addslashes($this->input->post('add_name'));
        $sign_date = addslashes($this->input->post('add_date'));
        $sign_type = addslashes($this->input->post('add_type'));

        $data['title'] = $name.'志工 '.(date('Y',$sign_date)-1911).'年'.date('m',$sign_date).'月'.date('d',$sign_date).'日 '.(($sign_type=='1')?'上午':'下午');
       
        // 設定
        $data['save_url'] = base_url().'Volunteer_select/Others_save';
        // 輸出志工
        $data['userList']   = $this->db->where('role_id','20')->get('users')->result();

        // view
        
        $this->load->view('volunteer_manage/volunteer_others_add' , $data);
        $this->load->view('volunteer_manage/footer');
    }

    public function Others_save()
    {
        $vid = intval($this->input->post('vid'));
        $user_id = intval($this->input->post('uid'));
        
        if(!empty($vid) && !empty($user_id)) {
            $data = $this->volunteer_select_model->getSignOthersDetail($vid);
         
            $url = base_url().'Volunteer_select/Volunteer_select_others/'.intval($data[0]['volunteerID']);
            if(!empty($data)){
                $id = intval($data[0]['id']);
                $start_time = addslashes($data[0]['start_time']);
                $end_time = addslashes($data[0]['end_time']);
                $check = $this->volunteer_select_model->signOthers($user_id, $id, $start_time, $end_time);

                if($check){
                    echo '<script>alert("報名成功");location.href="'.$url.'";</script>';
                } else {
                    echo '<script>alert("報名失敗");location.href="'.$url.'";</script>';
                }
            } else {
                echo '<script>alert("無符合班期");location.href="'.$url.'";</script>';
            }
        } else {
            $url = base_url().'Volunteer_select/';
            echo '<script>alert("資料有誤，請重新報名！");location.href="'.$url.'";</script>';
        }
    }

    public function Volunteer_select_others($vcid){
        $volunteer_data = $this->volunteer_select_model->get_volunteer_category($vcid);

        if(!$volunteer_data) {
            die('錯誤的志工資料');
        }

        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $mode = $this->input->post('mode');

        if(!empty($year) && !empty($month)){
            if($mode == 'setting'){
                $day = $this->input->post('day');
                $type = $this->input->post('type');
                $num_got_it = $this->input->post('num_got_it');

                $query_start = ($year+1911).'-'.$month.'-'.'01';
                $first_day = date('Y-m-01', strtotime($query_start));
                $last_day = date('Y-m-t', strtotime($query_start));

                if($num_got_it > 0){
                    for($i=0;$i<count($day);$i++){
                        for($j=0;$j<count($type);$j++){
                            $result = $this->volunteer_select_model->upd_volunteer_calendar_batch(intval($vcid),addslashes($first_day),addslashes($last_day),intval($day[$i]),intval($type[$j]),intval($num_got_it));
                        }
                    }
                   
                    if($result){
                        echo '<script>alert("批次設定成功");</script>';
                    } else {
                        echo '<script>alert("批次設定失敗，請再試一次");</script>';
                    }
                }
            }

            $first_week_day = date("w",strtotime(($year+1911).'-'.$month.'-01'));
            $month_days  = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            $query_start = ($year+1911).'-'.$month.'-'.'01';
            $first_day = date('Y-m-01', strtotime($query_start));
            $last_day = date('Y-m-t', strtotime($query_start));
            $num_got_it_list = $this->volunteer_select_model->get_num_got_it(intval($vcid),addslashes($first_day),addslashes($last_day));

            $data['num_got_it_list'] = array();
            for($i=0;$i<count($num_got_it_list);$i++){
                $data['num_got_it_list'][strtotime($num_got_it_list[$i]['date'])][$num_got_it_list[$i]['type']]['num_got_it'] = $num_got_it_list[$i]['num_got_it'];
            }

            $data['year'] = $year;
            $data['month'] = $month;
            $data['first_week_day'] = $first_week_day;
            $data['month_days'] = $month_days;
        }

        $data['category'] = $volunteer_data;
        $data['vcid'] = $vcid;

        $this->load->view('volunteer_manage/volunteer_select_others',$data);
        $this->load->view('volunteer_manage/footer');
    }

    public function Volunteer_select_others_edit($vcid){
        $volunteer_data = $this->volunteer_select_model->get_volunteer_category($vcid);
        $data['category'] = $volunteer_data;
        $data['vcid'] = $vcid;

        $date = $this->input->post('date');
        $type = $this->input->post('type');
        $mode2 = $this->input->post('mode2');
        if($mode2 == 'save') {
            $post_all = $this->input->post();
            $num_got_it = $this->input->post('num_got_it');
            $vid = $this->input->post('vid');

            $this->volunteer_select_model->upd_volunteer_calendar($vid,$num_got_it);

            foreach ($post_all as $key => $value) {
                if(preg_match("/user/",$key)){
                    $tmp_key = explode('_', $key);
                    $aid = $tmp_key[1];
                    if($value == '1'){
                        $mail = $this->volunteer_select_model->upd_volunteer_calendar_apply_others($aid,$vcid,$date,$type);
                        if(!empty($mail)){
                            $this->sendMail($mail);
                        }
                    } else if($value == '-1'){
                        $mail = $this->volunteer_select_model->del_volunteer_calendar_apply_others($aid,$vcid,$date,$type);
                        if(!empty($mail)){
                            $this->sendMail($mail);
                        }
                    }
                }
            }

            $mail_list = $this->volunteer_select_model->makeup_volunteer_calendar_apply_other($vid,$vcid);
            for($i=0;$i<count($mail_list);$i++) { 
                $this->sendMail($mail_list[$i]);
            }
        }

        if(!empty($date) && !empty($type)){
            $data['detail'] = $this->volunteer_select_model->get_volunteer_calendar_others_detail($vcid,$type,$date);
            $data['persons'] = $this->volunteer_select_model->get_person_limit_others($vcid,$type,$date);
            $data['date'] = $date;
            $data['type'] = $type;
        }
        
        $this->load->view('volunteer_manage/volunteer_select_others_edit',$data);
        $this->load->view('volunteer_manage/footer');
    }

    public function sendMail($mail_data=array()){
        if(isset($mail_data['email']) && !empty($mail_data['email'])){
            include_once('resource/mailer/class.phpmailer.php');
            include_once('resource/mailer/class.smtp.php');

            $mail = new PHPMailer();
            // 设置使用 SMTP
            $mail->IsSMTP(); 
            $body  = $mail_data['body'];
            $body .= "<br><br><br><br><font color='red'>此封信件為系統發出的信件，請勿直接回覆，謝謝！</font>";
            $mail->SMTPAuth = true; 
            $mail->Host = "210.69.61.208"; // SMTP server
            $mail->setFrom('from@192.168.50.29', '臺北e大');
            $mail->Port = 25;
            // SMTP 密码
            $mail->Username = "pstc_apdd"; 
            $mail->Password = "pstc#2347"; 
            $mail->Subject  = $mail_data['title'];
            $mail->CharSet = "UTF-8"; //設定郵件編碼 
            $mail->Encoding = "base64";
            $mail->Body = $body;
            $mail->IsHTML(true);
            $mail->ClearAddresses();
            $mail->AddAddress($mail_data['email']);
            $mail->Send();
        }
    }

}
