import $ from "jquery";

class Like {
	constructor() {
		$(".like-box").on("click", this.onClick.bind(this));
		this.events();
	}

	events() {}

	// methods
	onClick(e) {
		const currentLikeBox = $(e.target).closest(".like-box");
		if (currentLikeBox.attr("data-exists") == "yes") {
			this.deleteLike(currentLikeBox);
		} else {
			this.createLike(currentLikeBox);
		}
	}
	createLike(currentLikeBox) {
		$.ajax({
			beforeSend: (xhr) => {
				xhr.setRequestHeader("X-WP-Nonce", university_data.nonce);
			},
			url: university_data.root_url + "/wp-json/university/v1/manage_like",
			type: "POST",
			data: {
				professorID: currentLikeBox.data("professor"),
			},
			success: (response) => {
				currentLikeBox.attr("data-exists", "yes");
				let likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);
				likeCount++;
				currentLikeBox.find(".like-count").html(likeCount);
				currentLikeBox.attr("data-like", response);
				console.log(response);
			},
			error: (response) => {
				console.log(response);
			},
		});
	}
	deleteLike(currentLikeBox) {
		$.ajax({
			beforeSend: (xhr) => {
				xhr.setRequestHeader("X-WP-Nonce", university_data.nonce);
			},
			url: university_data.root_url + "/wp-json/university/v1/manage_like",
			data: {
				like: currentLikeBox.attr("data-like"),
			},
			type: "DELETE",
			success: (response) => {
				currentLikeBox.attr("data-exists", "no");
				let likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);
				likeCount--;
				currentLikeBox.find(".like-count").html(likeCount);
				currentLikeBox.attr("data-like", "");
				console.log(response);
			},
			error: (response) => {
				console.log(response);
			},
		});
	}
}

export default Like;
