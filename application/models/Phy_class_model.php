<?php

class Phy_class_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database('dcsdphy'); // NOT phy
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
