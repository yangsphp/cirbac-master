<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class QW_Model extends CI_Model {

	protected $_tables;
	protected $_table;

	public function __construct() {
		parent::__construct ();
		//获取表配置
		$this->_tables = $this->config->item ( "tables" );
	}

	/**
	 * 获取数据表中指定字段、条件、联合及次序的数据记录
	 *
	 * @param string $field		字段
	 * @param string $condition	条件
	 * @param string $order		排序
	 * @param integer $limit	起始位置
	 * @param integer $offset	偏移量
	 * @param string $join		联合
	 * @return array
	 */
	public function get_by_field($field = '*', $condition = '', $order = '', $offset = 0, $limit = 0, $group = '', $having = '', $join = '',$join2 = '') {
		$this->db->select ( $field );
		if (is_array ( $join )) {
			$this->db->join ( $join [0], $join [1]);
		}
        if (is_array ( $join2 )) {
            $this->db->join ( $join2 [0], $join2 [1] );
        }
		if ($condition != '') {
			$this->db->where ( $condition );
		}
		if ($group != '') {
			$this->db->group_by ( $group );
		}
		if ($having != '') {
			$this->db->having ( $having );
		}
		if ($order != '') {
			$this->db->order_by ( $order );
		}
		if ($limit != 0 || $offset != 0) {
			$this->db->limit ( $limit, $offset );
		}
		$query = $this->db->get ( $this->_table );
		return $query->result_array ();
	}

	/**
	 * 获取数据表中全部的数据记录
	 *
	 * @param string $order		排序
	 * @param integer $limit	起始位置
	 * @param integer $offset	偏移量
	 * @param string $join		联合
	 * @return array
	 */
	public function get_all($order = '', $offset = 0, $limit = 0, $group = '', $having = '', $join = '') {
		return $this->get_by_field ( '*', '', $order, $offset, $limit, $group, $having, $join );
	}

	/**
	 * 依据主键值来获取该主键记录
	 *
	 * @param integer $id	主键值
	 * @param string $field	主键名（默认为 id ）
	 * @return array
	 */
	public function get_by_key($id, $field = 'id',$order='',$offset = 0, $limit = 0) {
		return $this->get_by_field ( '*', "{$field} = {$id}" , $order, $offset, $limit);
	}

	public function get_by_join($table = "",$field1 = 'id' ,$field2 = 'id' ,$join = "left" , $condition =""){

		$this->db->select('*');
		$this->db->from( $this->_table );
		if ($condition != '') {
			$this->db->where ( $condition );
		}
		$this->db->join($table, "{$table}.{$field2} = {$this->_table}.{$field1}" , $join);
		$query = $this->db->get ();
		return $query->result_array ();

	}

	public function get_search_value($field='',$value_data='',$like='',$orlike='',$order = '', $offset = 0, $limit = 0){
		if($field != '' && $value_data != ''){
			$this->db->where_in($field,$value_data);
		}
		if($like != ''){
			$this->db->like($like[0],$like[1],$like[2]);
		}

		if($like != '' && $orlike != ''){
			$this->db->or_like($orlike[0],$orlike[1],$orlike[2]);
		}
		if($order != ''){
			$this->db->order_by($order);
		}
		if ($limit != 0 || $offset != 0) {
			$this->db->limit ( $limit, $offset );
		}
		$query = $this->db->get ( $this->_table );
		return $query->result_array ();
	}

    /**
     * 计算总数据
     * @param string $condition
     * @return mixed
     */
	public function count($condition = '') {
		if ($condition != '') {
			$this->db->where ( $condition );
		}
		return $this->db->count_all_results ( $this->_table );
	}

	public function min($field = 'id', $alias = 'min') {
		$this->db->select_min($field, $alias);
		$query = $this->db->get($this->_table);
		$result = $query->row ();
		return $result->$alias;
	}

	public function max($field = 'id', $alias = 'max') {
		$this->db->select_max($field, $alias);
		$query = $this->db->get($this->_table);
		$result = $query->row ();
		return $result->$alias;
	}

	public function avg($field = 'id', $alias = 'avg') {
		$this->db->select_avg($field, $alias);
		$query = $this->db->get($this->_table);
		$result = $query->row ();
		return $result->$alias;
	}

	public function sum($field = 'id',$condition="", $alias = 'summary') {
		$this->db->select_sum($field, $alias);

		$this->db->where($condition);
		$query = $this->db->get($this->_table);
		$result = $query->row ();
		//echo $result->$alias;
		return $result->$alias;
	}

    /**
     * 插入数据
     * @param array $data
     * @return mixed
     */
	public function insert($data = array()) {
		$this->db->insert ( $this->_table, $data );
		return $this->db->insert_id();
	}

    /**
     * 更新数据
     * @param int $id
     * @param array $data
     * @param string $field
     * @return mixed
     */
	public function update($id = 0, $data = array(), $field = 'id') {
		$this->db->where ( $field, $id );
		$query = $this->db->update ( $this->_table, $data );
		return $query;
	}

    /**
     * 删除数据
     * @param int $id 值
     * @param string $field 条件字段
     * @return mixed
     */
	public function delete($id = 0, $field = 'id') {
		$this->db->where ( $field, $id );
		$query = $this->db->delete ( $this->_table );
		return $query;
	}

    /**
     * 清空表
     */
	public function empty_table() {
		$this->db->empty_table ( $this->_table );
	}
}

?>