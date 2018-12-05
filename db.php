<?php 
class Db extends PDO
{
	private $sql;
	private $array;
	private $sonEklenenId;
	private $adet;
	private $error;
	function __construct($sunucu,$veritabani,$kullanici,$sifre,$charset="utf8")
	{
		try{
			parent::__construct("mysql:host=".$sunucu.";dbname=".$veritabani.";charset=".$charset,$kullanici,$sifre);
			// parent::exec("SET NAMES utf8");
			// parent::exec("SET CHARSET utf8");
		}catch( Exception $hata ){
			die("Bağlantı Hatası Oluştu..!");
		}
	}
	public function select($param="")
	{
		if (trim($param)==1) {
			$sorgu = parent::prepare($this->sql);
			$sorgu->execute($this->array);
			if ($sorgu->rowCount()>0) {
				$this->adet = $sorgu->rowCount();
				return $sorgu->fetch(PDO::FETCH_ASSOC);
			}else{
				$this->adet = 0;
				return false;
			}
		}else{
			$sorgu = parent::prepare($this->sql);
			$sorgu->execute($this->array);
			if ($sorgu->rowCount()>0) {
				$this->adet = $sorgu->rowCount();
				return $sorgu->fetchAll(PDO::FETCH_ASSOC);
			}else{
				$this->adet = 0;
				return false;
			}
		}
	}
	public function query($query)
	{
		$this->sql=$query;
		return $this;
	}
	public function data($data)
	{
		$this->array=$data;
		return $this;
	}
	public function insert()
	{
		try{
			$sorgu = parent::prepare($this->sql);
			$sorgu->execute($this->array);
			$this->sonEklenenId=parent::lastInsertId();
			if ( $this->sonEklenenId>0) {
				return true;
			}else{
				return false;
			}
		}catch( Exception $hata){
			$this->error=$hata;
			return false;
		}
	}
	public function update()
	{
		try{
			$sorgu = parent::prepare($this->sql);
			$sorgu->execute($this->array);
			if ( $sorgu->rowCount()) {
				return true;
			}else{
				$this->error=parent::errorInfo();
				return false;
			}
		}catch( Exception $hata){
			$this->error=$hata;
			return false;
		}
	}
	public function delete()
	{
		try{
			$sorgu = parent::prepare($this->sql);
			$sorgu->execute($this->array);
			if ( $sorgu->rowCount()) {
				return true;
			}else{
				return false;
			}
		}catch( Exception $hata){
			$this->error=$hata;
			return false;
		}
	}
	public function count()
	{
		return $this->adet;
	}
	public function last_insert_id()
	{
		return $this->sonEklenenId;
	}
	public function error()
	{
		return $this->error;
	}
}