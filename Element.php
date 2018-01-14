<?php
class Element {
	static public $table_name = "elements";
	public $id = null;
	public $titre = "";
	public $contenu = "";
	public $created_at = null;
	public $updated_at = null;
	public function __construct($data = null) {
		$this->fill($data);
	}
	public function fill($data = null) {
		if (is_null($data)) {
			return $this;
		}
		foreach ($data as $nomChamp => $valeurChamp) {
			if (property_exists($this, $nomChamp)) {
				$this->$nomChamp = $valeurChamp;
			}
		}
		return $this;
	}
	public function save() {
		$pdo = Liste::connect();
//		return;
		$champs = [];
		if ($this->id) {
			$sql = "UPDATE ".self::$table_name." SET titre=:titre, contenu=:contenu, created_at=:created_at, updated_at=:updated_at WHERE id=:id";
		} else{
			$sql = "INSERT INTO ".self::$table_name." (id, titre, contenu, created_at, updated_at) VALUES (:id, :titre, :contenu, :created_at, :updated_at)";
		}
		var_dump($sql);
		var_dump($pdo->errorInfo());

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(":id", $this->id);
		$stmt->bindParam(":titre", $this->titre);
		$stmt->bindParam(":contenu", $this->contenu);
		$stmt->bindParam(":created_at", $this->created_at);
		$stmt->bindParam(":updated_at", $this->updated_at);
		$stmt->execute();
		var_dump($this);
		return $this;
	}
	static function install($pdo) {
		$pdo->query(self::sql_install());
	}
	static function sql_install() {
		$champs = [];
		$champs[] = "id INTEGER PRIMARY KEY AUTOINCREMENT";
		$champs[] = "titre TEXT";
		$champs[] = "contenu TEXT";
		$champs[] = "created_at INTEGER";
		$champs[] = "updated_at INTEGER";
		$champs = implode(", ", $champs);
		$resultat = "CREATE TABLE IF NOT EXISTS ".self::$table_name." ($champs)";
		return $resultat;
	}
}
