#This is a rock-simple PHP calendar

It uses the venerable Unix utility `cal` to generate a text calendar, a simple text document containing the calendar events, and a mixture of CSS and JavaScript to create links to those events.

Naturally, it only works on a Unix or Linux server, and since I'm a total Prototype-head, it uses the Prototype JavaScript library, (so no jQuery if you know what's good for you!).

##Instructions
Upload the entire project to your server, and edit the `index.html` and `data/data.txt` files to reflect your own calendar. The calendar will appear on your page in any DIV that has the classname `minical` applied to it.