var megaLoaded=false;
megaMenuLoad=function(){
	if(megaLoaded){
		return;
	}
	megaLoaded=true;
    ApplyMenuToggle();
    SizeAndPositionMenus();

    // Marketplaces menu override.

    var _timeout = null;

    function showFlyout(li) {
        var flyout = li.children('ul');
        li.addClass('active-flyout');
        flyout.css({ position: 'absolute', top: -9999, left: -9999, display: 'block' });
        var max = Math.max(flyout.outerHeight(), li.parent().outerHeight());
        li.parent().add(flyout).height(max);
        flyout.css({ top: (-1 * li.position().top), left: li.parent().width() });
    }

    function hideFlyout(li) {
        li.removeClass('active-flyout').children('ul').hide();
        li.parent().css('height', 'auto');
    }

    function onhover() {
        if (_timeout !== null) {
            clearTimeout(_timeout);
            _timeout = null;
        }
        var li = $j(this);
        li.siblings('.active-flyout').each(function() { hideFlyout($j(this)); });
        if (li.children('ul').length) showFlyout(li);
    }

    function offhover() {
        if (_timeout !== null) {
            clearTimeout(_timeout);
            _timeout = null;
        }
        var li = $j(this);
        if (li.children('ul').length) {
            _timeout = setTimeout(function() { hideFlyout(li); }, 400);
        }
    }

    $j('.megaMenu > .navMarketplaces > ul.hoverDisplay').children().hover(onhover, offhover);
	
	// Apply class names due to quirks mode not supporting the ' > ' css selector.
	var lis = $j('.megaMenu > .navMarketplaces > ul.hoverDisplay > li');
	lis.addClass('nm-li-1');
	lis.children('a').addClass('nm-a-2');
	lis.children('ul').addClass('nm-ul-2');
	lis = null;
}

function ApplyMenuToggle() {
    // setup the top navigation menu
    $j(".megaMenu > li").hover(
        function() {
            $j(this).children("ul").show();
        },
        function() {
			// Need to hide all navMarketplaces fly-outs FIRST due to wierd browser issue.
			$j(this).find('.nm-ul-2').hide();
            $j(this).children("ul").hide();
        });
}
$j(document).ready(function(){megaMenuLoad();});
function SizeAndPositionMenus() {
    var windowRightOffset = 22;
    var menuColWidth = 147;
    var windowWid = $j(window).width() - windowRightOffset;

    $j(".hoverDisplay").each(function() {
        var $this = $j(this);
        if ($j.isFunction($j.fn.bgiframe)) {
            $this.bgiframe(); // needed for ie6 only
        }

        var secondaryOptions = $this.children("li");
        var tertiaryULCount = 0;
        var numChildren = secondaryOptions.size();
        if (numChildren == 0) { numChildren = 1; return; }

        // Override this value for the marketplaces menu flyouts.
        if ($this.parent().is('.navMarketplaces')) {
            numChildren = 1;
        }

        secondaryOptions.each(function() {
            tertiaryULCount += $j(this).children("ul").size();
        });
        if (tertiaryULCount == 0) { numChildren = 1; }

        var wid = menuColWidth * numChildren;
        oldwidth = $this.css('width');
        if(!oldwidth.length){
          $this.css("width", wid);
        }

        var origLeft = $this.parent().offset().left;
        var excess = 0;

        if (origLeft + wid > windowWid) {
            excess = (origLeft + wid) - windowWid;
            if (excess > origLeft) { excess = origLeft; }
        }

        $this.css("left", (excess * -1) + "px");
    });
}