# Instagram module for Fork CMS

> The Instagram module let's you display the X most recent Instagram images for one (or multiple) users.

**Download:**
* [Module for Fork CMS 5.*](https://github.com/friends-of-forkcms/fork-cms-module-instagram/archive/master.zip)
* [Module for Fork CMS 4.*](https://github.com/friends-of-forkcms/fork-cms-module-instagram/archive/2.0.0.zip)
* [Module for Fork CMS 3.7.* to 3.9.*](https://github.com/friends-of-forkcms/fork-cms-module-instagram/archive/1.0.1.zip)

**Features:**
* Widget: recent images from Instagram feed from one or multiple users.

## Preview
[ ![Image](http://i.imgur.com/6pT2cYdm.png "Backend") ](http://i.imgur.com/6pT2cYd.png)
[ ![Image](http://i.imgur.com/YdBq9YZm.png "Backend") ](http://i.imgur.com/YdBq9YZ.png)
[ ![Image](http://i.imgur.com/zLyr5Ftm.png "Backend") ](http://i.imgur.com/zLyr5Ft.png)

## Installation

1. Upload the `/src/Backend/Modules/Instagram` folder to your `/src/Backend/Modules` folder and your `/src/Frontend/Modules/Instagram` folder to `/src/Frontend/Modules` folder.
2. Browse to your Fork CMS backend site.
3. Go to `Settings > Modules`. Click on the install button next to the menu module.
4. Go to `Settings > Modules > Instagram`.
5. Register a new client on the [Instagram developer page](https://instagram.com/developer/clients/manage/). Fill in your website/appname, the correct website URL and a redirect URL. The redirect URL should be similar to: `http://yourweburl.com/private/en/instagram/oauth` (fill in your website url).
6. Copy the client id and client secret to the Fork settings page and press the authenticate button. You get redirected to an Instagram page where you need to authorize the request. After that, you get redirected back to the Fork CMS settings and you’re logged in.
7. Have fun!

## Contributing

It would be great if you could help us improve the module. GitHub does a great job in managing collaboration by providing different tools, the only thing you need is a [GitHub](https://github.com/) login.

* Use **Pull requests** to add or update code
* **Issues** for bug reporting or code discussions

More info on how to work with GitHub on [help.github.com](https://help.github.com).

## License

The module is licensed under MIT. In short, this license allows you to do everything as long as the copyright statement stays present.
