class Helpers {
	constructor () {
	}

	findAncestor (el, className) {
		while ((el = el.parentElement) && !el.classList.contains(className));
		return el;
	}

	nextByClass (node, cls) {
		while ((node = node.nextElementSibling) && !node.classList.contains(cls));
		return node;
	}

	previousByClass (node, cls) {
		while ((node = node.previousElementSibling) && !node.classList.contains(cls));
		return node;
	}


}

export default Helpers;