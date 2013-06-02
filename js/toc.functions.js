function toc_build(section_scroll_offset, selectors) {

	var $toc = jQuery('#toc-contents');
	var contents = "<ol>";

	jQuery(selectors).not(".notoc").each(function(idx) {
		var section = jQuery(this);

		contents = contents + "<li><a id='"+section.attr("id")+"_link' href='#" + section.attr("id") + "'>"+section.html()+"</a></li>";
		jQuery("<a id='"+section.attr("id")+"' name='"+section.attr("id")+"'></a>").insertBefore(section);

	});

	contents = contents + "</ol>"
	$toc.html(contents);
	$toc.prepend("<h3>Table of Contents</h3>");
	$toc.append("<div id='toc_fade'></div>");
	$toc.localScroll({hash: true, offset: {top: section_scroll_offset}});

}

function toc_init(selectors) {
	if(!selectors)
		selectors = "#top, .entry h1, .toc, #comments";

	var $toc = jQuery('#toc');
	var $toc_contents = jQuery('#toc-contents');
	var $toc_outer = jQuery("#toc-outer");

	var section_offset = -40;
	var section_scroll_offset = 10;
	var sections = jQuery(selectors).not(".notoc"); //jQuery objects
	var sectionOffsets = {}; //map: id -> int
	var currentSection = false;

	$toc_outer.css({height: "auto", width: "auto"});
	$toc.css({height: "auto", width: "auto"});

	var i = 0;
	sections.each(function(idx) {
		var section = jQuery(this);
		section.attr("id", "section-" + i);
		sectionOffsets[i] = section.offset().top + section_offset;
		i++;
	});

	toc_build(section_scroll_offset, selectors);

	var tocMetrics = {
		top: $toc.position().top,
		height: $toc_outer.outerHeight(),
		width: $toc.outerWidth()
	};

	$toc_outer.css({height: $toc_outer.outerHeight(), width: $toc_outer.outerWidth()});
	$toc.css({height: $toc_outer.outerHeight(), width: $toc_outer.outerWidth()});

	var bottomBumper = jQuery('.ocpsoft-middlearea').outerHeight() + jQuery('.ocpsoft-middlearea').offset().top - 25;
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
				if ((scrollY > sectionOffsets[idx]) && (idx == numSections - 1 || scrollY < sectionOffsets[idx + 1])) {
					toggleSelection(section);
				}
			});
		}
	}

	var toggleSelection = function(section) {
		if (!section || section != currentSection) {
			if (currentSection) {
				jQuery('#' + currentSection.id + '_link').css({textDecoration: 'none', color: linkColor});
			}
			currentSection = section;
			if (section) {
				jQuery('#' + section.id + '_link').css({textDecoration: 'underline', color: '#333333'});
			}
		}
	}

	activateToTopControl();
	updateToc();
	jQuery(window).scroll(updateToc);
	
	// scroll to the selected section, if any
	if (navigator.userAgent.indexOf("Chrome") < 0 && window.location.hash)
		jQuery('html, body').animate({ scrollTop: jQuery(window.location.hash).offset().top + section_scroll_offset }, 'slow').delay(500);
}

function activateToTopControl() {
  $toTop = jQuery('#toTop');

  // skip this whole mess if we are hiding it on a device
  if ($toTop.css('display') == 'none') {
    return;
  }

  var tuckedAway = true;
  var showOffset = (20) + 'px'
  var hideOffset = '-50px';
  var triggerOffset = 250;
  jQuery(window).bind('scroll', function() {
     if (jQuery(this).scrollTop() >= triggerOffset) {
        if (tuckedAway) {
           $toTop.animate({top: showOffset});
        }
        tuckedAway = false;
     }
     else {
        if (!tuckedAway) {
           $toTop.animate({top: hideOffset}); 
        }
        tuckedAway = true;
     }
  });

  jQuery('#toTop').on('click', function() {
    jQuery('html, body').animate({ scrollTop: 0 }, 'slow');
    return false;
  });
}
