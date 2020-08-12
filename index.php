<?php
	require "Controller.php";
	$c=new Controller();
	if(isset($_GET["task"])){
	$task=$_GET["task"];
	switch ($task) {
		case 'login':
			$c->login();
			break;
		case 'addnhanvien':
			$c->addnhanvien();
			break;
		case 'getlistnhanvien':
			$c->getlistnhanvien();
			break;
		case 'xoanhanvien':
			$c->xoanhanvien();
			break;
		case 'gettablestate':
			$c->gettablestate();
			break;
		case 'editnhanvien':
			$c->editnhanvien();
			break;
		case 'getnhanvienbyid':
			$c->getnhanvienbyid();
			break;
		case 'getallmon':
			$c->getallmon();
			break;
		case 'getmanv':
			$c->getmanv();
			break;
		case 'getdate':
			$c->getdate();
			break;
		case 'addbooking':
			$c->addbooking();
			break;
		case 'addbookingdetail':
			$c->addbookingdetail();
			break;
		case 'getbooking':
			$c->getbooking();
			break;
		case 'editbooking':
			$c->editbooking();
			break;
		case 'editbookingdetail':
			$c->editbookingdetail();
				break;
		case 'changetable':
			$c->changetable();
			break;
		case 'thanhtoan':
				$c->thanhtoan();
				break;	
		case 'xoamon':
			$c->xoamon();
			break;
		case 'addmon':
			$c->addmon();
			break;
		case 'editmon':
			$c->editmon();
			break;
		case 'addban':
			$c->addban();
			break;
		case 'editban':
			$c->editban();
			break;
		case 'deleteban':
			$c->deleteban();
			break;
		case 'gethoadonbyday':
			$c->gethoadonbyday();
			break;
		case 'thongketheomon':
			$c->thongketheomon();
			break;
		case 'thongketheonhanvien':
			$c->thongketheonhanvien();
			break;
		case 'checkneudachamcong':
			$c->checkneudachamcong();
			break;
		case 'chamcong':
			$c->chamcong();
			break;
		default:
			$c->errorrequest();
			break;
	}
} else $c->errorrequest();


  ?>