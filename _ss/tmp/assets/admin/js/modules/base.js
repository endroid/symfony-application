class Base {
	constructor (el) {
		this.el = el;
	}

	get el () {
		return this._el;
	}

	set el (el) {
		if (!el) {
			this._el = document.createElement('div');
		} else if (typeof el === 'string') {
			this._el = document.querySelector(el);
		} else {
			this._el = el;
		}
	}

	query (selector, el = this.el) {
		return el.querySelector(selector);
	}

	queryAll (selector, el = this.el) {
		return Array.from(el.querySelectorAll(selector));
	}

	render () {
		// Call afterRender
		this.afterRender();

		return this;
	}

	afterRender () { // eslint-disable-line class-methods-use-this
		// No-op, override //
	}
}

export default Base;
