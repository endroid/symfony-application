import Base from './base';
import Fuse from 'fuse.js';
import Helpers from './helpers';


class Search extends Base {
	constructor (el) {
		super(el);

		this.searchItems = this.queryAll('.search-item');
		this.barItems = this.queryAll('.bar');

		this.selectCountry = this.selectCountry.bind(this);
		this.adjustCounter = this.adjustCounter.bind(this);
		this.removeitem = this.removeitem.bind(this);
		this.refreshSearch = this.refreshSearch.bind(this);

		this.elemArray = [];
		this.searchItems.forEach((element) => {
			element.addEventListener('click', this.selectCountry);

			// Add all .bar elements to an array
			var array = [];

			array['title'] = element.getAttribute('data-name');
			array['id'] = element.getAttribute('data-id');

			this.elemArray.push(array);
		});

		this.barItems.forEach((element) => {
			element.addEventListener('click', this.SimulateClick);
		});

		//trigger the refresh function on input
		this.searchBar = this.query('.search-bar-fuse');
		if (this.searchBar) {
			this.searchBar.addEventListener('input', this.refreshSearch);
		}

		this.selectedItems = this.queryAll('.bar--country');

		this.selectedItems.forEach((element) => {
			element.querySelector('.bar__close').addEventListener('click', this.removeitem)
		});

		//open selected containers
		this.barwrap = this.query('.selected-toggle');
		if (this.barwrap) {
			this.barwrap.addEventListener('mousedown', this.openSelected);
		}

		window.addEventListener('keydown', this.navigateList);
	}

	// Simulate a click in the toggle button when a .bar element is clicked
	SimulateClick(el) {
		var helpers = new Helpers();
		if (!el.target.classList.contains('switch__slider')){
			var input = helpers.findAncestor(el.target, 'bar');
			if (input && !input.classList.contains('bar--country')) {
				input = input.getElementsByTagName('input')[0];
				input.click();
			}
		}
	}

	openSelected() {
		const selectedContainer = document.querySelector('.bar-wrapper--selected');
		const selectedToggle = document.querySelector('.selected-toggle');

		if (selectedContainer.classList.contains('active')) {
			selectedContainer.classList.remove('active');
			selectedToggle.classList.remove('selected-toggle--active');
		} else {
			selectedContainer.classList.add('active');
			selectedToggle.classList.add('selected-toggle--active');
		}
	}

	//Refresh search function to search and sort items
	refreshSearch(event) {
		// initialize Fuse.js
		var options = {
			shouldSort: true,
			includeScore: true,
			threshold: 0.4, //A threshold of 0.0 requires a perfect match (of both letters and location), a threshold of 1.0 would match anything.
			location: 0,
			distance: 10,
			maxPatternLength: 32,
			minMatchCharLength: 1,
			keys: [
				"title"
				// removed "id" key for now because we dont need it.
			]
		};

		// Set some vars
		var input = event.target.value;
		var fuse = new Fuse(this.elemArray, options);
		var results = fuse.search(input);


		this.searchItems.forEach((element) => {
			element.setAttribute("style", "display:none;");
			element.classList.remove('show');
		});

		// check each result and update each element after a new result.
		// Also apply some exceptions for checked items
		results.forEach((result) => {
			var item = result.item.title;

			this.searchItems.forEach((element) => {
				if (element.getAttribute('data-name') === item) {
					element.setAttribute("style", "display:block;");
					element.classList.add('show');
				}

			});
		});
	}

	selectCountry(el) {
		var countries = this.queryAll('.bar--country');
		const searchBar = document.querySelector('.form__elem-searchbar input');

		searchBar.value = '';
		searchBar.focus();

		countries.forEach((elem) => {
			if (elem.getAttribute('data-name') === el.target.getAttribute('data-name')) {
				elem.setAttribute('style', 'display:block;');
				elem.querySelector('input[type="checkbox"]').checked = true;
			}
		});

		this.searchItems.forEach((element) => {
			element.setAttribute("style", "display:none;");
		});

		this.adjustCounter();
	}

	removeitem (el) {
		const Helper = new Helpers();
		const element = Helper.findAncestor(el.target, 'bar--country');

		element.setAttribute("style", "display:none;");
		element.querySelector('input[type="checkbox"]').checked = false;

		this.adjustCounter();
	}

	adjustCounter () {
		var countries = document.querySelectorAll('.bar--country');
		var countryName = document.querySelector('.bar__name--country .nr');
		var countryMultiple = document.querySelector('.bar__name--country .txt');

		var number = 0;
		countries.forEach((elem) => {
				if (elem.getAttribute('style') === 'display:block;') {
					number++;
				}
		});

		countryName.textContent = number;

		if (number === 1) {
			countryMultiple.setAttribute('style', 'display:none;');
		} else {
			countryMultiple.setAttribute('style', 'display:inline;');
		}
	}

	navigateList (e) {
		var results = document.querySelectorAll('.search-item.show');
		const searchBar = document.querySelector('.form__elem-searchbar input');

		if (results.length !== 0) {
			e = e || window.event;
			switch (e.which || e.keyCode) {
				case 38: // up
					if (document.querySelector('.search-item.show.active')) {
						var Helper = new Helpers();
						var current = document.querySelector('.search-item.show.active');
						const next = Helper.previousByClass(current, 'show');
						current.classList.remove('active');
						if (next) {
							next.classList.add('active');
						}
					} else {
						document.querySelector('.search-item.show:last-child').classList.add('active');
					}
					break;

				case 40: // down
					if (document.querySelector('.search-item.show.active')) {
						var Helper = new Helpers();
						var current = document.querySelector('.search-item.show.active');
						const next = Helper.nextByClass(current, 'show');
						current.classList.remove('active');
						if (next) {
							next.classList.add('active');
						}
					} else {
						document.querySelector('.search-item.show').classList.add('active');
					}
					break;

				case 13:
					e.preventDefault();
					searchBar.blur();
					const active = document.querySelector('.search-item.show.active');
					if (active) {
						active.click();
					}
					break;

				default:
					return; // exit this handler for other keys
			}

		}

	}
};

export default Search;

