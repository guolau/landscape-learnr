# Introduction
LandscapeLearnr is an reference site for [GeoGuessr](https://www.geoguessr.com/) players, created with a [Laravel](https://laravel.com/) backend and [Vue.js](https://vuejs.org/) frontend.

In GeoGuessr, you're dropped somewhere on Google Street View. Based on features like architecture, vegetation, and road signs, your goal is to try and guess your location. 

There are many sites that help people learn the game, like [Plonk It](https://www.plonkit.net/) and [GeoHints](https://geohints.com/). LandscapeLearnr is different in that it focuses on Earth's natural features and lets you quickly search and reference specific information.

This is a small hobby project, created mainly because I was tired of constantly having to ctrl-f on other GeoGuessr learning sites. I also wanted to get familiar with moden frontend frameworks, like Vue.js, and experiment with different development tools and practices.

# If you're here for code samples
Snippets are the core of this project: they're the short bite-sized pieces of info that you can search and reference. You can add images, Street View links, and tags to snippets. Tags can have a Tag Category. 

Here are some files that may be helpful:
* Snippet create/edit form (Vue): [resources/js/pages/snippets/components/Form.vue](https://github.com/guolau/landscape-learnr/blob/42a8fa4a3ca3cf99d7a640f6e7f4da3968a2c3dc/resources/js/pages/snippets/components/Form.vue). The most complex code in this project, but still fairly simple.
* Input components used in various frontend forms (Vue): [resources/js/components/form](https://github.com/guolau/landscape-learnr/tree/42a8fa4a3ca3cf99d7a640f6e7f4da3968a2c3dc/resources/js/components/form)
* Snippet controller (Laravel/PHP): [app/Http/Controllers/SnippetController.php](https://github.com/guolau/landscape-learnr/blob/42a8fa4a3ca3cf99d7a640f6e7f4da3968a2c3dc/app/Http/Controllers/SnippetController.php)
* Snippet store/update logic (Laravel/PHP): [app/Services/SnippetService.php](https://github.com/guolau/landscape-learnr/blob/42a8fa4a3ca3cf99d7a640f6e7f4da3968a2c3dc/app/Services/SnippetService.php)

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
* Maybe make this into a generalized reference sheet system ... the current search/snippet/tag thing is flexible enough for it
