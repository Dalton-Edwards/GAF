function token() {
	$.getJSON('https://giveafuck.club/api/token.php', function (json) {
		$('#gameform input[name=token]').val(json.token);
	});
}

// Functions
function themeCheck() {
	var hour = new Date().getHours();
	// 10:00 PM - 7:00 AM
	if (topic === 'rainbow') {
		$('body').removeClass();
		$('body').addClass('rainbow');
	} else if (hour >= 22 || hour < 7) {
		$('body').removeClass();
		$('body').addClass('night');
	} else {
		$('body').removeClass();
		$('body').addClass('light');
	}
}

function trending() {
	$('#trending').empty();
	$.getJSON("https://giveafuck.club/api/trending.php", function (data) {
		$.each(data, function (index) {
			var topic = data[index].topic;
			var fucks = data[index].fucks;
			$('#content').append('<a href="https://giveafuck.club/topic/' + topic + '"><div class="card" ontouchstart=""><h2 class="title">#' + topic + '</h2><h2>' + fucks.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '</h2></div></a>');
		});
	});
}

function getFucks(topic) {
	if (topic != '') {
		$.getJSON('https://giveafuck.club/api/view.php?topic=' + topic, function (json) {
			if (json.error != false) {
				$('#gameform button').remove();
				$('#leaderboard').remove();
				$('#content').html('<div class="card" ontouchstart=""><h2 class="title">Error</h2><h2>' + json.error + '</h2></div>');
			} else {
				if (json.fucks === null) {
					var fucks = 0;
				} else {
					var fucks = json.fucks.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
				}
				$('#content').html('<div class="message"><h2>Give a Fuck!</h2><p>Click the "+1" button below as many times as you want.</p></div><div class="card" ontouchstart=""><h2 class="title">#' + topic + '</h2><h2>' + fucks + '</h2></div>');
			}
		});
	}
}

function leaderboard(topic) {
	$('body').append('<div id="leaderboard"></div>');
	$.getJSON('https://giveafuck.club/api/leaderboard.php?topic=' + topic, function (data) {
		$.each(data, function (index) {
			var country = data[index].country;
			var fucks = data[index].fucks;
			$('#leaderboard').append('<div class="card" ontouchstart=""><h2 class="title">' + country + '</h2><h2>' + fucks.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',') + '</h2></div>');
		});
	});
}

var pathname = window.location.pathname.replace('/topic/','');
var topic = $('input[type=hidden][name=topic]').val();

if (pathname === '/') {
	$('#content').append('<div class="message"><h2>Welcome!</h2><p>Search for a topic above or choose one of the trending topics from this page.</p></div>');
	trending();
} else if (pathname !== null) {
	getFucks(pathname);
	// Update once per minute.
	setInterval(getFucks, 1000, pathname);
	$('body').append('<div id="game"><form action="https://giveafuck.club/api/add.php" method="POST" id="gameform"><input type="hidden" name="token" value="' + token() + '"><input type="hidden" name="topic" value="' + pathname + '"><button type="submit" ontouchstart="">+1</button></form></div>');
	var preventSubmit = function (event) {
		if (event.keyCode == 13) {
			alert('No cheating!');
			$('button').blur()
			event.preventDefault();
			return false;
		}
	}
	$('#gameform').keypress(preventSubmit);
	$('#gameform').keydown(preventSubmit);
	$('#gameform').keyup(preventSubmit);

	$(function () {
		$('#gameform').submit(function () {
			$.post($(this).attr('action'), $(this).serialize(), function (json) {
				if (json.error != false) {
					alert(json.error);
				}
			}, 'json');
			return false;
		});
	});
	// Show leaderboard
	leaderboard(pathname);
	$('#leaderboard').prepend('<div class="message"><h2>Leaderboard</h2><p>Below is a list of all countries who have given a fuck about this topic today.</p></div>');
} else {
	alert("IDK");
}


// Check once per minute.
themeCheck();
setInterval(themeCheck, 60000);
