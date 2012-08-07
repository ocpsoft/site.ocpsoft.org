function toc_build() {

	var $toc = jQuery('#toc-contents');
	var contents = "<ol>";

	contents = contents + "<li><a href='#top'>Introduction</a></li>";

	jQuery(".entry h1, .toc").each(function(idx) {
		var section = jQuery(this);

		contents = contents + "<li><a id='"+section.attr("id")+"_link' href='#" + section.attr("id") + "'>"+section.html()+"</a></li>";
		jQuery("<a name='"+section.attr("id")+"'></a>").insertBefore(section);

	});

	contents = contents + "</ol>"
	$toc.html(contents);
	$toc.prepend("<h3>Table of Contents</h3>");
	$toc.append("<div id='toc_fade'></div>");
	$toc.localScroll({hash: true, offset: {top: -50}});

}

function toc_init() {
	var $toc = jQuery('#toc');
	var $toc_contents = jQuery('#toc-contents');
	var $toc_outer = jQuery("#toc-outer");

	var sections = jQuery(".entry h1, .toc"); //jQuery objects
	var sectionOffsets = {}; //map: id -> int
	var currentSection = false;

	var i = 0;
	sections.each(function(idx) {
		var section = jQuery(this);
		section.attr("id", "section-" + i);
		sectionOffsets[i] = section.position().top;
		i++;
	});

	toc_build();

	var tocMetrics = {
		top: $toc.position().top,
		height: $toc_outer.outerHeight(),
		width: $toc.outerWidth()
	};

	$toc_outer.css({height: $toc_outer.outerHeight(), width: $toc_outer.outerWidth()});
	$toc.css({height: $toc_outer.outerHeight(), width: $toc_outer.outerWidth()});

	var bottomBumper = jQuery('.container').outerHeight() + jQuery('.container').offset().top - 25;
	var linkColor = jQuery('#toc-contents a:first').css('color');

	var updateToc = function() {
		var scrollY = jQuery(window).scrollTop();
		positionToc(scrollY);
		highlightSectionInToc(scrollY);
	}

	var positionToc = function(scrollY) {
		// if scrolled past toc, move it down
		if (scrollY > tocMetrics.top) {
			if ($toc.css('position') != 'fixed') {
				$toc.css('position', 'fixed');
			}

			var remainingHeight = bottomBumper - scrollY;
			// keep toc from overrunning bottom of content
			if (remainingHeight < tocMetrics.height) {
				$toc.css('top', 0 - (tocMetrics.height - remainingHeight));
			}
			else {
				$toc.css('top', 0);
			}
		}
		else {
			if ($toc.css('position') != 'static') {
				$toc.css({position: 'static', top: 0});
			}
		}
	};

	var highlightSectionInToc = function(scrollY) {
		var numSections = sections.length;
		if (numSections == 0) {
			return;
		}

		// if scrolled above first section, unhighlight any
		if (scrollY < sectionOffsets[0]) {
			toggleSelection(false);
		}
		// if last section is in view, highlight it
		else if (scrollY + jQuery(window).height() == jQuery(document).height()) {
			toggleSelection(sections[numSections - 1]);
		}
		// highlight visible section
		else {
			jQuery.each(sections, function(idx, section) {
				if (scrollY > sectionOffsets[idx] && (idx == numSections - 1 || scrollY < sectionOffsets[idx + 1])) {
					toggleSelection(section);
				}
			});
		}
	}

	var toggleSelection = function(section) {
		if (!section || section != currentSection) {
			if (currentSection) {
				jQuery('#' + currentSection.id + '_link').css({fontWeight: 'normal', color: linkColor});
			}
			currentSection = section;
			if (section) {
				jQuery('#' + section.id + '_link').css({fontWeight: 'bold', color: '#333333'});
			}
		}
	}

	updateToc();
	jQuery(window).scroll(updateToc);
}