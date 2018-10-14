<?php
class Element {
	static public $table_name = "elements";
	public $id = null;
	public $titre = "";
	public $contenu = "";
	public $created_at = null;
	public $updated_at = null;
	public function __construct($data = null) {
		$this->created_at = time();
		$this->updated_at = time();
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
		$champs = [];
		if ($this->id) {
			$sql = "UPDATE ".self::$table_name." SET titre=:titre, contenu=:contenu, created_at=:created_at, updated_at=:updated_at WHERE id=:id";
		} else{
			$sql = "INSERT INTO ".self::$table_name." (id, titre, contenu, created_at, updated_at) VALUES (:id, :titre, :contenu, :created_at, :updated_at)";
		}

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(":id", $this->id);
		$stmt->bindParam(":titre", $this->titre);
		$stmt->bindParam(":contenu", $this->contenu);
		$stmt->bindParam(":created_at", $this->created_at);
		$stmt->bindParam(":updated_at", $this->updated_at);
		$stmt->execute();
		if (!$this->id) {
			$this->id = $pdo->lastInsertId();
		}
		return $this;
	}
	public function delete() {
		$pdo = Liste::connect();
		$champs = [];
		$sql = "DELETE FROM ".self::$table_name." WHERE id=:id";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(":id", $this->id);
		$stmt->execute();
		return $this;
	}
	public function html_liste() {
		$resultat = '';
		$resultat .= '<tr class="element">';
		$resultat .= '<td class="options">';
		$resultat .= $this->html_options();
		$resultat .= '</td>';
		$resultat .= '<td class="titre"><a href="details.php?id='.$this->id.'">'.$this->titre.'</a></td>';
		$resultat .= '<td class="updated_at">'.date("Y-m-j H:m:s", $this->updated_at).'</td>';
		$resultat .= '</tr>';
		return $resultat;
	}
	public function html_options() {
		$resultat = '';
		$resultat .= '<span class="options">';
		$resultat .= '<a class="modifier" href="modifier.php?id='.$this->id.'">';
		$resultat .= '<svg><use href="#modifier"></use></svg>';
//		$resultat .= 'Modifier';
		$resultat .= '</a>';
		$resultat .= '<a class="supprimer" href="supprimer.php?id='.$this->id.'">';
		$resultat .= '<svg><use href="#supprimer"></use></svg>';
//		$resultat .= 'Supprimer';
		$resultat .= '</a>';
		$resultat .= '<a class="details" href="details.php?id='.$this->id.'">';
		$resultat .= '<svg><use href="#details"></use></svg>';
//		$resultat .= 'Supprimer';
		$resultat .= '</a>';
		$resultat .= '</span>';
		return $resultat;
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
	static function get($id) {
		$pdo = Liste::connect();
		$sql = "SELECT * FROM ".self::$table_name." WHERE id=:id";
		$stmt = $pdo->prepare($sql);
		$stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Element");
		$stmt->bindParam(":id", $id);
		$stmt->execute();
		$resultat = $stmt->fetch();
		return $resultat;
	}
	static function getAll() {
		$pdo = Liste::connect();
		$sql = "SELECT * FROM ".self::$table_name;
		$stmt = $pdo->prepare($sql);
		$stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "Element");
		$stmt->execute();
		$resultat = $stmt->fetchAll();
		return $resultat;
	}
	static function html_listeAll() {
		$elements = self::getAll();
		$resultat = '';
		$resultat .= '<table class="elements">';
		$resultat .= '<thead><tr>';
		$resultat .= '<th>Options</th>';
		$resultat .= '<th>Titre</th>';
		$resultat .= '<th>Date de modification</th>';
		$resultat .= '</tr></thead>';
		foreach ($elements as $cle => $element) {
			$resultat .= $element->html_liste();
		}
		$resultat .= '</table>';
		return $resultat;
	}
	function html_details() {
		$resultat = '';
		$resultat .= '<div class="details">';
		$resultat .= '<div class="champ" id="champ-titre">';
		$resultat .= '<span class="label">Titre :</span>';
		$resultat .= '<span>'.$this->titre.'</span>';
		$resultat .= '</div>';
		$resultat .= '<div class="champ" id="champ-contenu">';
		$resultat .= '<span class="label">Contenu :</span>';
		$resultat .= '<span>'.$this->contenu.'</span>';
		$resultat .= '</div>';
		$resultat .= '</div>';
		return $resultat;
	}
	static function html_form_ajouter() {
		$resultat = '';
		$resultat .= '<form action="ajouter.php" method="post">';
		$resultat .= '<div class="champ" id="champ-titre">';
		$resultat .= '<label for="titre">Titre</label>';
		$resultat .= '<span><input type="text" name="titre" id="titre"/></span>';
		$resultat .= '</div>';
		$resultat .= '<div class="champ" id="champ-contenu">';
		$resultat .= '<label for="contenu">Contenu</label>';
		$resultat .= '<span><textarea name="contenu" id="contenu" cols="30" rows="10"></textarea></span>';
		$resultat .= '</div>';
		$resultat .= '<div>';
		$resultat .= '<input type="submit" value="Ajouter"/>';
		$resultat .= '<input type="submit" name="annuler" value="Annuler"/>';
		$resultat .= '<input type="hidden" name="action" value="ajouter"/>';
		$resultat .= '</div>';
		$resultat .= '</form>';
		return $resultat;
	}
	function html_form_modifier() {
		$resultat = '';
		$resultat .= '<form action="modifier.php" method="post">';
		$resultat .= '<div class="champ" id="champ-titre">';
		$resultat .= '<label for="titre">Titre</label>';
		$resultat .= '<span><input type="text" name="titre" id="titre" value="'.$this->titre.'"/></span>';
		$resultat .= '</div>';
		$resultat .= '<div class="champ" id="champ-contenu">';
		$resultat .= '<label for="contenu">Contenu</label>';
		$resultat .= '<span><textarea name="contenu" id="contenu" cols="30" rows="10">'.$this->contenu.'</textarea></span>';
		$resultat .= '</div>';
		$resultat .= '<div class="champ" id="champ-created_at">';
		$resultat .= '<label for="created_at">Date de création</label>';
		$resultat .= '<span><input type="date" name="created_at" id="created_at" value="'.$this->created_at.'"/></span>';
		$resultat .= '</div>';
		$resultat .= '<div class="champ" id="champ-updated_at">';
		$resultat .= '<label for="updated_at">Dernière modification</label>';
		$resultat .= '<span><input type="date" name="updated_at" id="updated_at" value="'.$this->updated_at.'"/></span>';
		$resultat .= '</div>';
		$resultat .= '<div>';
		$resultat .= '<input type="submit" value="Modifier"/>';
		$resultat .= '<input type="submit" name="annuler" value="Annuler"/>';
		$resultat .= '<input type="hidden" name="id" value="'.$this->id.'"/>';
		$resultat .= '<input type="hidden" name="action" value="modifier"/>';
		$resultat .= '</div>';
		$resultat .= '</form>';
		return $resultat;
	}
	function html_form_supprimer() {
		$resultat = '';
		$resultat .= '<form action="supprimer.php" method="post">';
		$resultat .= '<h2>Voulez-vous vraiment supprimer cet élément ?</h2>';
		$resultat .= '<div>';
		$resultat .= '<input type="submit" value="Supprimer"/>';
		$resultat .= '<input type="submit" name="annuler" value="Annuler"/>';
		$resultat .= '<input type="hidden" name="id" value="'.$this->id.'"/>';
		$resultat .= '<input type="hidden" name="action" value="supprimer"/>';
		$resultat .= '</div>';
		$resultat .= '</form>';
		return $resultat;
	}
	static function traiterAjouter($source) {
		$element = new Element($source);
		$element->save();
		return $element;
	}
	static function traiterModifier($source) {
		$element = Element::get($source['id']);
		if (!$element) {
			return false;
		}
		$element->fill($source);
		$element->save();
		return $element;
	}
	static function traiterSupprimer($source) {
		$element = Element::get($source['id']);
		if (!$element) {
			return false;
		}
		$element->delete($source);
		return $element;
	}
}
