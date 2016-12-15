<?php
/*
 * db_interface 数据库接口
 *
 * @copyright			(C) 2016 HeartPHP
 * @author              maoxiaoqi <15501100090@163.com> <qq:3677989>
 *
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 */
namespace heart\libs\db;

interface db_interface {
	public function __construct(&$conf);

	public function query($sql, $link = NULL);

	public function update($data, $where, $tblname);

	public function delete($where, $tblname);

	public function insert($data, $tblname);

	public function select($fileds, $tblname, $where = '', $limit = '', $order = '', $group = '');

	public function get_one($fileds, $tblname, $where = '');

	public function version();
}