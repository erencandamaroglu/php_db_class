<?php 

class MDb extends PDO
{
	// sql sorgu cümlesi
	private $sql;
	// sorgu cümlesine gönderilecek olan veri
	private $data;
	// insert metodu ile son eklenen kaydın ıd değeri
	public $last_insert_id;
	function __construct($server,$dbname,$dbuser,$dbpass)
	{
		try{
			parent:: __construct("mysql:host=$server;dbname=$dbname;charset=utf8",$dbuser,$dbpass);
		}catch( Exception $error ){
			die("Veritabanı Bağlantı Hatası Oluştu !");
		}
	}
	// sql sorgu cümlesi
	public function query($param)
	{
		$this->sql =$param;
		return $this;
	}
	// sorgu cümlesine gönderilecek olan veri
	public function arr($param)
	{
		$this->data=$param;
		return $this;
	}
	// veri çekme metodu
	// eğer parametre 1 ise sadece tek kaydı tek boyutlu bir dizi olarak döndür.
	// eğer parametre 1 değilse (boşsa) bulduğu tüm kayıtları çok boyutlu dizi olarak döndür
	public function select($param="")
	{
		if($param==1){
			$query =  parent::prepare($this->sql);
			if ($this->data==null) {
				$query->execute();
			}else{	
				$query->execute($this->data);
			}

			if ($query->rowCount()>0) { 
				$kayit = $query->fetch(PDO::FETCH_ASSOC);
				return $kayit;
			}else{
				return false;
			}
		}else{
			$query =  parent::prepare($this->sql);
			if ($this->data==null) {
				$query->execute();
			}else{	
				$query->execute($this->data);
			}			
			if ($query->rowCount()>0) {
				$kayitlar = $query->fetchAll(PDO::FETCH_ASSOC);
				return $kayitlar;
			}else{
				return false;
			}
		}
	}
	// sql sorgusunu çalıştırıp sonucunu true yada false cinsinden döndür
	public function insert(){
		$query =  parent::prepare($this->sql);
		if ($this->data==null) {
			$query->execute();
		}else{	
			$query->execute($this->data);
		}
		$this->last_insert_id = parent::lastInsertId();
		return $query;
	}
	// sql sorgusunu çalıştırıp sonucunu true yada false cinsinden döndür
	public function update(){
		$query =  parent::prepare($this->sql);
		if ($this->data==null) {
			$query->execute();
		}else{	
			$query->execute($this->data);
		}
		return $query;
	}
	// sql sorgusunu çalıştırıp sonucunu true yada false cinsinden döndür
	public function delete(){
		$query =  parent::prepare($this->sql);
		if ($this->data==null) {
			$query->execute();
		}else{	
			$query->execute($this->data);
		}
		return $query;
	}
	public function lastInsertId()
	{
		return $this->last_insert_id;
	}
}