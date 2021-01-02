// assets/js/app.js
// 

// loads the jquery package from node_modules
const $ = require('jquery')

// window.jQuery = $;

// create global $ and jQuery variables
global.$ = global.jQuery = $;

require('bootstrap');

require('@fortawesome/fontawesome-free')

require('select2');


require('../css/app.scss');
require('../css/style.css');


$('.select2').select2()

//Style de coloration syntaxique
require('highlightjs/styles/a11y-dark.css')

const hljs = require('highlightjs');

hljs.initHighlightingOnLoad();

var greet = require('./greet');


$(document).ready(function() {
   $('body').prepend('<h1>'+ greet('jill') +'</h1>');
});

console.log('Hello Webpack Encore 23/05/20');