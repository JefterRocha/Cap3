<?php  
	Class Database {

		private $dataBaseHandler;
		private $error;
		private $statement;

		public function __construct() {
			$options = array(
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			);
			try {
				$this->dataBaseHandler = new PDO('mysql:host='. DB_HOST.';dbname='. DB_NAME, DB_USER, DB_PASS, $options);
				$this->dataBaseHandler->exec('SET NAMES UTF8');
			}
			catch(PDOException $e) {
				$this->error = $e->getMessage();
			}
		}

		public function query($query) {
			$this->statement = $this->dataBaseHandler->prepare($query);
		}

		public function bind($param, $value, $type = null) {
			if (is_null($type)) {
				switch (true) {
					case is_int($value):
						$type = PDO::PARAM_INT;
					break;
					case is_bool($value):
						$type = PDO::PARAM_BOOL;
					break;
					case is_null($value):
						$type = PDO::PARAM_NULL;
					break;
					default:
						$type = PDO::PARAM_STR;
				}
			}
			$this->statement->bindValue($param, $value, $type);
		}

		public function execute() {
			return $this->statement->execute();
		}

		public function resultset() {
			$this->execute();
			return $this->statement->fetchAll(PDO::FETCH_ASSOC);
		}

		public function single() {
			$this->execute();
			return $this->statement->fetch(PDO::FETCH_ASSOC);
		}

		public function rowCount() {
			return $this->statement->rowCount();
		}

		public function lastInsertId() {
			return $this->dataBaseHandler->lastInsertId();
		}

		public function beginTransaction() {
			return $this->dataBaseHandler->beginTransaction();
		}

		public function endTransaction() {
			return $this->dataBaseHandler->commit();
		}

		public function cancelTransaction() {
			return $this->dataBaseHandler->rollBack();
		}

		public function debugDumpParams() {
			return $this->statement->debugDumpParams();
		}

		public function closeCursor() {
			$this->statement->closeCursor();
		}
	}
?>