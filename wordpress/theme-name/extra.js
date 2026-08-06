jQuery(document).ready(function($) {
	// remove rel="nofollow" from social media links
	if ($('.main-nav .social a').length) {
		$('.main-nav .social a').removeAttr('rel');
	}
	if ($('.socials a.external').length) {
		$('.socials a.external').removeAttr('rel');
	}

	// find "english stories" link in menu and a class to it. also some minor tweaks.
	const englishStories = $('#menu-submenu .nav-link[href$="/english-stories/"]');
	if (englishStories.length) {
		englishStories.parent().addClass('english-stories');
		englishStories.parent().next().children().first().css('border-left', '1px solid #333');
	}

	// find "slidstvo club" link in menu and a class to it
	const slidstvoClub = $('#menu-headermenu .nav-link[href$="/slidstvo_club/"]');
	if (slidstvoClub.length) {
		slidstvoClub.parent().addClass('specprojects-btn');
	}

	// find warnews link in menu and a class to it. also some minor tweaks.
	const warnewsLink = $('#menu-submenu .nav-link[href="/warnews"]');
	if (warnewsLink.length) {
		warnewsLink.parent().addClass('warnews');
		warnewsLink.parent().next().children().first().css('border-left', '1px solid rgba(34,34,34,.3)');
	}

	// implement Special Projects menu item
	let specItem = $('#menu-submenu a[href="/special-projects/"]');
	if (specItem.length) {
		// add submenu for Special Projects
		let subMenu = $(`<ul class="spec_sub_menu" style="display: none;">
			<!--
			<li class="success_stories menu-item menu-item-type-custom menu-item-object-custom nav-item">
				<a href="/success-stories-page/">Історії успіху</a>
			</li>
			-->
			<li class="success_stories menu-item menu-item-type-custom menu-item-object-custom nav-item">
				<a href="/kupiansk-istoriia-okupatsii-odnoho-mista/">Куп’янськ</a>
			</li>

			<li class="church_gold menu-item menu-item-type-custom menu-item-object-custom nav-item">
				<a href="/special-projects/zoloto-tserkvy/">Золото церкви</a>
			</li>
			<li class="pravosyllya menu-item menu-item-type-custom menu-item-object-custom nav-item">
				<a href="/special-projects/pravosyllya/">Правосилля</a>
			</li>
			<li class="posipaky menu-item menu-item-type-custom menu-item-object-custom nav-item">
				<a href="/special-projects/posipaky/">Посіпаки</a>
			</li>
			<li class="events menu-item menu-item-type-custom menu-item-object-custom nav-item">
				<a href="/events/">Події</a>
			</li>
			<li class="covid_map menu-item menu-item-type-custom menu-item-object-custom nav-item">
				<a href="/special-projects/koronavirus-karta-zakupivel-medychnyh-vyrobiv-v-ukrayini/">Коронавірус</a>
			</li>
		</ul>`);
		specItem.parent().parent().after(subMenu);

		// show submenu on hover
		var timeout;
		specItem.hover(function() {
			clearTimeout(timeout);
			subMenu.slideDown();
		}, function() {
			timeout = setTimeout(function() {
				subMenu.slideUp();
			}, 800);
		});
		subMenu.find('a').hover(function() {
			clearTimeout(timeout);
			subMenu.slideDown();
		}, function() {
			timeout = setTimeout(function() {
				subMenu.slideUp();
			}, 800);
		});
	}

	// Post views counter update on front after ajax update call
	// this event is added in frontend.js in pvc plugin
	$(document).on('pvcCheckPost', function(response) {
		//console.log('response', response);
		// update views count if related element is on the page
		if ($('.post_views_quantity_front').length && response.detail) {
			$('.post_views_quantity_front').text(response.detail);
		}
	});

});