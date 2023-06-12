<?php

class Manager_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database('dcsdphy'); // NOT phy
	}

	public function getManagers($admin = TRUE)
	{
		if ($admin) {
			return $this->db->where('category_admin is not null', null)->get('users')->result();
		} else {
			$query = $this->db->select('id, name')->where('category_admin is null', null)->get('users');
			$userList = [];
			foreach($query->result() as $row)
			{
				$userList[$row->id] = $row->name;
			}
			return $userList;
		}
	}

	public function wrapManagers($users)
	{
		foreach ($users as $each) {
			$category_name_list = '';
			$category_list = explode('|', $each->category_admin);
			for($i=0; $i < count($category_list) ; $i++) {
				$category_name = $this->volunteer_manage_model->get_volunteer_category(intval($category_list[$i]));
				if(!empty($category_name)){
					$category_name_list .= $category_name['name'].',';
				}
			}
			if(!empty($category_name_list)){
				$each->category_list = substr($category_name_list, 0 , -1);
			} else {
				$each->category_list = '';
			}
		}
		return $users;
	}

	function getPhyBookingPlace($year, $classNo, $term)
	{
		//e.g. SELECT * FROM booking_place WHERE YEAR=112 AND class_no='AA2940' AND term=1 
		$this->db = $this->load->database('dcsdphy', TRUE); // NOT phy
		$this->db->select("*");
		$this->db->from("booking_place");
		$this->db->where("year", $year);
		$this->db->where("class_no", $classNo);
		$this->db->where("term", $term);
		$this->db->where("room_id LIKE", "E%");
		$query = $this->db->get();
		$data = $query->result_array();
		return $data;
	}
}

