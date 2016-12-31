# Semantic Scale

This Wordpress plugin will provide a percentage grade for presence of specific
words in a post.

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
		"start"  : "2016-12-22",
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

[1]:https://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation
[2]:https://getcomposer.org/
