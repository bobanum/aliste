/*jslint esnext:true, browser:true*/
/*globals App, Menu*/
class AListe extends App {
	/**
	 * Constructor
	 */
	constructor() {

	}
	/**
	 * Inits the App
	 */
	static init() {
		window.addEventListener("load", function () {
			var menu, item, sub;
			menu = new Menu("Principal");
			menu.hideLabel = true;
			menu.icon = "\x42";
			item = new Menu("Fichier");
			item.parentMenu = menu;
			sub = new Menu("Nouveau");
			sub.icon = "\x43";
			sub.parentMenu = item;
			sub.addEventListener('click', function() {
				alert(9);
			});
			sub = new Menu("Supprimer");
			sub.icon = "\x46";
			sub.parentMenu = item;
			sub = new Menu("Ouvrir");
			sub.parentMenu = item;
			sub.icon = "\x4d";
			item = new Menu("Modifier");
			item.parentMenu = menu;
			item = new Menu("Affichage");
			item.parentMenu = menu;
			document.querySelector("#menuprincipal").appendChild(menu.dom);
		});
	}
}
AListe.init();
