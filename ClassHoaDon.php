<?php 	
/**
* 
*/
class 	ClassHoaDon		
{
	
		var $mahd,$tenban,$tenkh,$ghichu,$tennvdat,$tennvtt,$khachtra,$ngay,$thoigian;
		var $mon=array();
		function __construct($mahd,$tenban,$tenkh,$khachtra,$ghichu,array $mon,$tennvdat,$tennvtt,$ngay,$thoigian)
		{
			$this->mahd=$mahd;
			$this->tenban=$tenban;
			$this->tenkh=$tenkh;
			$this->ghichu=$ghichu;
			$this->mon=$mon;
			$this->tennvdat=$tennvdat;
			$this->tennvtt=$tennvtt;
			$this->khachtra=$khachtra;
			$this->ngay=$ngay;
			$this->thoigian=$thoigian;
		}
	
}
 ?>