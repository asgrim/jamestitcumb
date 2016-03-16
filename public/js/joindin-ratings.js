(function(){
	$(document).ready(function () {
		$('.joindin').each(function () {
			var el = $(this);
			var href = el.attr('href');
			var talkId = parseInt(href.substr(href.lastIndexOf('/') + 1));
			$.getJSON('https://api.joind.in/v2.1/talks/' + talkId + '?callback=?', function (data) {
				var rating = data.talks[0].average_rating;
				if (rating > 0) {
					el.after(' <img src="/images/ji-ratings/rating-' + rating + '.gif" />');
				}
			});
		});
	});
})();
