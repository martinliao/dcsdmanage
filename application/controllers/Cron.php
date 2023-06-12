<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller
{
    protected $testdate = NULL;

    public function __construct()
    {
        parent::__construct();
        // Limit it to CLI requests only using built-in CodeIgniter function
        if ((strcmp(ENVIRONMENT, 'production') == 0)) {
            if (!is_cli()) exit('Only CLI access allowed');
        } else {
            $this->testdate = '2023-06-14';
            $this->testdate = new DateTime('2023-06-09 12:00:00');
        }
        $this->load->database('phy');
        $this->load->model('Cron_model');
        $this->load->model('Manager_model');
        $this->load->model('volunteer_select_model');
        $this->load->model('volunteer_manage_model');

        $this->load->helper('mail');
    }

    /**
     * 1. 取所有下週的 calendar
     * 2. 比對 calendar_apply: 有人/沒人
     * 3. 發 mail
     */
    public function notify_course_admin()
    {
        $nextWeek = $this->getNextWeekDays($this->testdate);
        // iterate: foreach($nextWeek as $date) { }
        $startDate = $nextWeek[0]->format('Y-m-d');
        $endDate = $nextWeek[sizeof($nextWeek) - 1]->format('Y-m-d');
        echo "*** Next week[{$startDate} ~ {$endDate}] notify.<br/>";
        $classEvents = $this->Cron_model->getClassCalendarEvents($startDate, $endDate);
        foreach($classEvents as $courseID => $events) {
            echo "    {$courseID} is  processing...<br/>";
            // foreach($events as $evt) {
            //     $this->sendCourseAdminMail($courseID, $evt['date'], $evt['type'], 'martin@click-ap.com');
            // }
            // Multi-days aware:
            $this->courseEvents($courseID, $events, 'jack@click-ap.com');
        }
        echo "*** Notify class-admin is done<br/>";
    }

    private function courseEvents($courseID, $courseEvents, $adminMail)
    {
        $course = $this->Cron_model->getCourse_by_id($courseID);
        $courseName = "{$course->name}({$courseID})";
        //$dateRange = $courseEvents[0]['date'];
        //$dateRange = (sizeof($courseEvents) > 0) ? $dateRange . '~' . $courseEvents[sizeof($courseEvents)-1]['date'] : $dateRange;
        $startDate = $courseEvents[0]['date'];
        $endDate = $courseEvents[sizeof($courseEvents)-1]['date'];
        //$emptyVols = $this->processCourseEvents($cours, $startDate, $endDate, $adminMail);
        $bodys = array();
        $emptyBodys = array();
        foreach($courseEvents as $event) {
            //debugBreak();
            list($vol, $emptyVol) = $this->processCourseAdminEvent($courseID, $event['date'], $event['type']);
            if (!empty($vol)) {
                $bodys[] = $vol;
            } else {
                $emptyBodys[] = $emptyVol;
            }
        }
        if (sizeof($emptyBodys) > 0 ) {
            echo "*** 沒有志工時段: "; 
            var_dump($emptyBodys);
debugBreak();
            $this->sendCourseAdminMail2($courseName, implode('<br/>', $emptyBodys), $adminMail);
        } else {
            $this->sendCourseAdminMail1($courseName, implode('<br/>', $bodys), $adminMail);
        }
    }

    private function processCourseAdminEvent($cid, $date, $type)
    {
        //$body = "下週班務志工如下:<br/>班期名稱: {$courseName}<br/>";
        // 取得志工
        $detail = $this->Cron_model->getClassCalendarDetail($cid, $date, $type);
        $body = '';
        $emptyVols = '';
        $_type= $this->Cron_model->getType($type);
        if (sizeof($detail) == 0) {
            $emptyVols = "日期: {$date}, 時段: $_type";
        } else {
            $event = $detail[0];
            $_volNames = array_column($detail, 'name');
            $volList = implode(', ', $_volNames);
            $body = "
                日期: {$date} - $_type<br/>
                志工: {$volList}<br/>
                服務時間: {$event['start_time']} ~ {$event['end_time']}<br/>";
            $body;
        }
        return array($body, $emptyVols);
    }

    /**
     * Send Class volunteers register to course-admin.
     */
    private function sendCourseAdminMail1($courseName, $body, $adminMail)
    {
        // Specify Course-admin
        $catName = '班務';
        $adminMails = $adminMail;
        if (!is_array($adminMail)) {
            $adminMails = [$adminMail];
        }
        $body = "下週班務志工如下:<br/>班期名稱: {$courseName}<br/>" . $body;
        foreach ($adminMails as $cat => $email) {
            $_mail = array(
                'title' => "下週班務志工通知",
                'body' => $body,
                'email' => $email
            );
            sendMail($_mail);
        }
    }
    /**
     * Send Class volunteers non-body to course-admin.
     */
    private function sendCourseAdminMail2($courseName, $body, $adminMail)
    {
        // Specify Course-admin
        $catName = '班務';
        $adminMails = $adminMail;
        if (!is_array($adminMail)) {
            $adminMails = [$adminMail];
        }
        //$body = "下週班務志工如下:<br/>班期名稱: {$courseName}<br/>" . $body;
        $body = "下週*沒有志工*的班期: {$courseName}<br/>" . $body;
        foreach ($adminMails as $cat => $email) {
            $_mail = array(
                'title' => "下週班務*沒有志工*通知",
                'body' => $body,
                'email' => $email
            );
            sendMail($_mail);
        }
    }

    /**
     * Notify every-cagegory-admin via cronjob
     * The cronjob settings:
     *  12 0 * * 5 php index.php Cron/notify
     */
    public function notify_admin()
    {
        $cateNames = $this->Cron_model->getCategoryNames();
        $catAdminMails = [];
        $users = $this->Manager_model->getManagers(true);
        foreach ($users as $user) {
            $cats = explode('|', $user->category_admin);
            foreach ($cats as $cat) {
                if (isset($catAdminMails[$cat])) {
                    array_push($catAdminMails[$cat], $user->email);
                } else {
                    $catAdminMails[$cat] = array($user->email);
                }
            }
        }
        $nextWeek = $this->getNextWeekDays($this->testdate);
        // iterate: foreach($nextWeek as $date) { }
        $startDate = $nextWeek[0];
        $endDate = $nextWeek[sizeof($nextWeek) - 1];
        echo "*** Next week[{$startDate->format('Y-m-d')} ~ {$endDate->format('Y-m-d')}] notify.<br/>";
        $day = $startDate->format('Y-m-d');
        foreach ($catAdminMails as $type => $value) {
            //$this->sendAdminMail($cid, $day, $type, $cateNames[$type] ,$catAdminMails[$type]);
            echo "    {$cateNames[$type]}({$type}) processing...<br/>";
            // 其它非班務(NON-Class)
            $this->sendAdminMail($day, $type, $cateNames[$type], $catAdminMails[$type]);
            echo "    {$cateNames[$type]}({$type}) done.<br/>";
        }
        echo "*** Notify other-admin is done<br/>";
    }

    /**
     * Send specific OTHERS volunteers register to admin.
     */
    private function sendAdminMail($date, $type, $catName, $adminMails)
    {
        // 取得志工
        //$detail = $this->volunteer_select_model->get_volunteer_calendar_detail_by_id($cid, $date, $type);
        $detail = $this->Cron_model->getCalendarDetail($date, $type);
        $volNames = '';
        foreach ($detail as $event) {
            $volNames .= $event['name'];
        }
        if (sizeof($detail) > 0) {
            //$_date = (date('Y', strtotime($date)) - 1911) . '年' . date('m', strtotime($date)) . '月' . date('d', strtotime($date)) . '日';
            $timestamp = strtotime($date);
            $body = "下週{$catName}志工如下:<br/>
                https://elearning.taipei/eda/apply/volunteer_apply/publish_detail/{$timestamp}?vID[{$type}]=1";
            foreach ($adminMails as $cat => $email) {
                $_mail = array(
                    'title' => "下週{$catName}志工通知",
                    'body' => $body,
                    'email' => $email
                );
                sendMail($_mail);
            }
        }
    }

    private function getNextWeekDays($dt = NULL)
    {
        if (!isset($dt)) {
            $dt = new DateTime();
        }
        // create DateTime object with current time
        $dt->setISODate($dt->format('o'), $dt->format('W') + 1);
        // set object to Monday on next week
        $periods = new DatePeriod($dt, new DateInterval('P1D'), 6);
        // get all 1day periods from Monday to +6 days
        $days = iterator_to_array($periods);
        // convert DatePeriod object to array
        //print_r($days);
        return $days;
    }
}
