#This is a rock-simple PHP calendar

It uses the venerable Unix utility `cal` to generate a text calendar, a simple text document containing the calendar events, and a mixture of CSS and JavaScript to create links to those events.

Naturally, it only works on a Unix or Linux server, and since I'm a total Prototype-head, it uses the Prototype JavaScript library, (so no jQuery if you know what's good for you!).

##Instructions
Upload the entire project to your server, and edit the `data/data.txt` files to reflect your own calendar. 

~~~~
2011-03-11 http://apple.com Apple, Inc.
2011-03-05 http://walterdavisstudio.com Walter Davis Studio
2010-12-31 http://timessquare.com Times Square
2011-03-11 http://store.apple.com Apple Store
~~~~

Edit the `lib/cal.php` line 2 to reflect the time zone you want to use, unless you are in the US East Coast time zone.

Add the links to prototype.js and cal.js to your HTML page. Create a DIV on your page with the classname `minical`. Preview in a browser, and you should see a tiny calendar in the page.