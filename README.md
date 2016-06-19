# README

## Description
The Fork CMS Instagram module let's you display the X most recent Instagram images for one (or multiple) users.

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

## TODO
- [ ] Create Instagram feeds based on hashtags

## Bugs
If you encounter any bugs, please create an issue and I'll try to fix it (or feel free to fix it yourself with a pull-request).

## Discussion
- Twitter: [@jessedobbelaere](https://www.twitter.com/jessedobbelaere)
- E-mail: <jesse@dobbelaere-ae.be> for any questions or remarks.
- Slack: [Fork CMS Slack channel](https://fork-cms.herokuapp.com)

Credits to @waldocosman for his original Instagram module, the inspiration for this module.
