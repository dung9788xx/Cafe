<?php 
/**
* 
*/
class NhanVien
{
	var $manv,$hoten,$ngaysinh,$diachi,$sdt,$username,$password,$level,$luong;
	function __construct($manv,$hoten,$ngaysinh,$diachi,$sdt,$username,$password,$level,$luong)
	{
		$this->manv=$manv;
		$this->hoten=$hoten;
		$this->ngaysinh=$ngaysinh;
		$this->diachi=$diachi;
		$this->sdt=$sdt;
		$this->username=$username;
		$this->password=$password;
		$this->level=$level;
		$this->luong=$luong;
	}
}

 ?>