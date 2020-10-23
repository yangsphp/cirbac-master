<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class QW_Loader extends CI_Loader
{


    public function __construct()
    {
        parent::__construct();

    }

    public function view($view, $vars = array(), $return = FALSE)
    {
        $CI =& get_instance();
        $vars['skin'] = base_url() . "assets/";
        $vars['css'] = $CI->config->item('css');
        $vars['js'] = $CI->config->item('js');
        $vars['images'] = $CI->config->item('images');
        $vars['fonts'] = $CI->config->item('fonts');
        $vars['less'] = $CI->config->item('less');


        //$data = $this->get_settings();
        //$vars = array_merge ( $vars, $data );

        return parent::view($view, $vars, $return);
    }

    function get_settings()
    {
        $CI = &get_instance();
        $tables = $CI->config->item('tables');
        $data = array();

        $CI->db->select();
        $query = $CI->db->get($tables['settings']);
        foreach ($query->result() as $row) {
            $data[$row->name] = $row->value;
            $data['ch_' . $row->name] = $row->ch_name;
        }
        return $data;
    }


    function cut_str($string, $sublen, $start = 0, $code = 'UTF-8')
    {
        $string = preg_replace("/[^一-龥]/u", "", $string);
        $strlen = strlen($string);
        if ($strlen >= $sublen) {

            if ($code == 'UTF-8') {
                $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
                preg_match_all($pa, $string, $t_string);

                if (count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen));
                return join('', array_slice($t_string[0], $start, $sublen));
            } else {
                $start = $start * 2;
                $sublen = $sublen * 2;
                $strlen = strlen($string);
                $tmpstr = '';

                for ($i = 0; $i < $strlen; $i++) {
                    if ($i >= $start && $i < ($start + $sublen)) {
                        if (ord(substr($string, $i, 1)) > 129) {
                            $tmpstr .= substr($string, $i, 2);
                        } else {
                            $tmpstr .= substr($string, $i, 1);
                        }
                    }
                    if (ord(substr($string, $i, 1)) > 129) $i++;
                }
                if (strlen($tmpstr) < $strlen) $tmpstr .= "...";
                return $tmpstr;


            }
        } else {
            return $string;
        }
    }


    function strlen_utf8($str)
    {
        $i = 0;
        $count = 0;
        $len = strlen($str);
        while ($i < $len) {
            $chr = ord($str[$i]);
            $count++;
            $i++;
            if ($i >= $len) break;
            if ($chr & 0x80) {
                $chr <<= 1;
                while ($chr & 0x80) {
                    $i++;
                    $chr <<= 1;
                }
            }
        }
        return $count;
    }


}


?>