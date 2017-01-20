# Semantic Scale

This Wordpress plugin will provide a percentage grade for presence of specific
words in a post.

Requires PHP 7 and tested with Wordpress 4.7.1

## Installation

* Follow the Wordpress instructions for [Manual Plugin Installation][1].
* Using [composer][2] from the plugin directory, run `composer install`

        cd wp-content/plugins
        git clone https://github.com/ISYS4283/semantic-scale.git
        cd semantic-scale
        composer install
        touch words.json

Then activate plugin in Wordpress admin panel.

## Word Source JSON

Create a `words.json` file in the plugin root directory with an array of period
objects containing the start and finish dates as well as a words array of
aliases.

Note that the start and finish dates are time inclusive:
00:00:00.000000 and 23:59:59.000000 respectively.

Ensure that your date periods do not overlap.
This may lead to unexpected behavior.

For example:

```json
[
	{
		"start"  : "2016-12-18",
		"finish" : "2016-12-22",
		"words"  : [
			[
				"entity relationship diagram",
				"erd",
				"e.r.d."
			],
			[
				"create, read, update, delete",
				"create read update delete",
				"crud",
				"c.r.u.d."
			]
		]
	},
	{
		"start"  : "2016-12-23",
		"finish" : "2017-01-03",
		"words"  : [
			[
				"data definition language",
				"ddl",
				"d.d.l."
			],
			[
				"data manipulation language",
				"dml",
				"d.m.l."
			]
		]
	}
]
```

## Leaderboard

If you're using the twentyseventeen theme, then you can make a symlink to a
special page template which will display a leaderboard for the network.

        cd wp-content/themes/twentyseventeen
        ln -s ../../plugins/semantic-scale/themes/twentyseventeen/leaderboard.php semantic-scale-leaderboard.php

Then create a new page and you will see "Semantic Scale Leaderboard" in the
template dropdown within the page attributes side panel.

![Screenshot of template dropdown within the page attributes side panel][3]

[1]:https://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation
[2]:https://getcomposer.org/
[3]:./docs/images/leaderboard-page-attributes.png
