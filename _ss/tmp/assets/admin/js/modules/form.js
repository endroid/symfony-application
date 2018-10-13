import Base from './base';
import Helpers from './helpers';

class Form extends Base {
	constructor (el) {
		super(el);

		// form dates
		flatpickr("#form_date", {});

		// close notifications
		this.closeNotification = this.query('.close-notification');

		if (this.closeNotification != null){
			this.closeNotification.addEventListener('click', this.closeNoti);
		}

		// helper for parent selection
		const helper = new Helpers();

		// Change HTML for all radio and checkbox inputs
		this.formRadios = this.queryAll('.form-check input');
		this.formRadios.forEach((elem) => {
			const elemID = elem.id;
			const parent = helper.findAncestor(elem, 'form-check-label');
			parent.setAttribute("for", elemID);
			parent.insertAdjacentElement('beforebegin', elem)
		});

		// event handling for texttype inputs
		this.formElements = this.queryAll('.form__elem input, .form__elem textarea, .form__elem select');

		this.formElements.forEach((element) => {
			element.addEventListener('focus', this.formAddClass);
			element.addEventListener('focusout', this.formRemoveClass);
			element.addEventListener('change', this.formCheck);

			if (element.value.length !== 0){
				element.parentElement.classList.add('field-active');
			}
		});

	}

	formAddClass(el) {
		el.target.parentElement.classList.add('field-active');
	}

	formRemoveClass(el) {
		if (el.target.value == ""){
			el.target.parentElement.classList.remove('field-active');
		}
	}

	formCheck(el) {
		var helpers = new Helpers();
		const parent = helpers.findAncestor(el.target, 'form__elem');

		if (el.target.value !== ""){
			el.target.parentElement.classList.add('field-active');
		}

		if (parent.getElementsByClassName('invalid-feedback')[0]){
			parent.getElementsByClassName('is-invalid')[0].classList.remove('is-invalid');
			const ErrorDiv = parent.getElementsByClassName('invalid-feedback')[0];
			ErrorDiv.parentNode.removeChild(ErrorDiv);
		}
	}

	closeNoti(el) {
		const ErrorDiv = document.getElementsByClassName('form__notification')[0];
		ErrorDiv.parentNode.removeChild(ErrorDiv);
	}

}

export default Form;
