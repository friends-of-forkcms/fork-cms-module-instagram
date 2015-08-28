# README

## Description
The Fork CMS Instagram module let's you display the X most recent Instagram images for one (or multiple) users.

## Preview
[ ![Image](https://i.imgur.com/8ciwbRim.png "Backend") ](https://i.imgur.com/8ciwbRi.png) 
[![Image](http://i.imgur.com/Iu5T1SDm.png "Backend") ](http://i.imgur.com/Iu5T1SD.png) 
[![Image](http://i.imgur.com/UNwoA0Wm.png "Backend") ](http://i.imgur.com/UNwoA0W.png) 

## Installation

1. Upload the `/src/Backend/Modules/Instagram` folder to your `/src/Backend/Modules` folder and your `/src/Frontend/Modules/Instagram` folder to `/src/Frontend/Modules` folder.
3. Browse to your Fork CMS backend site.
4. Go to `Settings > Modules`. Click on the install button next to the menu module.
5. Go to `Settings > Modules > Instagram`. 
6. Register a new client on the [Instagram developer page](https://instagram.com/developer/clients/manage/). Fill in your website/appname, the correct website URL and a redirect URL. The redirect URL should be similar to: `http://yourweburl.com/private/en/instagram/oauth` (fill in your website url).
7. Copy the client id and client secret to the Fork settings page and press the authenticate button. You get redirected to an Instagram page where you need to authorize the request. After that, you get redirected back to the Fork CMS settings and you’re logged in.
8. Go to `Modules > Instagram` and press the `add user` button. Fill in an Instagram username and save. A widget is now generated, which you can insert into any page. 
5. Have fun!

## TODO
- [ ] Create Instagram feeds based on hashtags

## Bugs

If you encounter any bugs, please create an issue and I'll try to fix it (or feel free to fix it yourself with a pull-request).

## Discussion
- Twitter: [@jessedobbelaere](https://www.twitter.com/jessedobbelaere)
- E-mail: <jesse@dobbelaere-ae.be> for any questions or remarks.

Credits to @waldocosman for his original Instagram module, the inspiration for this module.
