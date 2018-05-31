## How to get access token when you are working locally

Source: https://github.com/adrianengine/jquery-spectragram/wiki/How-to-get-Instagram-API-access-token-and-fix-your-broken-feed

Instagram changed up the API to require Access Tokens to use even the most basic ‘media’ endpoint requests. 

If you already have an access token, any access token that you have generated so far does not contain these new scopes, so you will need to re-authenticate your users with the new scopes. If you don't do that, old access tokens will not work with the endpoints that require the new scopes, but will continue to work for all other endpoints.

This is a quick breakdown on the steps to get the Access Token on your local machine… and you don’t have to be a coder or developer to follow most of these steps and fix your Instagram feed.

## Step 1 — Register Application
Visit https://www.instagram.com/developer and register a new app

![](https://cdn-images-1.medium.com/max/800/1*h4pD3iKIk7rmMK9XEk4Exg.png)

![](https://cdn-images-1.medium.com/max/800/1*gWZEXI4_vJB9j5qOorBJig.png)

## Step 2 — Register New App Client
Go to Manage Clients, and hit ‘Register a New Client’ to register and gain API access

![](https://cdn-images-1.medium.com/max/800/1*wFg9qsYdeRZrUfFTnFBoOQ.png)

![](https://cdn-images-1.medium.com/max/800/1*hzizUdBB1jeqwj2U9gxdGw.png)

## Step 3 — Copy or Save Client ID
Copy the Client ID here, or at least keep this tab open, you will need the Client ID soon.

![](https://cdn-images-1.medium.com/max/800/1*MLhbCp5Q_EYTyqwfC6Dvmw.png)

## Step 4—Configure Client for Public Access
Click ‘Edit’ on your app from the Manage Clients screen, then open the ‘Security’ tab and uncheck the ‘Disable Implicit OAuth’ since we’d like the public to be able to see our feed.

![](https://cdn-images-1.medium.com/max/800/1*bzzGmjsKiMFATBWOyBcW1g.png)

Also, open the ‘Sandbox’ tab and confirm you are the ‘admin’ of this app.

![](https://cdn-images-1.medium.com/max/800/1*Noi3OrKRB9e0aKyEiatd6A.png)

> If you are a developer and you want to showcase Instagram content on a website, then you do not need to submit your app for review. By using a client in sandbox mode, you will still be able to access the last 20 media of any sandbox user that grants you permission.

## Step 5—Spin up a ‘localhost’ to access API url
One big change to the API is that you have to use an ‘Access Token’ to access media now… this is likely what broke your feed.
Spin up a localhost server for this step: You will need to run a local server to view your access token, so use your favorite MAMP, LAMP, Node whatever you use to create a local server. If you don’t use local servers, it’s super easy with MAMP to get up and running: mamp.info/en/downloads. For the purposes of this example I will use MAMP and point Apache to port 3000.

![](https://cdn-images-1.medium.com/max/800/1*r0NnGgpdvS5FcdfCY8KOEg.png)
![](https://cdn-images-1.medium.com/max/800/1*Tw9_sTsq7du_q6GDS1tl9w.png)

## Step 6—Use this API URL in a browser
Once you have a ‘localhost’ server running, you can use a simple URL in your browser to grab your access token. Open your browser and paste the url below, replacing the string after ‘client_id’ and before the ’&’ with your Client ID you saved earlier, and hit Enter to visit this URL:
https://www.instagram.com/oauth/authorize/?client_id=a52dbbed09524a0c83dd2f3620da3386&redirect_uri=http://localhost:3000&response_type=token&scope=public_content

_Remember: Replace the ‘a52dbbed09524a0c83dd2f3620da3386’ part of this url with your Client ID. You can access the Client ID again from the Instagram Developers site on the Manage Clients page._

## Step 7—Authorize it.
Visiting the URL we made with the Client ID will bring up an ‘Authorize’ screen. At this point, you are using your local server to simulate an API connection, and you will Authorize it to get a view of the Access Token response. Click ‘Authorize’.

![](https://cdn-images-1.medium.com/max/800/1*gppqxsuQ4ffaOA8Ta2pJgQ.png)

## Step 8—Ta-da! Access token.
This page appears broken, but it has a critical bit of data in the URL… right after ‘#access_token=’ you can grab your public Access Token, which also has your ID in it.
According to this response, the access token is: 1915084522.a52dbbe.76ef404eec5045e0ab349f864efe1751

![](https://cdn-images-1.medium.com/max/800/1*0doQAUpta4W4TD5dsCQw3g.png)

## Step 9—Example
Here is a quick snippet to give you an idea of how you can use the access token:

```

var Spectra = {
  instaToken: '2136707.4dd19c1.d077b227b0474d80a5665236d2e90fcf',
  instaID: ' 4dd19c1f5c7745a2bca7b4b3524124d0',
  
  init: function () {
    $.fn.spectragram.accessData = {
      accessToken: this.instaToken,
      clientID: this.instaID
    };
    
    $('.feed').spectragram('getUserFeed',{
      max: 12,
      query: 'adrianengine',
      wrapEachWith: '<div class="photo">'
    });
  }
}

Spectra.init();

```