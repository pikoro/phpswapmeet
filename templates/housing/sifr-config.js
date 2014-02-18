/*****************************************************************************
It is adviced to place the sIFR JavaScript calls in this file, keeping it
separate from the `sifr.js` file. That way, you can easily swap the `sifr.js`
file for a new version, while keeping the configuration.

You must load this file *after* loading `sifr.js`.

That said, you're of course free to merge the JavaScript files. Just make sure
the copyright statement in `sifr.js` is kept intact.
*****************************************************************************/

// Make an object pointing to the location of the Flash movie on your web server.
// Try using the font name as the variable name, makes it easy to remember which
// object you're using. As an example in this file, we'll use Futura.
var gotham = { src: 'http://www.okihousing.com/templates/housing/avenir.swf' };

// Now you can set some configuration settings.
// See also <http://wiki.novemberborn.net/sifr3/JavaScript+Configuration>.
// One setting you probably want to use is `sIFR.useStyleCheck`. Before you do that,
// read <http://wiki.novemberborn.net/sifr3/DetectingCSSLoad>.

// sIFR.useStyleCheck = true;

// Next, activate sIFR:
sIFR.activate(gotham);

// If you want, you can use multiple movies, like so:
//
//    var futura = { src: '/path/to/futura.swf' };
//    var garamond = { src '/path/to/garamond.swf' };
//    var rockwell = { src: '/path/to/rockwell.swf' };
//    
//    sIFR.activate(futura, garamond, rockwell);
//
// Remember, there must be *only one* `sIFR.activate()`!

// Now we can do the replacements. You can do as many as you like, but just
// as an example, we'll replace all `<h1>` elements with the Futura movie.
// 
// The first argument to `sIFR.replace` is the `futura` object we created earlier.
// The second argument is another object, on which you can specify a number of
// parameters or "keyword arguemnts". For the full list, see "Keyword arguments"
// under `replace(kwargs, mergeKwargs)` at 
// <http://wiki.novemberborn.net/sifr3/JavaScript+Methods>.
// 
// The first argument you see here is `selector`, which is a normal CSS selector.
// That means you can also do things like '#content h1' or 'h1.title'.
//
// The second argument determines what the Flash text looks like. The main text
// is styled via the `.sIFR-root` class. Here we've specified `background-color`
// of the entire Flash movie to be a light grey, and the `color` of the text to
// be red. Read more about styling at <http://wiki.novemberborn.net/sifr3/Styling>.
sIFR.replace(gotham, {
	selector: '#homewelcome h1',
	wmode: 'transparent',
  	css: [
	'.sIFR-root { color: #852432; }'
	]
});

sIFR.replace(gotham, {
	selector: 'h1',
	wmode: 'transparent',
  	css: [
	'.sIFR-root { color: #ffffff; }'
	]
});

sIFR.replace(gotham, {
	selector: 'h2',
	wmode: 'transparent',
  	css: [
	'.sIFR-root { color: #4f4840; text-transform: uppercase; }'
	]
});

sIFR.replace(gotham, {
	selector: '#listing h3',
	wmode: 'transparent',
  	css: [
	'.sIFR-root { color: #852432; }',
	'a:link { color: #852432; text-decoration: none; }',
	'a:hover { color: #3c1017; }'
	]
});

sIFR.replace(gotham, {
	selector: 'h3',
	wmode: 'transparent',
  	css: [
	'.sIFR-root { color: #852432; }',
	'a:link { color: #852432; text-decoration: none; }',
	'a:hover { color: #3c1017; }'
	]
});

sIFR.replace(gotham, {
	selector: 'h4',
	wmode: 'transparent',
  	css: [
	'.sIFR-root { background-color: #ffffff; color: #696969; text-transform: uppercase; }',
	]
});

sIFR.replace(gotham, {
	selector: 'h5',
	wmode: 'transparent',
  	css: [
	'.sIFR-root { background-color: #ffffff; color: #696969; text-transform: uppercase; }',
	]
});
