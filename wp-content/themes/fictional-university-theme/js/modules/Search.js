import $ from "jquery";
class Search {
	// 1 describe and creat our object
	constructor() {
		this.addSearchHTML();
		this.resultsDiv = $("#search-overlay__results");
		this.openButton = $(".js-search-trigger");
		this.closeButton = $(".search-overlay__close");
		this.searchOverlay = $(".search-overlay");
		this.searchField = $(".search-term");
		this.events();
		this.isOverlayOpen = false;
		this.isSpinnerVisible = false;
		this.previousValue;
		this.typingTimer;
	}
	// events
	events() {
		this.openButton.on("click", this.openOverlay.bind(this));
		this.closeButton.on("click", this.closeOverlay.bind(this));
		$(document).on("keydown", this.keyPressDispatcher.bind(this));
		this.searchField.on("keyup", this.typingLogic.bind(this));
	}
	// methods (functions and shit)
	openOverlay() {
		this.searchOverlay.addClass("search-overlay--active");
		$("body").addClass("body-no-scroll");
		this.searchField.val("");
		// wait for transition to finish and then add focus to text field
		setTimeout(() => {
			this.searchField.focus();
		}, 301);
        this.isOverlayOpen = true;
        // this will prevent the functionality of link tags clicked on when bringing up the overlay. so if js is not loading this will not run and the link will take users to the search page
        return false;
	}

	closeOverlay() {
		this.searchOverlay.removeClass("search-overlay--active");
		$("body").removeClass("body-no-scroll");
		this.isOverlayOpen = false;
	}

	keyPressDispatcher(e) {
		if (e.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea").is(":focus")) {
			this.openOverlay();
		}
		if (e.keyCode == 27 && this.isOverlayOpen) {
			this.closeOverlay();
		}
	}

	typingLogic(e) {
		// causes the function to wait until a few miliseconds after you stop typing before sending the request
		if (this.searchField.val() != this.previousValue) {
			clearTimeout(this.typingTimer);
			if (this.searchField.val()) {
				if (!this.isSpinnerVisible) {
					this.resultsDiv.html('<div class="spinner-loader"></div>');
					this.isSpinnerVisible = true;
				}
				this.typingTimer = setTimeout(this.getResults.bind(this), 500);
			} else {
				this.resultsDiv.html("");
				this.isSpinnerVisible = false;
			}
		}

		this.previousValue = this.searchField.val();
	}

    getResults() {
        $.getJSON(university_data.root_url + "/wp-json/university/v1/search?term=" + this.searchField.val(), results => {
        this.resultsDiv.html(`
            <div class="row">
            <div class="one-third">
                <h2 class="search-overlay__section-title">General Information</h2>
                ${results.general_info.length ? '<ul class="link-list min-list">' : "<p>No general information matches that search.</p>"}
                ${results.general_info.map(item => `<li><a href="${item.permalink}">${item.title}</a> ${item.post_type == "post" ? `by ${item.author_name}` : ""}</li>`).join("")}
                ${results.general_info.length ? "</ul>" : ""}
            </div>
            <div class="one-third">
                <h2 class="search-overlay__section-title">Languages</h2>
                ${results.programs.length ? '<ul class="link-list min-list">' : `<p>No languages match that search. <a href="${university_data.root_url}/languages">View all languages.</a></p>`}
                ${results.programs.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join("")}
                ${results.programs.length ? "</ul>" : ""}
    
                <h2 class="search-overlay__section-title">Projects</h2>
                ${results.projects.length ? '<ul class="project-cards">' : "<p>No projects matches that search.</p>"}
                ${results.projects.map(item => ` <li class="project-card__list-item">
                <a class="project-card" href="${item.permalink }">
                <img class="project-card__image" src="${item.image}" alt="">
                <span class="project-card__name"> ${ item.title}</span>
            </a>
        </li>`).join("")}
                ${results.projects.length ? "</ul>" : ""}
    
            </div>
            <div class="one-third">
                <h2 class="search-overlay__section-title">Locations</h2>
                ${results.locations.length ? '<ul class="link-list min-list">' : `<p>No locations match that search. <a href="${university_data.root_url}/locations">View all locations</a></p>`}
                ${results.locations.map(item => `<li><a href="${item.permalink}">${item.title}</a></li>`).join("")}
                ${results.locations.length ? "</ul>" : ""}
    
                <h2 class="search-overlay__section-title">Events</h2>
                ${results.events.length ? '' : `<p>No events match that search. <a href="${university_data.root_url}/events">View all events</a></p>`}
                ${results.events.map(item => `
                <div class="event-summary">
            <a class="event-summary__date t-center" href="${item.permalink}">
            <span class="event-summary__month">${item.month}</span>
            <span class="event-summary__day">
            ${item.day}
            </span>
            </a>
<div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
                <p>${item.description} <a href="${item.permalink}" class="nu gray">Learn more</a></p>
            </div>
            </div>
                `).join("")}
            </div>
            </div>
        `)
        this.isSpinnerVisible = false
        })
    }
    
	// access results object from the wp api and display results to a list

	// html for this exists here to save users data if they have js disabled
	addSearchHTML() {
		$("body").append(`  <div class="search-overlay">
        <div class="search-overlay__top">
            <div class="container">
                <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                <input type="text" class="search-term" autocomplete="off" placeholder="what are you looking for?" id="search-term">
                <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
            </div>
        </div>
        <div class="container">
            <div id="search-overlay__results">
                    
            </div>
        </div>
    </div>
        `);
	}
}

export default Search;
