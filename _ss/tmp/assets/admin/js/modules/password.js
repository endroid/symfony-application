import Base from './base';

class Password extends Base {
	constructor (el) {
		super(el);



		// this.addEventlistner('submit', this.checkPassword)
		this.form = document.querySelector('#passwordForm');

		if (this.form) {
			this.form.addEventListener('submit', this.checkPassword);
		}
	}

	checkPassword(event) {
		event.preventDefault();

		var passwordOne = document.querySelector('#form_pw1');
		var passwordTwo = document.querySelector('#form_pw2');
		var errorMsg = document.querySelector('.errorMsg');

		if (passwordOne && passwordTwo) {
			if (passwordOne.value == passwordTwo.value) {
				event.target.submit();
			} else {
				errorMsg.setAttribute('style', 'display:block;');
			}
		}

	}
}

export default Password;
