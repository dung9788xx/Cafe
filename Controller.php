<?php 
	require "NhanVien.php";
	require "TableState.php";
	require "Mon.php";
	require "ClassBooking.php";
	require "ClassHoaDon.php";
	require "ClassMon1.php";
	require "ClassChamCong.php";
	class Controller
	{
		var $conn;
		
		function __construct()
		{
		$this->conn=new mysqli('localhost','root','','user');
		$this->conn->set_charset("utf8");
 
		}
		function login(){
			$username=$_POST["username"];
			$password=$_POST["password"];
			$sql="SELECT * FROM `user` where username='$username' and password ='$password'";
				$result=$this->conn->query($sql);
			if($result->num_rows>0) {
				echo "loginsuccess"; //login success
				echo "|";
				$row=$result->fetch_assoc();
				echo $row["level"];
		
			} 
			else{
					$sql="SELECT * FROM `user` where username='$username'";
					$result=$this->conn->query($sql);
					if($result->num_rows>0) echo "errorpass"; 
					else echo "errorusername";
				}
		}
		function addnhanvien(){
			$username=$_POST["username"];
			$sql="SELECT * FROM `user` where username='$username'";
					$result=$this->conn->query($sql);
					if($result->num_rows>0){
						echo "dacouser";
					}else{
						$hoten=$_POST["hoten"];
						$ngaysinh=$_POST["ngaysinh"];
						$diachi=$_POST["diachi"];
						$sdt=$_POST["sdt"];
						$password=$_POST["password"];
						$level=$_POST["level"];
						$luong=$_POST["luong"];
						$sql="insert into `user` values(null,'$hoten','$ngaysinh','$diachi','$sdt','$username','$password','$level','$luong')";
						$this->conn->query($sql);
						


					}
		}
		function getlistnhanvien(){
			$sql="select * from user ORDER BY hoten DESC";
			$result=$this->conn->query($sql);
			$ds=array();
				while ($row=$result->fetch_assoc()) {
					array_push($ds, new NhanVien($row["manv"],$row["hoten"],$row["ngaysinh"],$row["diachi"],$row["sdt"],$row["username"],$row["password"],$row["level"],$row["luong"]));
					}
			echo "getlistnhanvien|";
			echo json_encode($ds); 
		}
		function xoanhanvien(){
			$username=$_POST["username"];
			$sql="delete from user where username='$username'";
			$this->conn->query($sql);
			echo "deleted";
		}
		function gettablestate(){
			$sql="SELECT * FROM ban ";
			$result=$this->conn->query($sql);
		
			$ds=array();
			while ($row=$result->fetch_assoc()) {
						$r1=$this->conn->query("SELECT * FROM booking");//cac ban dang dc dat
					$st=0;
					while ($row1=$r1->fetch_assoc()) {
						if($row["maban"]==$row1["maban"]){
							$st=1;
							break;
						}
					}
					array_push($ds, new TableState($row["maban"],$row["tenban"],$st,$row["trangthai"]));
			}
			echo "gettablestate|";
			echo json_encode($ds);
			
		}
		function editnhanvien(){
			$username=$_POST["username"];
			$manv=$_POST["manv"];
			$sql="SELECT * FROM user where username='$username' and manv <> '$manv'";
			$result=$this->conn->query($sql);

			if($result->num_rows>0){
					echo "dacouser";
			}else{
					$hoten=$_POST["hoten"];
					$ngaysinh=$_POST["ngaysinh"];
					$diachi=$_POST["diachi"];
					$sdt=$_POST["sdt"];
					$password=$_POST["password"];
					$level=$_POST["level"];
					$luong=$_POST["luong"];
					$sql="update user set manv='$manv', hoten='$hoten',ngaysinh='$ngaysinh',diachi='$diachi',sdt='$sdt',
					username='$username',password='$password',level='$level',luong='$luong' where manv='$manv'";
					$result=$this->conn->query($sql);
					echo "ok";

			}
		}
		function getallmon(){
			$sql="select * from mon";
			$result=$this->conn->query($sql);
			$ds=array();
				while ($row=$result->fetch_assoc()) {
					array_push($ds, new Mon($row["mamon"],$row["tenmon"],$row["gia"]));
					}
			echo "getmon|";
			echo json_encode($ds); 
		}
		function getmanv(){
			$username=$_POST["username"];
			$sql="select manv,hoten from user where username='$username'";
			$result=$this->conn->query($sql);
			echo "manv";
			while ($row=$result->fetch_assoc()) {
					 echo $row["manv"];
					 echo "|";
					 echo $row["hoten"];
					}


		}
		function addbooking(){
			$maban=$_POST["maban"];
			$tenkh=$_POST["tenkh"];
			$manv=$_POST["manv"];
			$ghichu=$_POST["ghichu"];
			$sql="insert into booking values($maban,'$tenkh',$manv,curdate(),'$ghichu',CURRENT_TIME())";
			$re=$this->conn->query($sql);
			if($re!=null){
				echo "addedbooking";
			}else echo "error".$this->conn->error;
		}
		function addbookingdetail(){
			$json = $_POST["json"];
			$ds=json_decode($json,true);
			foreach ($ds as $key =>$value) {
				$maban=$value["maban"];
				$mamon=$value["mamon"];
				$sl=$value["sl"];
				$sql="insert into ctbooking values($maban,$mamon,$sl)";
				$this->conn->query($sql);
			}
			echo "done";
		}
		function getbooking(){
			$maban=$_POST["maban"];
			$sql="select * from booking,ctbooking,mon,user where booking.maban='$maban' AND booking.maban=ctbooking.maban and mon.mamon=ctbooking.mamon and user.manv=booking.manv";
			$result=$this->conn->query($sql);
			$ds=array();
				while ($row=$result->fetch_assoc()) {
					array_push($ds, new ClassBooking($row["maban"],$row["tenkh"],$row["ghichu"],$row["mamon"],$row["tenmon"],$row["sl"],$row["gia"],$row["hoten"]));
					}
			echo "getbooking|";
			echo json_encode($ds); 

		}
		function editbooking(){
			$maban=$_POST["maban"];
			$tenkh=$_POST["tenkh"];
			$manv=$_POST["manv"];
			$ghichu=$_POST["ghichu"];
			$sql="update booking set tenkh='$tenkh',ghichu='$ghichu' where maban='$maban' ";
			$re=$this->conn->query($sql);
			if($re!=null){
				echo "editedbooking";
			}else echo "error".$this->conn->error;
		}
		function editbookingdetail(){
			$json = $_POST["json"];
			$maban=$_POST["maban"];
			$sql="delete from ctbooking where maban='$maban'";
			$this->conn->query($sql);
			$ds=json_decode($json,true);
			foreach ($ds as $key =>$value) {
				$maban=$value["maban"];
				$mamon=$value["mamon"];
				$sl=$value["sl"];
				$sql="insert into ctbooking values($maban,$mamon,$sl)";
				$this->conn->query($sql);
			}
			echo "done";
		}
		function changetable(){
			$mabancu=$_POST["mabancu"];
			$mabanmoi=$_POST["mabanmoi"];
			$sql="SET foreign_key_checks = 0";
			$this->conn->query($sql);
			$sql="update booking set maban='$mabanmoi' where maban='$mabancu'";
			$this->conn->query($sql);
			$sql=" update ctbooking set maban='$mabanmoi' where maban='$mabancu'";
			$re=$this->conn->query($sql);
			if($re!=null){
				echo "changedtable";
			}else echo "error".$this->conn->error;
			$sql="SET foreign_key_checks = 1";
			$this->conn->query($sql);

		}
		function thanhtoan(){
			$maban=$_POST["maban"];
			$khachtra=$_POST["khachtra"];
			$manvtt=$_POST["manvtt"];
			$mahd=0;
			$sql="select max(mahd) from booked";
			$result=$this->conn->query($sql);
			$row=$result->fetch_assoc();
			if($row["max(mahd)"]!=null){
				$mahd=$row["max(mahd)"]+1;

			} else $mahd=1;
	
			$sql="select * from booking where maban='$maban'";
			$result=$this->conn->query($sql);
			$row=$result->fetch_assoc();
			$sql="insert into booked values('$mahd','$row[manv]','$manvtt','$khachtra',$maban,'$row[ngay]','$row[tenkh]','$row[thoigian]','$row[ghichu]')";
			$result=$this->conn->query($sql);
			if($result!=null){
					$sql="SET foreign_key_checks = 0";
					$this->conn->query($sql);
					$sql="delete from booking where maban='$maban' ";
					$this->conn->query($sql);
					$sql="select * from ctbooking where maban='$maban'";
					$re=$this->conn->query($sql);
					while ($r=$re->fetch_assoc()) {
						$sql="insert into ctbooked values('$mahd','$r[mamon]','$r[sl]')";
						$this->conn->query($sql);
					}

					$sql="delete from ctbooking where maban='$maban'";
					$this->conn->query($sql);
					$sql="SET foreign_key_checks = 1";
					$this->conn->query($sql);
					echo "thanhtoanxong";
					}else echo "error".$this->conn->error;
			
				
			
		}
		function xoamon(){
			$mamon=$_POST["mamon"];
			$sql="delete from mon where mamon='$mamon'";
			$result=$this->conn->query($sql);
			if($result!=null){
				echo "deletesuccess";
			}else echo "error";
		}
		function addmon(){
			$tenmon=$_POST["tenmon"];
			$gia=$_POST["gia"];
			$sql="insert into mon values(null,'$tenmon','$gia')";
			$result=$this->conn->query($sql);
			if($result!=null){
				echo "added";
			} else echo "error";
		}
		function editmon(){
			$tenmon=$_POST["tenmon"];
			$gia=$_POST["gia"];
			$mamon=$_POST["mamon"];
			$sql="update mon set tenmon='$tenmon',gia='$gia' where mamon='$mamon'";
			$result=$this->conn->query($sql);
			if($result!=null){
				echo "edited";
			} else echo "error";
		}
		function addban(){
			$tenban=$_POST["tenban"];
			$trangthai=$_POST["trangthai"];
			$sql="insert into ban values(null,'$tenban',$trangthai)";
			$result=$this->conn->query($sql);
			if($result!=null){
				echo "addedban";
			}else echo "error";
		}
		function editban(){
			$maban=$_POST["maban"];
			$tenban=$_POST["tenban"];
			$trangthai=$_POST["trangthai"];
			$sql="update ban set tenban='$tenban',trangthai='$trangthai' where maban='$maban'";
			$result=$this->conn->query($sql);
			if($result!=null){
				echo "edited";
			}else echo "error";
		}
		function deleteban(){
			$maban=$_POST["maban"];
			$sql="delete from ban where maban='$maban'";
			$result=$this->conn->query($sql);
			if($result!=null){
				echo "deleted";
			}else echo "error";

		}
		

		function gethoadonbyday(){
			$tungay=$_POST["tungay"];
			$denngay=$_POST["denngay"];
			$dshoadon=array();
			$sql="select * from booked,user,ban where user.manv=booked.manvdat and booked.maban=ban.maban 
			AND ngay >='$tungay' and ngay<='$denngay' order by mahd";
			$result=$this->conn->query($sql);
			while($row=$result->fetch_assoc()){
					$sql="select * from ctbooked,mon where ctbooked.mamon=mon.mamon and mahd='$row[mahd]'";
					$dsmon=array();
					$result1=$this->conn->query($sql);
					while ($row1=$result1->fetch_assoc()) {
						array_push($dsmon, new ClassMon1($row1["mamon"],$row1["tenmon"],$row1["gia"],$row1["sl"]));

					}
					$sql="select hoten from user where manv='$row[manvtt]'";
					$result2=$this->conn->query($sql);
					$row2=$result2->fetch_assoc();
					$tennvtt=$row2["hoten"];
					array_push($dshoadon, new ClassHoaDon($row["mahd"],$row["tenban"],$row["tenkh"],$row["khachtra"],$row["ghichu"],$dsmon,$row["hoten"],$tennvtt,$row["ngay"],$row["thoigian"]));

			}
			echo "gethoadon|";
			echo json_encode($dshoadon);
		}
		function thongketheomon(){
			$tungay=$_POST["tungay"];
			$denngay=$_POST["denngay"];
			$sql="SELECT *,SUM(sl) FROM `booked`,ctbooked,mon WHERE booked.mahd=ctbooked.mahd AND ctbooked.mamon=mon.mamon 
			AND ngay >='$tungay' and ngay<='$denngay'  GROUP BY ctbooked.mamon ORDER BY SUM(sl) DESC";
			$result=$this->conn->query($sql);
			$ds=array();
			while ($row=$result->fetch_assoc()) {
				array_push($ds, new ClassMon1($row["mamon"],$row["tenmon"],$row["gia"],$row["SUM(sl)"]));
			}
			if($result!=null){
				echo "thongketheomon|";
				echo json_encode($ds);
			}else echo "error";
			
		}
		function thongketheonhanvien(){
			$type=$_POST["type"];
			//type =1 thong ke theo dat, 2 theo thanh toan
			$manv=$_POST["manv"];
			$tungay=$_POST["tungay"];
			$denngay=$_POST["denngay"];
			$sql="";
			$dshoadon=array();
			if($type=="1"){
					$sql="select * from booked,user,ban where user.manv=booked.manvdat and booked.maban=ban.maban 
					AND ngay >='$tungay' and ngay<='$denngay' and manvdat='$manv' order by mahd";
			}
			if($type=="2")		$sql="select * from booked,user,ban where user.manv=booked.manvdat and booked.maban=ban.maban 
					AND ngay >='$tungay' and ngay<='$denngay' and manvtt='$manv'  order by mahd";

			$result=$this->conn->query($sql);
			while($row=$result->fetch_assoc()){
					$sql="select * from ctbooked,mon where ctbooked.mamon=mon.mamon and mahd='$row[mahd]'";
					$dsmon=array();
					$result1=$this->conn->query($sql);
					while ($row1=$result1->fetch_assoc()) {
						array_push($dsmon, new ClassMon1($row1["mamon"],$row1["tenmon"],$row1["gia"],$row1["sl"]));

					}
					$sql="select hoten from user where manv='$row[manvtt]'";
					$result2=$this->conn->query($sql);
					$row2=$result2->fetch_assoc();
					$tennvtt=$row2["hoten"];
					array_push($dshoadon, new ClassHoaDon($row["mahd"],$row["tenban"],$row["tenkh"],$row["khachtra"],$row["ghichu"],$dsmon,$row["hoten"],$tennvtt,$row["ngay"],$row["thoigian"]));

			}
			echo "thongketheonhanvien|";
			echo json_encode($dshoadon);
		}
		function getdate(){
			$sql="select curdate()";
			$re=$this->conn->query($sql)->fetch_assoc();
			$result=$re["curdate()"];
			echo "getdate|";
			echo $result;

		}
		function checkneudachamcong(){
			$sql="select * from chamcong,user where ngay=curdate() and chamcong.manv=user.manv";
			$result=$this->conn->query($sql);
			if($result->num_rows>0){
				$ds=array();
				while ($row=$result->fetch_assoc()) {
					array_push($ds, new ClassChamCong($row["manv"],$row["hoten"],$row["ngaysinh"],$row["denlam"]));

				}
				echo "dacham|";
				echo json_encode($ds);

			}else echo "chuacham";
		}
		function chamcong(){
			$json = $_POST["json"];
			$sql="delete from chamcong where ngay=curdate()";
			$this->conn->query($sql);
			$ds=json_decode($json,true);
			$checkerror=0;
			foreach ($ds as $key =>$value) {
				$manv=$value["manv"];
				$denlam=$value["denlam"];
				$sql="insert into chamcong values('$manv',curdate(),$denlam)";
				$re=$this->conn->query($sql);
				if($re==null){
					$checkerror=1;
					break;
				}

				
			}
			if($checkerror==1){
				echo "error";
		
			}else echo "dachamthanhcong";
	
			
		}




		function errorrequest(){
			echo "error request";
		}




	}

 ?>