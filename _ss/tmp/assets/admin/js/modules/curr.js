import Base from './base';

class Curr extends Base {
	constructor (el) {
		super(el);

		// function to set currency depending on body class
		this.currencyClass = document.body.classList[0];
		this.currencyElem = this.queryAll('.form__elem-currency');

		var currency = "";

		switch (this.currencyClass) {
			case "val-eur":
				currency = "€";
				break;
			case "val-usd":
				currency = "$";
				break;
			default:
				console.log("can't find currency");
		}

		this.currencyElem.forEach((elem) => {
			elem.textContent = currency;
		});

		// auto resize textarea
		var textarea = this.queryAll('textarea');

		if (textarea != null) {
			textarea.forEach((elem) => {
				elem.addEventListener('keydown', autosize);
			});
		}

		function autosize() {
			var el = this;
			el.style = 'height:' + el.scrollHeight + 'px';
		}
	}
}

export default Curr;

