
<p align="center">
  <a href="http://gulpjs.com">
    <img height="157" title="Gulp" width="84" src="https://raw.githubusercontent.com/gulpjs/artwork/master/gulp-2x.png">
    <img height="157" title="SASS" width="144" src="http://sass-lang.com/assets/img/logos/logo-b6e1ef6e.svg">
    <img height="157" title="Wordpress" width="190" src="http://s.w.org/about/images/wordpress-logo-notext-bg.png">
    <img height="157" title="Browser Sync" width="180" src="https://browsersync.io/brand-assets/logo-red.png">
  </a>
</p>
Gulp and Wordpress Theme
===

Hi. I'm a starter wp theme called `gulp-theme`, my moto is making wp development faster than ever and deploying theme easier than ever and lastly site will load faster than ever.

How awesome, isn't it? Let me describe how would you make it happen.

--Remember-- I am a virgin theme, that's why I dont have my style, you can make me as you like me.

In-built Features
-----------------
* Bootstrap sass, js both compiled and attached to theme.
* jQuery compiled before bootstrap js and attached to theme. 
* Wordpress responsive menu `sliknav` sass js comiled and attached to theme.  
* In built Image Compression. (related to loading speed).
* JS and SASS hint for comilation error will come at cmd.

Environment
------------
Following things should be installed in your system.
* Node JS and NPM. for linux follow https://nodejs.org/en/download/package-manager/.
* check `node -v` and `npm-v`
* Installing Gulp & Bower & node sass by- `npm install -g gulp bower node-sass`

Installation
------------
After setting up configuration you can follow the steps given below.
* Open CMD or Gitbas or Putty to go dev folder and cd to wp theme directory like /project/wp-content/themes
* Clone this repo on to thems directory by - `git clone https://github.com/citytechcorp-php-ekta/gulp-theme`
* Then make it active by wp-admin > Apparence > theme.
* `bower install`
* `npm install`
* Follow the `Browser Sync` Method are following...

Intoduction to Browser Sync
-------------------------
* Open `gulpfile.js` from the theme root.
* Go bottom of the file and place projects url like `http://192.168.0.99/wp/test` to `proxy:` inside `browserSync.init` function scope.
* Now go to cmd and write `gulp watch` then edit any css, js file it will refresh browser autometically.

Where to write SASS and js?
---------------------------
After successful installation the following two directory will be your working Dir.
* FOR SASS `assets-input/css/input.scss` write here your sass code.
* For Custom js DONT ADD IT HEADER OR ENQUE IT FROM FUNCTIONS, just place the js file as many as you can at `assets-input/js/` directory thats it. Js will taking care all of script and make it available at frontend.
* For sass images put images at `assets-input/images` directory. 

Now you're ready to go! The next step is easy to say. :)

Good luck!
