<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Database_model extends QW_Model {
	public function __construct() {
		parent::__construct ();
		$this->_table = $this->_tables ["back_up"];
	}
	
	public function get_backs($offset=0,$eachpage=0,$sortOrder='',$search='') {
	
		return $this->get_by_field('',$search,$sortOrder,$offset,$eachpage);
	}
	
	public function get_database()
	{
		$database = $this->db->database;
		$tables = $T = array();
		$i = $total_size = 0;
		$res = $this->db->query("show tables from $database");
		foreach ($res->result_array() as $r) {
			if (!$r) {
				continue;
			}
			$T[] = $r['Tables_in_' . $database];
		}
		uksort($T, 'strnatcasecmp');
		foreach ($T as $t) {
			$r = $this->db->query("show table status from $database like '$t'")->row_array();
			$tables[$i]['name'] = $r['Name'];
			$tables[$i]['rows'] = $r['Rows'];
			$tables[$i]['size'] = round($r['Data_length'] / 1024 / 1024, 2);
			$tables[$i]['index'] = round($r['Index_length'] / 1024 / 1024, 2);
			$tables[$i]['tsize'] = $tables[$i]['size'] + $tables[$i]['index'];
			$tables[$i]['auto'] = $r['Auto_increment'];
			$tables[$i]['update_time'] = $r['Update_time'];
			$tables[$i]['note'] = $r['Comment'];
			$tables[$i]['chip'] = $r['Data_free'];
			$total_size += $tables[$i]['tsize'];
			$i++;
		}
		foreach($tables as $k => $v) {
			$tables[$k]['total_size'] = $total_size;
		}
		return $tables;
	}
	
	public function repair($table)
	{
		$this->db->query("REPAIR TABLE `$table`");
        return true;
	}
	
	public function optimize($table)
    {
        $this->db->query("OPTIMIZE TABLE `$table`");
        return true;
    }
	
	/**
     * 备份数据表
     * @param $tables -表名称数组
     * @return mixed
     */
    public function backup($tables)
    {
        $sql = "";
        foreach ($tables as $k => $table) {
            //获取数据
            $data = $this->db->query("select * from " . $table)->result_array();
            //获取表字段
            $fields_info = $this->db->query("desc " . $table)->result_array();
            $field_str = "";
            foreach ($fields_info as $ks => $vs) {
                $field_str .= "`" . $vs['Field'] . "`,";
            }
            $sql = $sql . "-- --------------------\r\n";
            $sql = $sql . "-- Records of " . $table . "\r\n";
            $sql = $sql . "-- --------------------\r\n";
            foreach ($data as $ks => $vs) {
                $rr = implode("','", array_values($vs));
                $sql .= "insert into `" . $table . "` (" . trim($field_str, ",") . ") values ('" . $rr . "');\r\n";
            }
        }
        $filename = date('YmdHis') . '.sql';
        $path = '/upload/db/' . $filename;
        write_file(FCPATH . $path, $sql);
        $date = date('Y-m-d H:i:s');
        $file_size = sprintf("%.2f", filesize(FCPATH . $path) / 1024);
        if ($file_size / 1024 > 1) {
            $file_size = ceil($file_size / 1024) . "MB";
        } else {
            $file_size = $file_size . "KB";
        }
        $user_id = $this->session->userdata("user_id");
        $data = array(
            'user_id' => $user_id,
            'name' => $filename,
            'table' => implode(",", $tables),
            'path' => $path,
            'size' => $file_size,
            'date_entered' => $date
        );
        return $this->db->insert($this->_table, $data);
    }
	
	public function dict($table)
    {
        $columns = array();
        $res = $this->db->query("SHOW COLUMNS FROM $table");
        foreach ($res->result_array() as $r) {
            //获取字段注释
            $column = $this->db->query("select COLUMN_COMMENT as comment from INFORMATION_SCHEMA.COLUMNS where table_name = '{$table}' and column_name = '{$r['Field']}' and table_schema = '{$this->db->database}'")->result_array();
            $r['comment'] = $column[0]['comment'];
            if ($r['Key'] == 'PRI')
            {
                $r['Type'] = $r['Type']." auto_increment";
            }
            $columns[] = $r;
        }
        return $columns;
    }
	
	public function update_table($table, $field, $type)
    {
        foreach ($field as $column => $v) {
            $column_type = $type[$column];
            $this->db->query("alter table $table modify column {$column} {$column_type} comment '{$v}'");
        }
        return true;
    }
	
	public function getBackUpById($id)
    {
        return $this->db->get_where($this->_table, "id = $id")->row_array();
    }
	
	public function delete_op($id)
    {
        $back = $this->getBackUpById($id);
        $res = $this->db->delete($this->_table, array("id" => $id));
        if ($res) {
            @unlink(FCPATH . $back['path']);
            return true;
        }
        return false;
    }
}