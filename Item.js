/*jslint browser:true, esnext:true*/
/*global Store*/
class Item extends Store {
	constructor(title) {
		super(Item.createId());
		this.firstChild = null;
		this.nextSibling = null;
		this.previousSibling = null;
		this.parentNode = null;
		this.title = title || "";
	}
	get children() {
		var result, ptr;
		result = [];
		ptr = this.firstChild;
		while (ptr) {
			result.push(ptr);
			ptr = ptr.nextSibling;
		}
		return result;
	}
	get lastChild() {
		if (!this.firstChild) {
			return null;
		}
		return this.firstChild.lastSibling;
	}
	get firstSibling() {
		var ptr;
		ptr = this;
		while (ptr.previousSibling) {
			ptr = ptr.previousSibling;
		}
		return ptr;
	}
	get lastSibling() {
		var ptr;
		ptr = this;
		while (ptr.nextSibling) {
			ptr = ptr.nextSibling;
		}
		return ptr;
	}
	get index() {
		var result, ptr;
		result = 0;
		ptr = this.previousSibling;
		while (ptr) {
			result += 1;
			ptr = ptr.previousSibling;
		}
		return result;
	}
	dom_create() {
		var result;
		result = document.createElement("article");
		result.classList.add("list");
		result.setAttribute("id", this.id);
		result.appendChild(this.dom_header());
		result.appendChild(this.dom_footer());
		result.appendChild(this.dom_body());
		return result;
	}
	dom_header() {
		var result;
		result = document.createElement("header");
		result.appendChild(this.dom_menu());
		result.appendChild(this.dom_title());
		return result;
	}
	dom_footer() {
		var result;
		result = document.createElement("footer");
		result.innerHTML = "Sauvegardé le 3 mai 2017 à 10:23 (footer)";
		return result;
	}
	dom_body() {
		var result;
		result = document.createElement("div");
		result.classList.add("body");
		result.innerHTML = "body";
		return result;
	}
	dom_title() {
		var result;
		result = document.createElement("div");
		result.innerHTML = this.title;
		return result;
	}
	dom_menu() {
		var result;
		result = document.createElement("ul");
		result.classList.add("menu");
		return result;
	}
	appendChild(node) {
		var ptr;
		if (node === this) {
			throw "On ne peut pas insérer cet élément.";
		}
		//TODO Vérifier les ancetres pour eviter les refs circulaires
		node.remove();
		node.parentNode = this;
		ptr = this.lastChild;
		if (ptr) {
			ptr.nextSibling = node;
			node.previousSibling = ptr;
		} else {
			this.firstChild = node;
		}
		return node;
	}
	removeChild(node) {
		if (node.parentNode !== this) {
			throw "Mauvais parent";
		}
		if (node.previousSibling) {
			node.previousSibling.nextSibling = node.nextSibling;
		} else {
			node.parentNode.firstChild = node.nextSibling;
		}
		if (node.nextSibling) {
			node.nextSibling.previousSibling = node.previousSibling;
		}
		node.parentNode = node.previousSibling = node.nextSibling = null;
		return node;
	}
	remove() {
		if (this.parentNode) {
			this.parentNode.removeChild(this);
		} else {
			this.previousSibling = this.nextSibling = null;
		}
		return this;
	}
	insertBefore(node, ref) {
		if (ref === null) {
			return this.appendChild(node);
		}
		if (ref.parentNode !== this) {
			throw "Mauvais parent";
		}
		node.remove();
		node.parentNode = this;
		node.nextSibling = ref;
		node.previousSibling = ref.previousSibling;
		if (ref.previousSibling) {
			ref.previousSibling.nextSibling = node;
		}
		ref.previousSibling = node;
		return node;
	}
	replaceChild(node, ref) {
		if (ref.parentNode !== this) {
			throw "Mauvais parent";
		}
		node.remove();
		this.insertBefore(node, ref);
		ref.remove();
	}
	toObj() {
		return {id:this.id, title:this.title};
	}
	static createStore(db) {
		var objectStore;
		objectStore = super.createStore(db);
		objectStore.transaction.addEventListener("complete", function() {
			var item;
			item = new Item("test");
			item.id = "abc123";
			item.save();
			item = new Item("retest");
			item.id = "abcd1234";
			item.save();
		});
	}
	static init() {
		this.storeName = "items";
	}
}
Item.init();
