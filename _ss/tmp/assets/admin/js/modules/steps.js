import Base from './base';

class Steps extends Base {
	constructor (el) {
		super(el);

		//calculate the width of the progressbar based on the
		//amount of total step and te step the form is on right now.

		this.steps = this.query('.steps__step');
		this.stepsNumber = this.steps.getAttribute('data-steps');
		this.totalSteps = this.steps.getAttribute('data-step');

		this.Size = 100 / this.stepsNumber;
		var width = Math.round(this.totalSteps * this.Size);

		this.steps.setAttribute("style", "width:" + width + "%;");
	}
}

export default Steps;
