<?php if (!defined('BASEPATH')) exit('Bạn không có quyền truy cập vào đây -dsolu.com');

/**
 * TK_Model short summary.
 *
 * TK_Model description.
 *
 * @version 1.1
 * @author REVO
 */
class TK_Model extends CI_Model
{

	// Ten table
	var $table = '';

	// Key chinh cua table
	var $key = 'id';

	// Order mac dinh (VD: $order = array('id', 'desc))
	var $order = '';

	// Cac field select mac dinh khi get_list (VD: $select = 'id, name')
	var $select = '';

	var $fix = "ci_";

	protected $data = array();

	public function __set($name, $value)
	{
		$this->data[$name] = $value;
	}


	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->dbforge();
	}

#region RAW SQL
/**
     * Thực hiện câu lệnh query
     * $sql : cau lenh sql
     */
	function query($sql){
		$rows = $this->db->query($sql);
		return $rows->result_object();
	}
	/**
	 * Thực hiện câu lệnh exec
	 * $sql : cau lenh sql
	 */
	function exec($sql)
	{
		$this->db->query($sql);
		return $this->db->affected_rows();;
	}
	#endregion

	#region Tạo dữ liệu mới
	/**
	 * Chức năng save nhanh
	 */
	public function save()
    {
        $id = isset($this->data['id']) ? $this->data['id'] : 0;
        if( $id )
        {
            $this->data['date_update'] = date('Y-m-d H:i:s');
            return $this->db->where('id' , $id )
                ->update($this->table, $this->data )
                ->affected_rows();
        }
        else
        {
            $this->data['date_created'] = date('Y-m-d H:i:s');
            return $this->db->insert($this->table, $this->data )
                ->insert_id();
        }
	}

	/**
	 * Them row moi
	 * $data : du lieu ma ta can them
	 */
	function create($data = array())
	{
		if (!isset($data["date_update"])) {
			$data["date_update"] = date('Y-m-d H:i:s'); //date('Y-m-d H:i:s');
		}
		if (!isset($data["date_created"])) {
			$data["date_created"] = date('Y-m-d H:i:s'); //date('Y-m-d H:i:s');
		}

		if ($this->db->insert($this->table, $data)) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}

	/**
	 * Them row moi
	 * $data : du lieu ma ta can them
	 */
	function create_default($data = array())
	{

		if ($this->db->insert($this->table, $data)) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}

	/**
	 * Tạo dữ liệu mới nếu nó đã tồn tại thì cập nhật
	 * Điều kiện là phải có trường unique
	 */
	public function create_or_update($data = array())
	{
		if (!isset($data["date_update"])) {
			$data["date_update"] = time(); //date('Y-m-d H:i:s');
		}
		if (!isset($data["date_created"])) {
			$data["date_created"] = time(); //date('Y-m-d H:i:s');
		}

		$columns    = array();
		$values     = array();
		$upd_values = array();
		foreach ($data as $key => $val) {
			if ($val == null || $val == "")
				continue;
			$columns[]    = $this->db->escape_identifiers($key);
			if ($val == "-NULL") {
				$val = "NULL";
			} else {
				$val = $this->db->escape($val);
			}

			$values[]     = $val;
			if ($key != "date_created")
				$upd_values[] = $key . '=' . $val;
		}
		$sql = "INSERT INTO " . $this->db->dbprefix($this->table) . "(" . implode(",", $columns) . ") VALUES (" . implode(', ', $values) . ") ON DUPLICATE KEY UPDATE " . implode(",", $upd_values);
		return $this->db->query($sql);
	}
	#endregion

	#region cập nhật dũ liệu
	/**
	 * Cap nhat row tu id
	 * $id : khoa chinh cua bang can sua
	 * $data : mang du lieu can sua
	 */
	function update($id, $data)
	{
		if (!$id) {
			return FALSE;
		}
		if(!isset($data["date_update"]))
		{
			$data["date_update"] =date("Y-m-d H:i:s");//date('Y-m-d H:i:s');
		}
		$where = array();
		$where[$this->key] = $id;
		return $this->update_rule($where, $data);
	}

	/**
	 * Cap nhat row tu dieu kien
	 * $where : dieu kien
	 * $data : mang du lieu can cap nhat
	 */
	function update_rule($where, $data)
	{
		if (!$where) {
			return FALSE;
		}

        return $this->db->where($where )
                ->update($this->table, $data );

	}

	/**
	 * Đưa 1 row vào thùng rác
	 * Bản chất là ẩn nó đi
	 */
	function delete($id)
	{
		if (!$id) {
			return FALSE;
		}
		//neu la so
		if (is_numeric($id)) {
			$where = array($this->key => $id);
		} else {
			//$id = 1,2,3...
			$where = $this->key . " IN (" . $id . ") ";
		}

		$data['date_delete'] = date('Y-m-d H:i:s');
		$data['active']      = 0;
		return $this->db->where($where)
			->update($this->table, $data);
	}
#endregion

	#region Xoá dữ liệu
	/**
	 * Xoa row tu id
	 * $id : gia tri cua khoa chinh
	 */
	function remove($id)
	{
		if (!$id) {
			return FALSE;
		}
		//neu la so
		if (is_numeric($id)) {
			$where = array($this->key => $id);
		} else {
			//$id = 1,2,3...
			$where = $this->key . " IN (" . $id . ") ";
		}
		$this->remove_rule($where);

		return TRUE;
	}

	/**
	 * Xoa row tu dieu kien
	 * $where : mang dieu kien de xoa
	 */
	function remove_rule($where)
	{
		if (!$where) {
			return FALSE;
		}

		$this->db->where($where);
		$this->db->delete($this->table);

		return TRUE;
	}
	#endregion

#region truy vấn dữ liệu
	public function filter($filter)
    {
        $this->db->where('active',1);
        $this->db->like($filter);
        if($r = $this->db->get($this->table)){
            return $r->result();
        }
        return null;
	}

	/**
	 * kiểm tra sự tồn tại của dữ liệu theo 1 điều kiện nào đó
	 * $where : mang du lieu dieu kien
	 */
	function check_exists($where = array())
	{
		$this->db->where($where);
		//thuc hien cau truy van lay du lieu
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Lay thong tin cua row tu id
	 * $id : id can lay thong tin
	 * $field : cot du lieu ma can lay
	 */
	function get_info($id, $field = '*')
	{
		if (!$id) {
			return FALSE;
		}

		$where = array();
		$where[$this->key] = $id;

		return $this->get_info_rule($where, $field);
	}

	/**
	 * Lay thong tin cua row tu dieu kien
	 * $where: Mảng điều kiện
	 * $field: Cột muốn lấy dữ liệu
	 */
	function get_info_rule($where = array(), $field = '*')
	{
		if ($field) {
			$this->db->select($field);
		}
		$this->db->where($where);
		$query = $this->db->get($this->table);
		if ($query->num_rows()) {
			return $query->row();
		}

		return FALSE;
	}

	/**
	 * Lay 1 row
	 */
	function get_row($input = array())
	{
		$this->get_list_set_input($input);

		$query = $this->db->get($this->table);

		return $query->row();
	}


	/**
	 * Lay danh sach
	 * $input : mang cac du lieu dau vao
	 */
	function get_list($input = array())
	{
		//xu ly ca du lieu dau vao
		$this->get_list_set_input($input);

		//thuc hien truy van du lieu
		$query = $this->db->get($this->table);
		//echo $this->db->last_query();
		return $query->result_array();
	}

	/**
	 * Lay danh sach
	 * $input : mang cac du lieu dau vao
	 */
	function get_list_obj($input = array())
	{
		//xu ly ca du lieu dau vao
		$this->get_list_set_input($input);

		//thuc hien truy van du lieu
		$query = $this->db->get($this->table);
		//echo $this->db->last_query();
		return $query->result_object();
	}

	/**
	 * Gan cac thuoc tinh trong input khi lay danh sach
	 * $input : mang du lieu dau vao
	 */

	protected function get_list_set_input($input = array())
	{

		// Thêm điều kiện cho câu truy vấn truyền qua biến $input['where']
		//(vi du: $input['where'] = array('email' => 'hocphp@gmail.com'))
		if ((isset($input['where'])) && $input['where']) {
			$this->db->where($input['where']);
		}

		//tim kiem like
		// $input['like'] = array('name' , 'abc');
		if ((isset($input['like'])) && $input['like']) {
			$this->db->like($input['like'][0], $input['like'][1]);
		}

		// Thêm sắp xếp dữ liệu thông qua biến $input['order']
		//(ví dụ $input['order'] = array('id','DESC'))
		if (isset($input['order'][0]) && isset($input['order'][1])) {
			$this->db->order_by($input['order'][0], $input['order'][1]);
		} else {
			//mặc định sẽ sắp xếp theo id giảm dần
			$order = ($this->order == '') ? array($this->table . '.' . $this->key, 'desc') : $this->order;
			$this->db->order_by($order[0], $order[1]);
		}

		// Thêm điều kiện limit cho câu truy vấn thông qua biến $input['limit']
		//(ví dụ $input['limit'] = array('10' ,'0'))
		if (isset($input['limit'][0]) && isset($input['limit'][1])) {
			$this->db->limit($input['limit'][0], $input['limit'][1]);
		}
	}


	/**
	 * Lay tong so record
	 */
	function get_total($input = array())
	{
		$this->get_list_set_input($input);

		$query = $this->db->get($this->table);

		return $query->num_rows();
	}

	/**
	 * Tính tong so
	 * $field: cot muon tinh tong
	 */
	function get_sum($field, $where = array())
	{
		$this->db->select_sum($field); //tinh rong
		$this->db->where($where); //dieu kien
		$this->db->from($this->table);

		$row = $this->db->get()->row();
		foreach ($row as $f => $v) {
			$sum = $v;
		}
		return $sum;
	}

	#endregion

	#region Thao Tác với table
	/**
	 * Get Table Name
	 */
	public function get_table_name()
	{
		return $this->table;
	}




	public function truncate()
	{

		$this->db->truncate($this->table);
	}
	public function dropthetable()
	{
		if ($this->dbforge->drop_table($this->table, true)) {
			return $this->table . ' Database deleted!';
		} else {
			return $this->table . ' Database CANT deleted!';
		}
	}
	public function getListFied()
	{
		return $this->db->field_data("$this->table");
	}
	public function validateTable()
	{
		$result = $this->db->list_tables();
		foreach ($result as $row) {
			if ($row == $this->table)
				return true;
		}
		return false;
	}
	#endregion

}
