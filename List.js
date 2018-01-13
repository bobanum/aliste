/*jslint browser:true, esnext:true*/
/*global Database*/
class List extends Database {
	/**
	 * Constructor
	 */
	constructor() {
		super();
	}
	/**
	 * Inits static properties and events
	 */
	static init() {
		this.prototype.databaseName = "aliste";
		this.prototype.stores = this.prototype.stores.concat(["Item"]);
		window.addEventListener("load", function () {
			var l = new List();
//			l.open();
		});
	}
}
List.init();
