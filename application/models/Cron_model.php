<?php

class Cron_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		//$this->load->database('dcsdphy'); // NOT phy
	}

	/*
		Volunteer_select_model->get_volunteer_calendar_detail_by_id($cid,$date,$type,$aid='')
		Call by sendAdminMail
	/** */
	function getCalendarDetail($date, $type, $aid = NULL)
	{
		$this->db->select('vc.id, vc.num_got_it, vc.num_waiting, apply.id as aid, apply.got_it, apply.start_time, apply.end_time, u.name, u.email');
		$this->db->from('volunteer_calendar vc');
		$this->db->join('volunteer_calendar_apply apply', 'vc.id = apply.calendarid');
		$this->db->join('users u', 'u.id = apply.userid');

		$this->db->where('vc.courseid is null', NULL);
		$this->db->where('vc.status', '1');
		$this->db->where('vc.date', $date);
		$this->db->where('vc.type', $type);
		if (!empty($aid)) {
			$this->db->where('apply.id', $aid);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	function getClassCalendarEvents($startDate, $endDate)
	{
		$this->db->select('*');
		$this->db->from('volunteer_calendar vc');
		$this->db->where('vc.courseid is not null', NULL);
		$this->db->where('vc.status', '1');
		//$this->db->where('vc.date BETWEEN ' . $startDate . ' AND ' . $endDate);
		$this->db->where('vc.date >=', $startDate);
		$this->db->where('vc.date <=', $endDate);
		$this->db->order_by('vc.courseID, vc.date, vc.type');
		$query = $this->db->get();
		if (! $query ) {
			return array();
		} else {
			$courseEvents = array();
        	foreach($query->result_array() as $event) {
				$_id = $event['courseID'];
				if (isset($courseEvents[$_id])) {
                    array_push($courseEvents[$_id], $event);
                } else {
                    $courseEvents[$_id] = array($event);
                }
        	}
			return $courseEvents;
		}
	}
	
	function getClassCalendarDetail($cid, $date, $type, $aid = NULL)
	{
		$this->db->select('vc.id, vc.num_got_it, vc.num_waiting, apply.id as aid, apply.got_it, apply.start_time, apply.end_time, u.name, u.email');
		$this->db->from('volunteer_calendar vc');
		$this->db->join('volunteer_calendar_apply apply', 'vc.id = apply.calendarid');
		$this->db->join('users u', 'u.id = apply.userid');

		$this->db->where('vc.courseid', $cid);
		$this->db->where('vc.status', '1');
		$this->db->where('vc.date', $date);
		$this->db->where('vc.type', $type);
		if (!empty($aid)) {
			$this->db->where('apply.id', $aid);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	function getCategoryNames() {
		$select = 'id, name';
		$query = $this->db->select($select)->where('show', 1)->get('volunteer_category');
		$cateList = [];
		foreach($query->result() as $row) {
			$cateList[$row->id] = $row->name;
		}
		return $cateList;
	}

	function getCourse_by_id($id){
		$query = $this->db->where('id',$id)->get('course');
		return $query->row();
	}

	/** Deprecated */
	function mailDetail($aid, $cid, $date, $type)
	{
		$_date = (date('Y', strtotime($date)) - 1911) . '年' . date('m', strtotime($date)) . '月' . date('d', strtotime($date)) . '日';
		$title = '提醒公訓處志工 -' . $date . '(班務志工)';
		$body = 'Dear ' . ' 先生/小姐, 您好:<br>
				感謝您支持:臺北市政府公務人員訓練處志工隊之志願服務，<br>
				有關您選填:' . $_date . ' ' . $detail[0]->start_time . '~' . $detail[0]->end_time . '<br>
				班期名稱:' . $course[0]->name . '<br>
				原為候補第一順位，因正取人員取消，<br>
				<font color="red">已晉升為正取!</font>屆時請您如期支援該班期，特來信通知，萬分感謝!!';

		$mail = array(
			'title' => $title,
			'body' => $body,
			'email' => $detail[0]->email,
		);
		return $mail;
	}

	function getType($type)
	{
		$TIME_TYPE_INDEX = array(
			1 => '上午',
			2 => '下午',
			3 => '晚上',
		);
		return $TIME_TYPE_INDEX[$type];
	}
}
