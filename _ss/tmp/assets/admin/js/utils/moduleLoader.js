import Form from '../modules/form';
import Help from '../modules/help';
import Curr from '../modules/curr';
import Steps from '../modules/steps';
import Search from '../modules/search';
import Password from '../modules/password';
import BarToggle from '../modules/bartoggle';

class ModuleLoader {
	constructor (data = {}, el = document.body, selector = '[data-module]') {
		this.data = {
			form: Form,
			help: Help,
			curr: Curr,
			steps: Steps,
			search: Search,
			password: Password,
			bartoggle: BarToggle
		};

		this.el = el;
		this.selector = selector;

		this.modules = [];
	}

	load () {
		const data = this.data; // eslint-disable-line prefer-destructuring
		const els = Array.from(this.el.querySelectorAll(this.selector));
		const attribute = this.selector.substring(1, this.selector.length - 1);


		els.forEach((el) => {
			const name = el.getAttribute(attribute);
			const Module = data[name];

			if (Module) { // eslint-disable-line no-underscore-dangle
				this.modules.push(new Module(el).render());
			}
		});
	}
}

export default ModuleLoader;
