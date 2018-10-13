import 'core-js/fn/array/from';
import objectFitImages from 'object-fit-images';
import ModuleLoader from './utils/moduleLoader';

class App {
	constructor () {


		this.loader = new ModuleLoader();

	}

	render () {
		objectFitImages();

		this.loader.load();

		return this;
	}

}

window.app = new App().render();
