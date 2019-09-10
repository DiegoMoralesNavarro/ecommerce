<?php 

namespace Hcode\Model;

use \Hcode\Model;
use \Hcode\DB\Sql;

class User extends Model {

	const SESSION = "User";

	// protected $fields = [
	// 	"iduser", "idperson", "deslogin", "despassword", "inadmin", "dtergister"
	// ];

	
	public static function login($login, $password):User
	{

		$db = new Sql();

		$results = $db->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
			":LOGIN"=>$login
		));

		if (count($results) === 0) {
			throw new \Exception("Não foi possível fazer login.");
			
			
		}else{
		}

		$data = $results[0];

		if (password_verify($password, $data["despassword"])) {

			$user = new User();
			$user->setData($data);

			$_SESSION[User::SESSION] = $user->getValues();

			return $user;

		} else {
			throw new \Exception("Não foi possível fazer login.2");
			
			

		}

	}

	public static function logout()
	{

		$_SESSION[User::SESSION] = NULL;

	}

	public static function verifyLogin($inadmin = true)
	{

		if (
			!isset($_SESSION[User::SESSION])
			|| 
			!$_SESSION[User::SESSION]
			||
			!(int)$_SESSION[User::SESSION]["iduser"] > 0
			||
			(bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
		) {
			
			header("Location: /admin/login");
			exit;

		}

	}


	public static function listAll(){

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) order by b.desperson");
	}


	public function save(){

		// echo $this->getdesperson(). "<br>";
		// echo $this->getdeslogin()."<br>";
		// echo $this->getdespassword()."<br>";
		// echo $this->getdesemail()."<br>";
		// echo $this->getnrphone()."<br>";
		// echo $this->getinadmin()."<br>";


		$sql = new Sql();

		// // pdesperson VARCHAR(64), 
		// // pdeslogin VARCHAR(64), 
		// // pdespassword VARCHAR(256), 
		// // pdesemail VARCHAR(128), 
		// // pnrphone BIGINT, 
		// // pinadmin TINYINT

		$results = $sql->select("CALL sp_users_save(:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(
			":desperson"=>$this->getdesperson(),
			":deslogin"=>$this->getdeslogin(),
			":despassword"=>$this->getdespassword(),
			":desemail"=>$this->getdesemail(),
			":nrphone"=>$this->getnrphone(),
			":inadmin"=>$this->getinadmin()
		));


		$this->setData($results[0]);
	}

}

 ?>