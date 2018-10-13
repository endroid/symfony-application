import Base from './base';

class Help extends Base {
	constructor (el) {
		super(el);

		this.openHelp = this.query('.Help__button');
		this.closeHelp = this.query('.close-help');

		this.openHelp.addEventListener('click', this.openWindow);
		this.closeHelp.addEventListener('click', this.closeWindow);

		window.addEventListener('keydown', (e) => {
			const helpWindow = document.querySelector('.Help');

		if (e.keyCode === 27 && helpWindow.classList.contains('help-open')) {
			helpWindow.classList.remove('help-open');
		}
		});
	}

	openWindow(el) {
		const helpWindow = document.querySelector('.Help');
		helpWindow.classList.add('help-open');
	}

	closeWindow(el) {
		const helpWindow = document.querySelector('.Help');
		helpWindow.classList.remove('help-open');
	}
}

export default Help;
