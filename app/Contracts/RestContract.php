<?php
namespace SimpleTask\Contracts;
interface RestContract
{
	public function find($q,$start=0,$limit=20,$orderby='');
	public function update($id);
	public function add($data);
	public function delete($id);
}
?>