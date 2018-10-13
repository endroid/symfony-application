import Base from './base';

class BarToggle extends Base {
	constructor (el) {
		super(el);

		this.toggle = this.query('.bar__toggle');
		this.togglebar = this.togglebar.bind(this);

		if (this.toggle != null) {
			this.toggle.addEventListener('click', this.togglebar);
		}
	}

	togglebar () {
		const subwrapper = this.query('.bar__sub-wrapper');

		if (subwrapper.classList.contains('open')) {
			this.toggle.classList.remove('open');
			subwrapper.classList.remove('open');
		} else {
			this.toggle.classList.add('open');
			subwrapper.classList.add('open');
		}
	}

}

export default BarToggle;
