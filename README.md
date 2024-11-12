# Introduction
LandscapeLearnr is an reference site for [GeoGuessr](https://www.geoguessr.com/) players, created with a [Laravel](https://laravel.com/) backend and [Vue.js](https://vuejs.org/) frontend.

In GeoGuessr, you're dropped somewhere on Google Street View. Based on features like architecture, vegetation, and road signs, your goal is to try and guess your location. 

There are many sites that help people learn the game, like [Plonk It](https://www.plonkit.net/) and [GeoHints](https://geohints.com/). LandscapeLearnr is different in that it focuses on Earth's natural features and lets you quickly search
and reference specific information.

This is a small hobby project, created mainly because I was tired of constantly having to ctrl-f on other GeoGuessr learning sites. 

Thank you for taking a look!

# Roadmap
Here's a tentative list of things I'd like to do at some point:
* Write automated tests
* Improve snippet image browsing functionality, like ability to use keyboard arrow keys
* When adding tags to snippets, suggest tags based on user input and existing tags
* On the main search page, add sorting by date, title, relevance, etc.
* When creating and editing snippets, add ability to easily reorder and remove images
* Add tools for creating and editing tags and categories
* Add DB table indexes
* Add different statuses and visibility for snippets (draft, unlisted, published, etc)
* Lock editing when someone else is editing a snippet/tag/category/etc
* More intelligent search that accounts for snippet body text
