<?php 
	/**
	* 
	*/
	class ClassBooking
	{
		var $maban,$tenkh,$ghichu,$mamon,$tenmon,$sl,$gia,$tennv;
		function __construct($maban,$tenkh,$ghichu,$mamon,$tenmon,$sl,$gia,$tennv)
		{
			$this->maban=$maban;
			$this->tenkh=$tenkh;
			$this->ghichu=$ghichu;
			$this->mamon=$mamon;
			$this->sl=$sl;
			$this->gia=$gia;
			$this->tenmon=$tenmon;
			$this->tennv=$tennv;
		}
	}
 ?>