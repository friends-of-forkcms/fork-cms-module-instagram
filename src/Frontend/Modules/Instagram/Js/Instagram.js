/**
 * Javascript for the Instagram module
 */
jsFrontend.instagram =
{
	/**
	 * The instagram variables
	 */
	settings:
	{
		user_id: jsFrontend.data.get('Instagram.user.user_id'),
		container: $('.js-instagram-container')
	},

	/**
	 * Constructor
	 */
	init: function()
	{
		jsFrontend.instagram.loadRecentMedia();
	},

	/**
	 * Load the recent media from a certain user using Ajax
	 */
	loadRecentMedia: function()
	{
		$.ajax({
			data: {
				fork: {module: 'Instagram', action: 'LoadRecentMedia'},
				userId: jsFrontend.instagram.settings.user_id
			},
			success: function (result) {
				if (result.code === 200) {
					$(result.data).each(function(i,val)
					{
						jsFrontend.instagram.insertMedia(val);
					});
				}
			},
			error: function (request, status, error) {
				console.log(error);
			}
		});
	},

	/**
	 * Insert the media thumbnail into the DOM
	 *
	 * @param mediaObj
	 */
	insertMedia: function(mediaObj)
	{
		var list = $('<li style="display: none; "></li>');
		var title = '';
		if(mediaObj.caption !== null) {
		    title = mediaObj.caption.text;
        }
		var anchor = $('<a href="' + mediaObj.link + '" title="' + title + '" target="_blank"></a>');
		var thumb = $('<img src="' + mediaObj.images.thumbnail.url + '" alt="' + title + '" />');

		// Append to container
		$(thumb).appendTo(anchor);
		$(anchor).appendTo($(list));
		$(list).appendTo($(jsFrontend.instagram.settings.container)).fadeIn();
	}
};

$(jsFrontend.instagram.init);
