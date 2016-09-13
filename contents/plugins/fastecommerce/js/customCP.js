
function showSuggestBox()
{
	$('.suggest-box').fadeIn('slow', function() {
		$('.suggest-box-content').html('');
	});
}

function hideSuggestBox()
{
	$('.suggest-box').fadeOut('fast', function() {
		$('.suggest-box-content').html('');
	});
}

function suggestBoxContent(str)
{
	$('.suggest-box-content').html(str);
}


$(document).ready(function(){

	$('.close-box').click(function(){
		hideSuggestBox();
	});

	$('.tab-link > li > span').click(function(){
		var target=$(this).data('target');

		var tabsBox=$(this).parent().parent().parent();

		var tabsLink=tabsBox.children('.tab-link');

		var tabsContent=tabsBox.children('.tabs-content');

		tabsLink.children('li').each(function(index, el) {
			$(this).children('span').removeClass('tab-active');
		});

		tabsContent.children('div').each(function(index, el) {
			$(this).hide();
		});

		$(this).addClass('tab-active');

		$(this).parent().parent().parent().children('.tabs-content').children(target).show();
	});

	
});